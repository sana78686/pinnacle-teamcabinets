<?php

namespace App\Services;

use App\Models\SiteSetting;
use App\Models\TenantQuickBooksSetting;
use App\Models\UsersCatalogVisibility;
use Spatie\Permission\Models\Role;

/**
 * CI_SYSTEM_FLOW §5.2 — tenant admin setup checklist.
 */
class TenantOnboardingService
{
    public function __construct(
        protected TaxValuesService $taxValues,
    ) {}

    /** @return array<string, array{label: string, done: bool, route: string, hint: string}> */
    public function steps(): array
    {
        $hasSite = SiteSetting::query()->exists();
        $hasFees = $this->taxValues->feesConfigured();
        $hasCommission = UsersCatalogVisibility::query()->exists();
        $qb = TenantQuickBooksSetting::query()->first();
        $qbConnected = $qb && $qb->isConnected();
        $roleCount = Role::query()->whereIn('name', TenantRoleService::DEFAULT_ROLES)->count();
        $rolesReady = $roleCount >= count(TenantRoleService::DEFAULT_ROLES);

        return [
            'site_settings' => [
                'order' => 2,
                'label' => 'Site settings',
                'done' => $hasSite,
                'route' => 'tenant_site_setting',
                'hint' => 'Logo, phone, email, address, contact & new-user notification emails.',
            ],
            'tax_fees' => [
                'order' => 3,
                'label' => 'Tax & fees',
                'done' => $hasFees,
                'route' => 'tenant_setting_tax_fees',
                'hint' => 'Fuel surcharge and card/ACH payment charges.',
            ],
            'commission' => [
                'order' => 4,
                'label' => 'Commission & point factors',
                'done' => $hasCommission,
                'route' => 'tenant_setting_commission',
                'hint' => 'Assign catalog visibility and door point factors when approving users.',
            ],
            'quickbooks' => [
                'order' => 5,
                'label' => 'QuickBooks',
                'done' => $qbConnected,
                'route' => 'tenant_quickbooks_index',
                'hint' => 'Connect OAuth for tax rates, customers, items, and invoices.',
            ],
            'roles' => [
                'order' => 6,
                'label' => 'Roles & permissions',
                'done' => $rolesReady,
                'route' => 'tenant_role_index',
                'hint' => 'Confirm Admin, Dealer, Representative, and other default roles.',
            ],
        ];
    }

    public function completedCount(): int
    {
        return collect($this->steps())->filter(fn ($s) => $s['done'])->count();
    }

    public function totalSteps(): int
    {
        return count($this->steps());
    }

    public function isReadyForDealers(): bool
    {
        $steps = $this->steps();

        return $steps['site_settings']['done'] && $steps['tax_fees']['done'];
    }
}
