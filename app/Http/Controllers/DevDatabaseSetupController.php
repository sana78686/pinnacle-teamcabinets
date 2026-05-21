<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;

class DevDatabaseSetupController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $this->authorizeRequest($request);

        $log = [];
        $errors = [];

        $run = function (string $label, string $command, array $parameters = []) use (&$log, &$errors): void {
            try {
                $exit = Artisan::call($command, $parameters);
                $log[] = [
                    'step' => $label,
                    'command' => $this->commandLine($command, $parameters),
                    'exit_code' => $exit,
                    'output' => trim(Artisan::output()) ?: '(no output)',
                ];
                if ($exit !== 0) {
                    $errors[] = "{$label} failed (exit {$exit}).";
                }
            } catch (\Throwable $e) {
                $errors[] = "{$label}: {$e->getMessage()}";
                $log[] = [
                    'step' => $label,
                    'command' => $this->commandLine($command, $parameters),
                    'exit_code' => 1,
                    'output' => $e->getMessage(),
                ];
            }
        };

        $run('Central migrate:fresh + seed', 'migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);

        if (config('dev_tools.seed_demo_tenants')) {
            $run('Seed demo tenants (central)', 'db:seed', [
                '--class' => 'TenantSeeder',
                '--force' => true,
            ]);
        }

        $tenantCount = Tenant::query()->count();

        if ($tenantCount > 0) {
            // Shared DB: do not use tenants:migrate-fresh (db:wipe drops the whole database).
            // New tenant-only schema is in database/migrations/ (2026_05_*); optional legacy path:
            $run('Pending tenant-folder migrations', 'migrate:tenant-schema', [
                '--force' => true,
            ]);

            if (config('dev_tools.seed_team_cabinets_defaults')) {
                $tcId = config('team_cabinets_tenant.tenant_id', 'team-cabinets');
                if (Tenant::query()->find($tcId)) {
                    $run('Team Cabinets tenant defaults', 'tenants:seed', [
                        '--tenants' => [$tcId],
                        '--class' => 'TeamCabinetsTenantDataSeeder',
                        '--force' => true,
                    ]);
                }
            }
        } else {
            $log[] = [
                'step' => 'Tenant migrate/seed',
                'command' => '(skipped)',
                'exit_code' => 0,
                'output' => 'No tenants in central DB. Enable DEV_SETUP_SEED_DEMO_TENANTS=true or create tenants first.',
            ];
        }

        $html = view('dev.migrate-fresh-seed-result', [
            'log' => $log,
            'errors' => $errors,
            'success' => $errors === [],
            'tenantCount' => $tenantCount,
            'appEnv' => config('app.env'),
        ])->render();

        return response($html, $errors === [] ? 200 : 500)->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function authorizeRequest(Request $request): void
    {
        $token = config('dev_tools.setup_token');
        $isProduction = app()->environment('production');
        $allowedInProd = config('dev_tools.allow_in_production');

        if ($isProduction && ! $allowedInProd) {
            abort(403, 'Database setup route is disabled in production.');
        }

        if (empty($token)) {
            if (! app()->environment('local')) {
                abort(403, 'Set DEV_SETUP_TOKEN in .env to use this route outside local.');
            }

            return;
        }

        $given = (string) $request->query('token', '');

        if (! hash_equals($token, $given)) {
            abort(403, 'Invalid or missing token.');
        }
    }

    /** @param  array<string, mixed>  $parameters */
    protected function commandLine(string $command, array $parameters): string
    {
        $parts = ['php artisan', $command];

        foreach ($parameters as $key => $value) {
            if (is_bool($value)) {
                if ($value) {
                    $parts[] = $key;
                }
                continue;
            }
            $parts[] = "{$key}={$value}";
        }

        return implode(' ', $parts);
    }
}
