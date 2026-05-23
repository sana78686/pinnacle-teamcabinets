<?php

namespace App\Services;

use App\Models\PointFactorDefault;
use Illuminate\Support\Str;

class PointFactorDefaultsService
{
    /** CI point_factor.user_type values from legacy add_point_factor form + config. */
    public const CI_USER_TYPE_MAP = [
        'Representative' => 'representatives',
        'Distributor' => 'distributors',
        'Dealer' => 'dealers',
        'Showroom' => 'showrooms',
    ];

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
            'Representative' => (string) ($legacy['representatives'] ?? '0.20'),
            'Distributor' => (string) ($legacy['distributors'] ?? '0.24'),
            'Dealer' => (string) ($legacy['dealers'] ?? '0.24'),
            'Showroom' => (string) ($legacy['showrooms'] ?? '0.24'),
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
        $count = 0;
        $tenantId = tenant('id');

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
