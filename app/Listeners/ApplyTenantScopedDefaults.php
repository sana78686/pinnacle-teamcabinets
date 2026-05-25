<?php

namespace App\Listeners;

use App\Models\Tenant;
use App\Services\TenantProvisioningService;
use Stancl\Tenancy\Events\TenantCreated;

/**
 * Seed tenant-scoped rows (commission defaults, taxes, emails, etc.) when a tenant record is created.
 */
class ApplyTenantScopedDefaults
{
    public function __construct(
        protected TenantProvisioningService $provisioning,
    ) {}

    public function handle(TenantCreated $event): void
    {
        $tenant = $event->tenant;

        if (! $tenant instanceof Tenant) {
            return;
        }

        $this->provisioning->applyScopedDefaults($tenant);
    }
}
