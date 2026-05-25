<?php

namespace App\Services;

use App\Models\PointFactorDefault;
use Illuminate\Support\Str;

class PointFactorDefaultsService
{
    /** Legacy Spatie/display names => CI point_factor.user_type (see TenantRoleService::LEGACY_TO_CI). */
    public const CI_USER_TYPE_MAP = TenantRoleService::LEGACY_TO_CI;

    /**
     * CI default decimals (from config/team_cabinets_tenant.php + CI admin form).
     *
     * @return array<string, string>
     */
    public function ciDefaultsByRoleName(): array
    {
        $fromConfig = config('team_cabinets_tenant.commission_defaults_by_role', []);

        if ($fromConfig !== []) {
            return $fromConfig;
        }

        $legacy = config('team_cabinets_tenant.point_factors', []);

        return [
            'representatives' => (string) ($legacy['representatives'] ?? '0.20'),
            'distributors' => (string) ($legacy['distributors'] ?? '0.24'),
            'dealers' => (string) ($legacy['dealers'] ?? '0.24'),
            'showrooms' => (string) ($legacy['showrooms'] ?? '0.24'),
        ];
    }

    /** @return list<string> */
    public function storageKeysForRole(string $roleName): array
    {
        $keys = array_filter(array_unique([
            tenant_role_factor_key($roleName),
            self::CI_USER_TYPE_MAP[$roleName] ?? null,
            Str::slug(strtolower($roleName), '_'),
        ]));

        return array_values($keys);
    }

    public function defaultForRole(?string $roleName): ?float
    {
        if (! $roleName) {
            return null;
        }

        foreach ($this->storageKeysForRole($roleName) as $key) {
            $stored = PointFactorDefault::query()
                ->where('user_type', $key)
                ->value('point_factor_percentage');

            if ($stored !== null && $stored !== '') {
                return (float) $stored;
            }
        }

        $configured = $this->ciDefaultsByRoleName()[$roleName] ?? null;

        return $configured !== null ? (float) $configured : null;
    }

    /** Seed/update point_factor_defaults from CI values for commission roles. */
    public function syncFromCiConfig(): int
    {
        $tenantId = tenant('id');
        if ($tenantId === null || $tenantId === '') {
            return 0;
        }

        $count = 0;

        foreach ($this->ciDefaultsByRoleName() as $roleName => $pct) {
            foreach ($this->storageKeysForRole($roleName) as $userType) {
                PointFactorDefault::query()->updateOrCreate(
                    [
                        'tenant_id' => $tenantId,
                        'user_type' => $userType,
                    ],
                    ['point_factor_percentage' => $pct]
                );
                $count++;
            }
        }

        return $count;
    }
}
