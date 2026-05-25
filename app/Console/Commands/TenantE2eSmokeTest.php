<?php

namespace App\Console\Commands;

use App\Models\ManageEmailsContent;
use App\Models\Order;
use App\Models\Tenant;
use App\Models\User;
use App\Services\CatalogSalesAnalyticsService;
use App\Services\CommissionCalculationService;
use App\Services\ManageEmailsContentService;
use App\Services\TenantProvisioningService;
use App\Services\TenantRoleService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class TenantE2eSmokeTest extends Command
{
    protected $signature = 'tenant:e2e-smoke
                            {--tenant-id= : Reuse existing tenant id instead of creating one}
                            {--keep : Do not delete the test tenant when finished}
                            {--report= : Write markdown report to this path}';

    protected $description = 'Smoke-test tenant provisioning, multi-role users, and core flows; writes a report.';

    /** @var list<array{step: string, status: string, detail: string}> */
    protected array $results = [];

    protected bool $createdTenant = false;

    protected ?string $testTenantId = null;

    public function handle(
        TenantProvisioningService $provisioning,
        CommissionCalculationService $commission,
        CatalogSalesAnalyticsService $catalogSales,
    ): int {
        $this->info('Team Cabinets — tenant E2E smoke test');
        $reportPath = $this->option('report')
            ?: base_path('docs/E2E-Test-Report.md');

        try {
            $this->step('Central migrations', function () {
                Artisan::call('migrate', ['--force' => true]);
                $out = trim(Artisan::output());
                if (str_contains($out, 'FAIL') || str_contains($out, 'error')) {
                    throw new \RuntimeException($out ?: 'migrate failed');
                }

                return 'migrate completed';
            });

            $this->step('Permission seeder (roles)', function () {
                if (! class_exists(Role::class)) {
                    throw new \RuntimeException('Spatie Role model missing');
                }
                Artisan::call('db:seed', ['--class' => 'PermissionTableSeeder', '--force' => true]);

                return 'PermissionTableSeeder ran';
            });

            $tenant = $this->resolveTenant();
            $this->testTenantId = $tenant->id;

            /** @var User $admin */
            $admin = $this->step('Create / find tenant admin', function () use ($tenant, $provisioning) {
                $admin = User::query()
                    ->where('tenant_id', $tenant->id)
                    ->where(function ($q) {
                        $q->where('user_type', 'admin')
                            ->orWhereHas('roles', fn ($r) => $r->where('name', 'admin'));
                    })
                    ->first();

                if (! $admin) {
                    $admin = User::query()->create([
                        'tenant_id' => $tenant->id,
                        'name' => 'E2E Admin',
                        'email' => 'e2e-admin-'.$tenant->id.'@smoke.test',
                        'password' => bcrypt('password'),
                        'verified' => 1,
                        'user_type' => 'admin',
                    ]);
                    $admin->assignCiRole('admin');
                    $provisioning->provision($tenant, $admin, sendEmails: false);
                }

                return $admin;
            });

            $rolesToTest = [
                'representatives',
                'distributors',
                'dealers',
                'customers',
                'affiliate',
            ];

            foreach ($rolesToTest as $role) {
                $this->step("Create user role: {$role}", function () use ($tenant, $role, $admin) {
                    $email = 'e2e-'.$role.'-'.$tenant->id.'@smoke.test';
                    $user = User::query()->firstOrCreate(
                        ['email' => $email],
                        [
                            'tenant_id' => $tenant->id,
                            'name' => 'E2E '.ucfirst($role),
                            'password' => bcrypt('password'),
                            'verified' => 1,
                            'parent_id' => $role !== 'representatives' ? $admin->id : 0,
                            'point_factor' => 0.05,
                        ]
                    );
                    $user->assignCiRole($role);

                    if ($user->getCiRole() !== TenantRoleService::normalizeCiRoleName($role)) {
                        throw new \RuntimeException('getCiRole mismatch: '.$user->getCiRole());
                    }

                    return $user;
                });
            }

            $tenant->run(function () use ($commission, $catalogSales, $admin) {
                $this->step('Tenant context initialized', function () {
                    if (! tenant()) {
                        throw new \RuntimeException('tenancy not initialized');
                    }

                    return 'tenant id: '.tenant('id');
                });

                $this->step('Email templates seeded', function () {
                    app(ManageEmailsContentService::class)->ensureDefaults();
                    $count = ManageEmailsContent::query()->count();
                    if ($count < 20) {
                        throw new \RuntimeException("Only {$count} email templates");
                    }

                    return "{$count} templates in manage_emails_content";
                });

                $this->step('Commission calculation (cart)', function () use ($admin, $commission) {
                    $dealer = User::query()->where('user_type', 'dealers')->first()
                        ?? User::query()->whereHas('roles', fn ($q) => $q->where('name', 'dealers'))->first();
                    if (! $dealer) {
                        throw new \RuntimeException('No dealer user for commission test');
                    }
                    $result = $commission->calculate(1000.0, $dealer);
                    if (! isset($result['mgfCommission'], $result['repCommission'])) {
                        throw new \RuntimeException('Invalid commission result shape');
                    }

                    return 'mfg='.($result['mgfCommission'] ?? 0).', rep='.($result['repCommission'] ?? 0);
                });

                $this->step('Catalog sales analytics', function () use ($catalogSales) {
                    $data = $catalogSales->catalogSalesByPeriod();
                    foreach (['total', 'quarter', 'month', 'week'] as $key) {
                        if (! array_key_exists($key, $data)) {
                            throw new \RuntimeException("Missing period {$key}");
                        }
                    }

                    return 'periods ok; catalogs in total: '.count($data['total'] ?? []);
                });

                $this->step('Orders table + state scope', function () {
                    if (! Schema::hasTable('orders')) {
                        throw new \RuntimeException('orders table missing');
                    }
                    $completed = Order::query()->where('state', 1)->count();

                    return "completed orders: {$completed}";
                });

                $this->step('Admin uploads table', function () {
                    if (! Schema::hasTable('admin_uploads')) {
                        throw new \RuntimeException('admin_uploads missing — run migrations');
                    }

                    return 'admin_uploads exists';
                });

                $this->step('Manage document table', function () {
                    if (! Schema::hasTable('manage_document')) {
                        throw new \RuntimeException('manage_document missing');
                    }

                    return 'manage_document exists';
                });

                $this->step('Manage inventories table', function () {
                    if (! Schema::hasTable('manage_inventories')) {
                        throw new \RuntimeException('manage_inventories missing');
                    }

                    return 'manage_inventories exists';
                });

                $this->step('Tenant routes registered', function () {
                    $required = [
                        'tenant_dashboard',
                        'tenant_dashboard_catalog_sales',
                        'tenant_order_workspace',
                        'tenant_commission_report_index',
                        'tenant_hierarchy_index',
                        'tenant_admin_uploads_index',
                        'tenant_setting_manage_documentation_list',
                        'tenant_inventory_admin_index',
                        'tenant_setting_email_settings',
                    ];
                    $missing = [];
                    foreach ($required as $name) {
                        if (! Route::has($name)) {
                            $missing[] = $name;
                        }
                    }
                    if ($missing !== []) {
                        throw new \RuntimeException('Missing routes: '.implode(', ', $missing));
                    }

                    return count($required).' routes present';
                });
            });

            $this->writeReport($reportPath);
            $this->newLine();
            $this->info("Report written: {$reportPath}");

            $failed = collect($this->results)->where('status', 'FAIL')->count();
            if ($failed > 0) {
                $this->error("{$failed} step(s) failed.");

                return self::FAILURE;
            }

            $this->info('All smoke steps passed.');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->record('Fatal', 'FAIL', $e->getMessage());
            $this->writeReport($reportPath);
            $this->error($e->getMessage());

            return self::FAILURE;
        } finally {
            if ($this->createdTenant && ! $this->option('keep') && $this->testTenantId) {
                try {
                    $t = Tenant::find($this->testTenantId);
                    if ($t) {
                        User::query()->where('tenant_id', $t->id)->delete();
                        $t->domains()->delete();
                        $t->delete();
                        $this->warn("Removed test tenant: {$this->testTenantId}");
                    }
                } catch (\Throwable $e) {
                    $this->warn('Cleanup skipped: '.$e->getMessage());
                }
            }
        }
    }

    protected function resolveTenant(): Tenant
    {
        $id = $this->option('tenant-id');
        if ($id) {
            $tenant = Tenant::find($id);
            if (! $tenant) {
                throw new \RuntimeException("Tenant not found: {$id}");
            }

            return $tenant;
        }

        $id = 'e2e-'.Str::lower(Str::random(8));
        $this->createdTenant = true;

        /** @var Tenant $tenant */
        $tenant = $this->step('Create tenant', function () use ($id) {
            $tenant = Tenant::query()->create([
                'id' => $id,
                'name' => 'E2E Test '.$id,
            ]);
            $central = config('tenancy.central_domains')[0] ?? 'localhost';
            $tenant->domains()->create([
                'domain' => $id.'.'.$central,
            ]);
            Artisan::call('tenants:migrate', ['--tenants' => [$id], '--force' => true]);

            return $tenant;
        });

        return $tenant;
    }

    protected function step(string $label, callable $fn): mixed
    {
        try {
            $result = $fn();
            $detail = match (true) {
                $result === null => 'ok',
                is_scalar($result) => (string) $result,
                $result instanceof User => $result->email.' ('.$result->getCiRole().')',
                $result instanceof Tenant => 'id='.$result->id,
                is_object($result) => $result::class,
                default => gettype($result),
            };
            $this->record($label, 'PASS', $detail);
            $this->line("<fg=green>✓</> {$label}: {$detail}");

            return $result;
        } catch (\Throwable $e) {
            $this->record($label, 'FAIL', $e->getMessage());
            $this->line("<fg=red>✗</> {$label}: {$e->getMessage()}");

            throw $e;
        }
    }

    protected function record(string $step, string $status, string $detail): void
    {
        $this->results[] = compact('step', 'status', 'detail');
    }

    protected function writeReport(string $path): void
    {
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $pass = collect($this->results)->where('status', 'PASS')->count();
        $fail = collect($this->results)->where('status', 'FAIL')->count();
        $lines = [
            '# Team Cabinets — E2E Smoke Test Report',
            '',
            '**Generated:** '.now()->toDateTimeString(),
            '**Command:** `php artisan tenant:e2e-smoke`',
            '**Tenant:** '.($this->testTenantId ?? 'n/a'),
            '',
            '## Summary',
            '',
            "| Result | Count |",
            "|--------|-------|",
            "| PASS | {$pass} |",
            "| FAIL | {$fail} |",
            '',
            '## Steps',
            '',
            '| Step | Status | Detail |',
            '|------|--------|--------|',
        ];

        foreach ($this->results as $r) {
            $detail = str_replace('|', '\\|', $r['detail']);
            $lines[] = "| {$r['step']} | {$r['status']} | {$detail} |";
        }

        $lines[] = '';
        $lines[] = '## Manual UI checks (not automated)';
        $lines[] = '';
        $lines[] = '- Log in as admin on tenant domain → Dashboard, order tracker, catalog sales widget';
        $lines[] = '- Settings → Email Settings → edit template + test SMTP';
        $lines[] = '- Settings → Documentation / Admin uploads / Inventory admin (Vue CRUD)';
        $lines[] = '- Rep user → My Downloads / My Uploads';
        $lines[] = '- Order workspace → create order through checkout (browser)';
        $lines[] = '- Commission report → filter + CSV export';
        $lines[] = '';

        if ($fail > 0) {
            $lines[] = '## Errors to fix';
            $lines[] = '';
            foreach ($this->results as $r) {
                if ($r['status'] === 'FAIL') {
                    $lines[] = '- **'.$r['step'].'**: '.$r['detail'];
                }
            }
        }

        file_put_contents($path, implode("\n", $lines));
    }
}
