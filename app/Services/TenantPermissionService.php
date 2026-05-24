<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class TenantPermissionService
{
    /** @return list<string> */
    public static function allPermissionNames(): array
    {
        $names = [];
        foreach (config('tenant_permissions.modules', []) as $module => $meta) {
            foreach ($meta['actions'] ?? [] as $action) {
                $names[] = "{$module}-{$action}";
            }
        }

        return array_values(array_unique($names));
    }

    public static function syncPermissions(): void
    {
        $guard = config('tenant_permissions.guard', 'web');

        foreach (self::allPermissionNames() as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => $guard,
            ]);
        }

        // Keep legacy typo permissions for existing DBs / imports.
        foreach (config('tenant_permissions.aliases', []) as $canonical => $legacyNames) {
            Permission::firstOrCreate(['name' => $canonical, 'guard_name' => $guard]);
            foreach ($legacyNames as $legacy) {
                Permission::firstOrCreate(['name' => $legacy, 'guard_name' => $guard]);
            }
        }
    }

    /** @return Collection<string, Collection<int, Permission>> */
    public static function groupedForUi(): Collection
    {
        $guard = config('tenant_permissions.guard', 'web');
        $permissions = Permission::query()
            ->where('guard_name', $guard)
            ->orderBy('name')
            ->get();

        $canonical = collect(self::allPermissionNames());

        return $permissions
            ->filter(fn (Permission $p) => $canonical->contains($p->name)
                || collect(config('tenant_permissions.aliases', []))->flatten()->contains($p->name))
            ->groupBy(function (Permission $permission) {
                $name = self::canonicalName($permission->name);

                return explode('-', $name, 2)[0] ?? 'other';
            })
            ->sortKeys();
    }

    public static function canonicalName(string $permission): string
    {
        foreach (config('tenant_permissions.aliases', []) as $canonical => $legacyNames) {
            if ($permission === $canonical || in_array($permission, $legacyNames, true)) {
                return $canonical;
            }
        }

        return $permission;
    }

    public static function userCan(User $user, string $permission): bool
    {
        if (self::userIsAdmin($user)) {
            return true;
        }

        if ($user->can($permission)) {
            return true;
        }

        $canonical = self::canonicalName($permission);
        if ($canonical !== $permission && $user->can($canonical)) {
            return true;
        }

        foreach (config('tenant_permissions.aliases.'.$canonical, []) as $legacy) {
            if ($user->can($legacy)) {
                return true;
            }
        }

        return false;
    }

    /** @param  list<string>  $permissions */
    public static function userCanAny(User $user, array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (self::userCan($user, $permission)) {
                return true;
            }
        }

        return false;
    }

    public static function userCanNav(User $user, string $navKey): bool
    {
        $required = config('tenant_permissions.nav.'.$navKey, []);

        return $required === [] || self::userCanAny($user, $required);
    }

    public static function userIsAdmin(User $user): bool
    {
        try {
            return $user->hasRole(config('tenant_permissions.admin_role', 'Admin'));
        } catch (\Throwable) {
            return false;
        }
    }

    public static function routeIsAlwaysAllowed(?string $routeName): bool
    {
        if ($routeName === null || $routeName === '') {
            return true;
        }

        foreach (config('tenant_permissions.always_allowed', []) as $pattern) {
            if (self::routeMatchesPattern($routeName, $pattern)) {
                return true;
            }
        }

        return false;
    }

    public static function permissionForRoute(?string $routeName): ?string
    {
        if ($routeName === null || self::routeIsAlwaysAllowed($routeName)) {
            return null;
        }

        if (str_starts_with($routeName, 'tenant_rep_workspace_api_')) {
            return null;
        }

        if (! str_starts_with($routeName, 'tenant_')) {
            return null;
        }

        $body = substr($routeName, 7);
        $parts = explode('_', $body);
        if ($parts === []) {
            return null;
        }

        $modules = array_keys(config('tenant_permissions.modules', []));
        usort($modules, fn ($a, $b) => strlen($b) <=> strlen($a));

        $module = null;
        $actionParts = $parts;
        foreach ($modules as $candidate) {
            $candidateParts = explode('_', $candidate);
            if (array_slice($parts, 0, count($candidateParts)) === $candidateParts) {
                $module = $candidate;
                $actionParts = array_slice($parts, count($candidateParts));
                break;
            }
        }

        if ($module === null) {
            return null;
        }

        $action = implode('_', $actionParts);
        $mapped = self::mapRouteActionToPermissionAction($action);

        return "{$module}-{$mapped}";
    }

    public static function permissionForRepWorkspaceType(?string $type): ?string
    {
        if ($type === null || $type === '') {
            return null;
        }

        return config('tenant_permissions.rep_workspace_types.'.$type);
    }

    public static function userCanAccessRoute(User $user, ?string $routeName, ?string $repWorkspaceType = null): bool
    {
        if (self::userIsAdmin($user)) {
            return true;
        }

        if ($repWorkspaceType !== null) {
            $perm = self::permissionForRepWorkspaceType($repWorkspaceType);

            return $perm === null || self::userCan($user, $perm);
        }

        $permission = self::permissionForRoute($routeName);
        if ($permission === null) {
            return true;
        }

        return self::userCan($user, $permission);
    }

    /** @param  list<string>  $patterns  e.g. order-*, settings-edit */
    public static function expandPermissionPatterns(array $patterns): array
    {
        $all = self::allPermissionNames();
        $expanded = [];

        foreach ($patterns as $pattern) {
            if (! str_contains($pattern, '*')) {
                $expanded[] = $pattern;
                continue;
            }

            $prefix = rtrim($pattern, '*');
            foreach ($all as $name) {
                if (str_starts_with($name, $prefix)) {
                    $expanded[] = $name;
                }
            }
        }

        return array_values(array_unique($expanded));
    }

    public static function syncDefaultRolePermissions(): void
    {
        $guard = config('tenant_permissions.guard', 'web');

        foreach (config('tenant_permissions.default_role_permissions', []) as $roleName => $patterns) {
            $role = \Spatie\Permission\Models\Role::query()
                ->where('name', $roleName)
                ->where('guard_name', $guard)
                ->first();

            if (! $role) {
                continue;
            }

            $names = self::expandPermissionPatterns($patterns);
            foreach ($names as $name) {
                foreach (config('tenant_permissions.aliases.'.$name, []) as $legacy) {
                    $names[] = $legacy;
                }
            }
            $names = array_values(array_unique($names));

            $ids = Permission::query()
                ->where('guard_name', $guard)
                ->whereIn('name', $names)
                ->pluck('id')
                ->all();

            if ($ids !== []) {
                $role->syncPermissions($ids);
            }
        }
    }

    protected static function mapRouteActionToPermissionAction(string $action): string
    {
        if ($action === '' || $action === 'index' || str_ends_with($action, '_index') || str_ends_with($action, '_list')) {
            return 'list';
        }

        if (str_contains($action, 'workspace') || in_array($action, ['store', 'create', 'checkout', 'process', 'quote', 'shipping_quote', 'stock_check'], true)) {
            return 'create';
        }

        if (str_contains($action, 'export')) {
            return 'export';
        }

        if (str_contains($action, 'import')) {
            return 'import';
        }

        if (str_contains($action, 'restore') || str_contains($action, 'deleted')) {
            return 'restore';
        }

        if (str_contains($action, 'destroy') || $action === 'delete') {
            return 'delete';
        }

        if (str_contains($action, 'edit') || str_contains($action, 'update') || str_contains($action, 'show')) {
            return 'edit';
        }

        return 'list';
    }

    protected static function routeMatchesPattern(string $routeName, string $pattern): bool
    {
        if ($pattern === $routeName) {
            return true;
        }

        if (str_contains($pattern, '*')) {
            $regex = '/^'.str_replace('\*', '.*', preg_quote($pattern, '/')).'$/';

            return (bool) preg_match($regex, $routeName);
        }

        return false;
    }
}
