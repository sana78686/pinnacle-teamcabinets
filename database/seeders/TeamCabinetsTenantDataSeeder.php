<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Services\TeamCabinetsTenantDefaultsService;
use Illuminate\Database\Seeder;

class TeamCabinetsTenantDataSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = app(TeamCabinetsTenantDefaultsService::class)->targetTenantId();
        $tenant = Tenant::query()->find($tenantId);

        if (! $tenant) {
            $this->command?->warn("Tenant [{$tenantId}] not found. Skip TeamCabinetsTenantDataSeeder.");

            return;
        }

        $tenant->run(function () {
            $applied = app(TeamCabinetsTenantDefaultsService::class)->apply();
            $countyCount = app(\App\Services\SalesTaxCountiesService::class)->countyCount();

            $this->command?->info('Team Cabinets defaults: '
                .$applied['taxes'].' taxes, '
                .$applied['terms'].' terms, '
                .$applied['point_factors'].' commission roles, '
                .$countyCount.' sales tax counties, '
                .($applied['order_catalogs'] ?? 0).' catalogs, '
                .($applied['order_products'] ?? 0).' order products.');
        });
    }
}
