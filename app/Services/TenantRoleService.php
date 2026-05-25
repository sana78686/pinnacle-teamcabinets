<?php

namespace App\Services;

use App\Models\PointFactorDefault;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TenantRoleService
{
    /** CI Team Cabinets system roles (user_register.user_type / Spatie role name). */
    public const DEFAULT_ROLES = [
        'admin',
        'representatives',
        'distributors',
        'dealers',
        'showrooms',
        'affiliate',
        'sub-affiliate',
        'customers',
    ];

    /** Roles that receive CI commission point-factor defaults. */
    public const COMMISSION_ROLES = [
        'representatives',
        'distributors',
        'dealers',
        'showrooms',
    ];

    /** Legacy Laravel/Spatie names => CI strings (migration). */
    public const LEGACY_TO_CI = [
        'Admin' => 'admin',
        'admin' => 'admin',
        'Representative' => 'representatives',
        'Rep' => 'representatives',
        'representative' => 'representatives',
        'Distributor' => 'distributors',
        'distributor' => 'distributors',
        'Dealer' => 'dealers',
        'dealer' => 'dealers',
        'Showroom' => 'showrooms',
        'showroom' => 'showrooms',
        'Customer' => 'customers',
        'customer' => 'customers',
        'Affiliate' => 'affiliate',
        'Sub-Affiliate' => 'sub-affiliate',
        'Sub Affiliate' => 'sub-affiliate',
    ];

    /** @var array<string, string> CI role => admin UI label */
    public const ROLE_LABELS = [
        'admin' => 'Admin',
        'representatives' => 'Representatives',
        'distributors' => 'Distributors',
        'dealers' => 'Dealers',
        'showrooms' => 'Showrooms',
        'affiliate' => 'Affiliate',
        'sub-affiliate' => 'Sub-Affiliate',
        'customers' => 'Customers',
    ];

    public static function isProtected(string $roleName): bool
    {
        $ci = self::normalizeCiRoleName($roleName);

        return in_array($ci, self::DEFAULT_ROLES, true);
    }

    public static function isProtectedRole(string $name): bool
    {
        return self::isProtected($name);
    }

    public static function normalizeCiRoleName(?string $name): string
    {
        $name = trim((string) $name);
        if ($name === '') {
            return '';
        }

        return self::LEGACY_TO_CI[$name] ?? $name;
    }

    /** @return array<string, string> */
    public static function roleOptionsForUserForms(): array
    {
        $options = [];
        foreach (self::ROLE_LABELS as $ci => $label) {
            if ($ci === 'admin') {
                continue;
            }
            $options[$ci] = $label;
        }

        return $options;
    }

    public static function ensureDefaultRoles(): void
    {
        TenantPermissionService::syncPermissions();
        self::migrateLegacyRoleNames();

        foreach (self::DEFAULT_ROLES as $name) {
            Role::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::query()->where('name', 'admin')->where('guard_name', 'web')->first();
        $permissionIds = Permission::query()->where('guard_name', 'web')->pluck('id')->all();

        if ($admin && $permissionIds !== []) {
            $admin->syncPermissions($permissionIds);
        }

        TenantPermissionService::syncDefaultRolePermissions();
    }

    protected static function migrateLegacyRoleNames(): void
    {
        foreach (self::LEGACY_TO_CI as $old => $new) {
            if ($old === $new || in_array($old, self::DEFAULT_ROLES, true)) {
                continue;
            }

            $legacy = Role::query()->where('name', $old)->where('guard_name', 'web')->first();
            if (! $legacy) {
                continue;
            }

            $exists = Role::query()->where('name', $new)->where('guard_name', 'web')->exists();
            if ($exists) {
                continue;
            }

            $legacy->update(['name' => $new]);
        }
    }

    /** Requires active tenancy (tenant id). Called from provisioning / TenantCreated. */
    public static function seedPointFactorDefaults(): void
    {
        $tenantId = tenant('id');
        if ($tenantId === null || $tenantId === '') {
            return;
        }

        $defaults = [
            'representatives' => '0.20',
            'distributors' => '0.24',
            'dealers' => '0.24',
            'showrooms' => '0.24',
        ];

        foreach ($defaults as $userType => $pct) {
            PointFactorDefault::query()->updateOrCreate(
                [
                    'tenant_id' => $tenantId,
                    'user_type' => $userType,
                ],
                ['point_factor_percentage' => $pct]
            );
        }
    }
}
