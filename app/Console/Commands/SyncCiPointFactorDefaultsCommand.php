<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Services\PointFactorDefaultsService;
use App\Services\TeamCabinetsTenantDefaultsService;
use Illuminate\Console\Command;

class SyncCiPointFactorDefaultsCommand extends Command
{
    protected $signature = 'tenant:sync-point-factor-defaults {tenant? : Tenant ID (defaults to team_cabinets_tenant.tenant_id)}';

    protected $description = 'Apply CI commission defaults to point_factor_defaults (Representative 0.20, others 0.24)';

    public function handle(
        PointFactorDefaultsService $service,
        TeamCabinetsTenantDefaultsService $defaultsService
    ): int {
        $tenantId = $this->argument('tenant') ?? $defaultsService->targetTenantId();
        $tenant = Tenant::query()->find($tenantId);

        if (! $tenant) {
            $this->error("Tenant [{$tenantId}] not found.");

            return self::FAILURE;
        }

        $count = 0;

        $tenant->run(function () use ($service, &$count) {
            $count = $service->syncFromCiConfig();
        });

        $this->info("Synced {$count} point factor default row(s) for tenant [{$tenantId}].");

        foreach ($service->ciDefaultsByRoleName() as $role => $pct) {
            $this->line("  {$role}: {$pct} (".number_format((float) $pct * 100, 2).'%)');
        }

        return self::SUCCESS;
    }
}
