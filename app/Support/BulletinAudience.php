<?php

namespace App\Support;

use App\Models\User;
use App\Services\PointFactorDefaultsService;

class BulletinAudience
{
    /** @return array<string, string> CI bulletin select_user_type values => labels */
    public static function targetRoleOptions(): array
    {
        return [
            'representatives' => 'Representatives',
            'distributors' => 'Distributors',
            'dealers' => 'Dealers',
            'showrooms' => 'Showrooms',
        ];
    }

    public static function normalizeTargetRole(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        $value = trim($value);
        $map = PointFactorDefaultsService::CI_USER_TYPE_MAP;

        if (isset($map[$value])) {
            return $map[$value];
        }

        foreach ($map as $roleName => $ciType) {
            if (strcasecmp($roleName, $value) === 0 || strcasecmp($ciType, $value) === 0) {
                return $ciType;
            }
        }

        $slug = str_replace('-', '_', tenant_role_factor_key($value));

        return $slug !== '' ? $slug : strtolower($value);
    }

    /** @return list<string> */
    public static function expandTargetRoleKeys(?string $targetRole): array
    {
        if ($targetRole === null || trim($targetRole) === '') {
            return [];
        }

        $keys = [
            $targetRole,
            strtolower($targetRole),
            tenant_role_factor_key($targetRole),
            str_replace('-', '_', tenant_role_factor_key($targetRole)),
        ];

        $map = PointFactorDefaultsService::CI_USER_TYPE_MAP;
        foreach ($map as $roleName => $ciType) {
            if (strcasecmp($roleName, $targetRole) === 0
                || strcasecmp($ciType, $targetRole) === 0
                || tenant_role_factor_key($roleName) === tenant_role_factor_key($targetRole)) {
                $keys[] = $roleName;
                $keys[] = $ciType;
                $keys[] = strtolower($roleName);
            }
        }

        return array_values(array_unique(array_filter($keys)));
    }

    /**
     * CI dashboard: bulletin.select_user_type == login user user_type.
     */
    public static function primaryUserTypeKey(User $user): string
    {
        $ciRole = $user->getCiRole();
        if ($ciRole !== '') {
            return self::normalizeTargetRole($ciRole) ?? $ciRole;
        }

        if (filled($user->user_type)) {
            return self::normalizeTargetRole($user->user_type) ?? (string) $user->user_type;
        }

        return '';
    }

    /** @return list<string> */
    public static function roleKeysForUser(User $user): array
    {
        $keys = [];

        $primary = self::primaryUserTypeKey($user);
        if ($primary !== '') {
            $keys = array_merge($keys, self::expandTargetRoleKeys($primary), [$primary]);
        }

        if (filled($user->user_type)) {
            $keys[] = (string) $user->user_type;
            $keys = array_merge($keys, self::expandTargetRoleKeys($user->user_type));
        }

        try {
            foreach ($user->getRoleNames() as $roleName) {
                $keys = array_merge($keys, self::expandTargetRoleKeys($roleName), [$roleName]);
            }
        } catch (\Throwable) {
            // ignore
        }

        return array_values(array_unique(array_filter($keys)));
    }

    public static function targetMatchesUser(?string $targetRole, User $user): bool
    {
        if ($targetRole === null || trim($targetRole) === '') {
            return true;
        }

        $userType = self::primaryUserTypeKey($user);
        if ($userType !== '' && self::optionMatchesStored($targetRole, $userType)) {
            return true;
        }

        $targetKeys = self::expandTargetRoleKeys($targetRole);
        $userKeys = self::roleKeysForUser($user);

        return $targetKeys !== [] && $userKeys !== []
            && count(array_intersect($targetKeys, $userKeys)) > 0;
    }

    public static function optionMatchesStored(?string $stored, string $optionValue): bool
    {
        if ($stored === null || trim($stored) === '') {
            return $optionValue === '';
        }

        return count(array_intersect(
            self::expandTargetRoleKeys($stored),
            self::expandTargetRoleKeys($optionValue)
        )) > 0;
    }

    public static function userOptionLabel(?string $option): string
    {
        return match ($option) {
            'every_one' => 'Every One',
            'specific_user' => 'Specific User',
            default => $option ? ucwords(str_replace('_', ' ', $option)) : '—',
        };
    }

    public static function targetRoleLabel(?string $role): string
    {
        if ($role === null || trim($role) === '') {
            return '—';
        }

        $normalized = self::normalizeTargetRole($role);

        return self::targetRoleOptions()[$normalized ?? ''] ?? ucwords(str_replace('_', ' ', $role));
    }

    /** @return array<string, string> */
    public static function adminSortOptions(): array
    {
        return [
            'newest' => 'Newest first',
            'oldest' => 'Oldest first',
            'title_asc' => 'Title (A–Z)',
            'title_desc' => 'Title (Z–A)',
        ];
    }
}
