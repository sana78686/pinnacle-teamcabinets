<?php

namespace App\Services;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * CI_SYSTEM_FLOW §5.1 — automatic steps after tenant + admin user exist.
 */
class TenantProvisioningService
{
    public function provision(Tenant $tenant, User $admin, bool $sendEmails = true): void
    {
        app(TenantSubscriptionService::class)->startTrial($tenant);

        TenantRoleService::ensureDefaultRoles();

        if (! $admin->hasRole('Admin')) {
            $admin->assignRole('Admin');
        }

        $tenant->run(function () {
            app(ManageOtherPageContentService::class)->ensureDefaults();
            app(ManageEmailsContentService::class)->ensureDefaults();
            app(TaxValuesService::class)->ensureDefaults();
        });

        if ($sendEmails) {
            TenantRegistrationMailer::send($tenant);
        }

        Log::info('Tenant provisioning completed (§5.1).', ['tenant_id' => $tenant->id]);
    }
}
