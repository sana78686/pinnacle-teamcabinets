<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TenantRoleService
{
    /** CI Team Cabinets system roles — cannot be deleted or renamed. */
    public const DEFAULT_ROLES = [
        'Admin',
        'Representative',
        'Distributor',
        'Dealer',
        'Showroom',
        'Customer',
    ];

    /** Roles that receive CI commission defaults (see config commission_defaults_by_role). */
    public const COMMISSION_ROLES = [
        'Representative',
        'Distributor',
        'Dealer',
        'Showroom',
    ];

    public static function isProtectedRole(string $name): bool
    {
        return in_array($name, self::DEFAULT_ROLES, true);
    }

    public static function ensureDefaultRoles(): void
    {
        foreach (self::DEFAULT_ROLES as $name) {
            Role::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        $admin = Role::findByName('Admin', 'web');
        $permissionIds = Permission::query()->pluck('id')->all();

        if ($permissionIds !== []) {
            $admin->syncPermissions($permissionIds);
        }
    }
}
