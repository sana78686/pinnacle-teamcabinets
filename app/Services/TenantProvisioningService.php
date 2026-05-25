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

        if (! $admin->isAdmin()) {
            $admin->assignCiRole('admin');
        }

        $this->applyScopedDefaults($tenant, withWelcomeNotification: true);

        if ($sendEmails) {
            TenantRegistrationMailer::send($tenant);
        }

        Log::info('Tenant provisioning completed (§5.1).', ['tenant_id' => $tenant->id]);
    }

    /**
     * Tenant-scoped defaults (point factors, taxes, email templates, etc.).
     * Safe to call from TenantCreated and after admin registration.
     */
    public function applyScopedDefaults(Tenant $tenant, bool $withWelcomeNotification = false): void
    {
        $tenant->run(function () use ($withWelcomeNotification): void {
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'user_type')) {
                User::query()
                    ->whereNull('user_type')
                    ->each(function (User $user): void {
                        $ci = $user->getCiRole();
                        if ($ci !== '') {
                            $user->forceFill(['user_type' => $ci])->saveQuietly();
                        }
                    });
            }

            app(ManageOtherPageContentService::class)->ensureDefaults();
            app(ManageEmailsContentService::class)->ensureDefaults();
            app(TaxValuesService::class)->ensureDefaults();
            app(PointFactorDefaultsService::class)->syncFromCiConfig();
            app(ManageCommissionService::class)->backfillMissingRows();

            if ($withWelcomeNotification) {
                TenantNotificationService::notifyWelcomePanelIfNeeded();
            }
        });
    }
}
