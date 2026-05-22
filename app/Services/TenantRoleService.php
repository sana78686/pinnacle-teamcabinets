<?php

namespace App\Services;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TenantRoleService
{
    /** CI Team Cabinets role names used across the tenant panel. */
    public const DEFAULT_ROLES = [
        'Admin',
        'Representative',
        'Distributor',
        'Customer',
        'Showroom',
        'Dealer',
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
