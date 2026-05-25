<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Services\TenantProvisioningService;
use App\Services\TenantRoleService;
use Illuminate\Database\Seeder;

class TenantRoleSeeder extends Seeder
{
    /**
     * Central: Spatie roles + permissions (shared).
     * Per-tenant rows (point_factor_defaults, taxes, …) run inside each tenant context.
     */
    public function run(): void
    {
        TenantRoleService::ensureDefaultRoles();

        $tenants = Tenant::query()->get();
        if ($tenants->isEmpty()) {
            return;
        }

        $provisioning = app(TenantProvisioningService::class);
        foreach ($tenants as $tenant) {
            $provisioning->applyScopedDefaults($tenant);
        }
    }
}
