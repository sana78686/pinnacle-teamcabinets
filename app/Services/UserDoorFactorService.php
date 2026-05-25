<?php

namespace App\Services;

use App\Models\DoorColors;
use App\Models\PointFactorDefault;
use App\Models\ProductCatalog;
use App\Models\User;
use App\Models\UsersCatalogDoorPointFactor;
use App\Models\UsersCatalogVisibility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class UserDoorFactorService
{
    /** @var array<string, bool>|null */
    private static ?array $userJsonColumns = null;

    public function __construct(
        protected OrderPricingService $pricing
    ) {}

    /** @return array{door_point_factor: bool, catalog_visibility: bool, point_factor: bool} */
    protected function userJsonColumnFlags(): array
    {
        if (self::$userJsonColumns === null) {
            self::$userJsonColumns = [
                'door_point_factor' => Schema::hasColumn('users', 'door_point_factor'),
                'catalog_visibility' => Schema::hasColumn('users', 'catalog_visibility'),
                'point_factor' => Schema::hasColumn('users', 'point_factor'),
            ];
        }

        return self::$userJsonColumns;
    }

    public function roleDefaultFactor(?string $roleName): ?float
    {
        if (! $roleName) {
            return null;
        }

        $fromService = app(PointFactorDefaultsService::class)->defaultForRole($roleName);
        if ($fromService !== null) {
            return $fromService;
        }

        $key = tenant_role_factor_key($roleName);
        $default = PointFactorDefault::query()
            ->where('user_type', $key)
            ->value('point_factor_percentage');

        if ($default === null) {
            $alt = str_replace('-', '_', $key);
            $default = PointFactorDefault::query()
                ->where('user_type', $alt)
                ->value('point_factor_percentage');
        }

        return $default !== null ? (float) $default : null;
    }

    /** @return array<int, int> */
    public function selectedCatalogIds(Request $request): array
    {
        $raw = $request->input('catalog_visibility', []);
        if (! is_array($raw)) {
            return [];
        }

        $ids = [];
        foreach ($raw as $key => $value) {
            if ($value === null || $value === false || $value === '') {
                continue;
            }
            $id = is_numeric($value) ? (int) $value : (int) $key;
            if ($id > 0) {
                $ids[] = $id;
            }
        }

        return array_values(array_unique($ids));
    }

    /** @return array<string, array<int, string>>|null */
    public function doorFactorValidationErrors(Request $request): ?array
    {
        $catalogIds = $this->selectedCatalogIds($request);
        if ($catalogIds === []) {
            return null;
        }

        $catalogNames = ProductCatalog::query()
            ->whereIn('id', $catalogIds)
            ->pluck('name', 'id');

        $doorsByCatalog = DoorColors::query()
            ->whereIn('product_catalog_id', $catalogIds)
            ->get()
            ->groupBy('product_catalog_id');

        $errors = [];
        foreach ($catalogIds as $catalogId) {
            $catalogLabel = $catalogNames[$catalogId] ?? "Catalog #{$catalogId}";
            $doors = $doorsByCatalog->get($catalogId, collect());

            if ($doors->isEmpty()) {
                $errors["catalog_visibility.{$catalogId}"] = ["{$catalogLabel} has no door styles configured."];

                continue;
            }

            $factors = $request->input("door_factors.{$catalogId}", []);
            if (! is_array($factors)) {
                $factors = [];
            }

            foreach ($factors as $doorColorId => $factor) {
                $val = trim((string) $factor);
                if ($val === '') {
                    continue;
                }
                if (! is_numeric($val)) {
                    $door = $doors->firstWhere('id', (int) $doorColorId);
                    $label = $door?->product_label ?? "door #{$doorColorId}";
                    $errors["door_factors.{$catalogId}.{$doorColorId}"] = [
                        "Invalid door point factor for {$label} ({$catalogLabel}).",
                    ];

                    continue;
                }
                if ((float) $val < 0) {
                    $errors["door_factors.{$catalogId}.{$doorColorId}"] = [
                        'Factor must be zero or greater.',
                    ];
                }
            }
        }

        return $errors === [] ? null : $errors;
    }

    public function persistForUser(User $user, Request $request): void
    {
        $selectedIds = $this->selectedCatalogIds($request);
        $userId = (int) $user->id;

        DB::transaction(function () use ($request, $selectedIds, $userId) {
            UsersCatalogDoorPointFactor::withTrashed()
                ->where('user_id', $userId)
                ->when($selectedIds !== [], fn ($q) => $q->whereNotIn('catalog_id', $selectedIds))
                ->forceDelete();

            UsersCatalogVisibility::withTrashed()
                ->where('user_id', $userId)
                ->when($selectedIds !== [], fn ($q) => $q->whereNotIn('catalog_id', $selectedIds))
                ->forceDelete();

            if ($selectedIds === []) {
                return;
            }

            UsersCatalogDoorPointFactor::withTrashed()
                ->where('user_id', $userId)
                ->whereIn('catalog_id', $selectedIds)
                ->forceDelete();

            $factorRows = [];
            $now = now();

            foreach ($selectedIds as $catalogId) {
                $visibility = UsersCatalogVisibility::withTrashed()->firstOrNew([
                    'user_id' => $userId,
                    'catalog_id' => $catalogId,
                ]);

                if ($visibility->trashed()) {
                    $visibility->restore();
                } elseif (! $visibility->exists || ! $visibility->getKey()) {
                    $visibility->save();
                }

                $visibilityId = (int) $visibility->getKey();
                if ($visibilityId <= 0) {
                    throw new \RuntimeException("Could not save catalog visibility for catalog #{$catalogId}.");
                }

                $factors = $request->input("door_factors.{$catalogId}", []);
                if (! is_array($factors)) {
                    continue;
                }

                foreach ($factors as $doorColorId => $factor) {
                    $factor = trim((string) $factor);
                    if ($factor === '' || ! is_numeric($factor)) {
                        continue;
                    }

                    $factorRows[] = [
                        'user_catalog_visibility_id' => $visibilityId,
                        'user_id' => $userId,
                        'catalog_id' => (int) $catalogId,
                        'door_style' => (int) $doorColorId,
                        'factor' => $factor,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            foreach (array_chunk($factorRows, 500) as $chunk) {
                UsersCatalogDoorPointFactor::query()->insert($chunk);
            }
        });

        // Update users JSON after factor rows commit — avoids lock wait on users row inside the transaction.
        $this->syncCiJsonColumns($user);
    }

    /**
     * CI door_point_factor JSON shape without N+1 eager loads.
     *
     * @return array<string, array<string, string>>
     */
    protected function buildDoorFactorTreeFromDatabase(int $userId): array
    {
        $tree = [];

        $rows = DB::table('users_catalog_door_point_factors')
            ->where('users_catalog_door_point_factors.user_id', $userId)
            ->whereNull('users_catalog_door_point_factors.deleted_at')
            ->join('product_catalogs', 'product_catalogs.id', '=', 'users_catalog_door_point_factors.catalog_id')
            ->join('door_colors', 'door_colors.id', '=', 'users_catalog_door_point_factors.door_style')
            ->select([
                'product_catalogs.name as catalog_name',
                'door_colors.product_label',
                'users_catalog_door_point_factors.factor',
            ])
            ->get();

        foreach ($rows as $row) {
            $catKey = str_replace(' ', '_', trim((string) $row->catalog_name));
            $doorKey = str_replace(' ', '_', trim((string) $row->product_label));
            if ($catKey === '' || $doorKey === '') {
                continue;
            }
            $tree[$catKey][$doorKey] = (string) $row->factor;
        }

        return $tree;
    }

    public function syncCiJsonColumns(User $user): void
    {
        $columns = $this->userJsonColumnFlags();
        $userId = (int) $user->id;

        $visibilityNames = DB::table('users_catalog_visibilities')
            ->where('users_catalog_visibilities.user_id', $userId)
            ->whereNull('users_catalog_visibilities.deleted_at')
            ->join('product_catalogs', 'product_catalogs.id', '=', 'users_catalog_visibilities.catalog_id')
            ->orderBy('product_catalogs.name')
            ->pluck('product_catalogs.name')
            ->map(function ($name) {
                $name = trim((string) $name);

                return $name !== '' ? str_replace(' ', '_', $name) : '';
            })
            ->filter()
            ->values()
            ->all();

        $updates = [];

        if ($columns['door_point_factor']) {
            $updates['door_point_factor'] = $this->buildDoorFactorTreeFromDatabase($userId);
        }
        if ($columns['catalog_visibility']) {
            $updates['catalog_visibility'] = $visibilityNames;
        }

        if (
            $columns['point_factor']
            && ($user->point_factor === null || $user->point_factor === '')
        ) {
            $role = $user->roles()->first()?->name;
            $default = $this->roleDefaultFactor($role);
            if ($default !== null) {
                $updates['point_factor'] = $default;
            }
        }

        if ($updates === []) {
            return;
        }

        $this->updateUserColumnsWithRetry($userId, $updates);

        $user->setRawAttributes(array_merge($user->getAttributes(), $updates, [
            'updated_at' => now(),
        ]));
    }

    /** @param  array<string, mixed>  $updates */
    protected function updateUserColumnsWithRetry(int $userId, array $updates): void
    {
        $attempts = 0;
        $maxAttempts = 3;

        while (true) {
            try {
                $record = User::query()->findOrFail($userId);
                $record->forceFill($updates);
                $record->saveQuietly();

                return;
            } catch (\Illuminate\Database\QueryException $e) {
                $attempts++;
                $isLockTimeout = str_contains($e->getMessage(), '1205')
                    || str_contains($e->getMessage(), 'Lock wait timeout');

                if (! $isLockTimeout || $attempts >= $maxAttempts) {
                    throw $e;
                }

                usleep(150000 * $attempts);
            }
        }
    }

    /** @return array{catalogs: int, door_styles: int, label: string} */
    public function factorSummary(User $user): array
    {
        $catalogs = UsersCatalogVisibility::query()->where('user_id', $user->id)->count();
        $doors = UsersCatalogDoorPointFactor::query()->where('user_id', $user->id)->count();

        if ($catalogs === 0 && $doors === 0) {
            return [
                'catalogs' => 0,
                'door_styles' => 0,
                'label' => 'Not configured',
            ];
        }

        return [
            'catalogs' => $catalogs,
            'door_styles' => $doors,
            'label' => "{$catalogs} catalog".($catalogs === 1 ? '' : 's').', '.$doors.' door style'.($doors === 1 ? '' : 's'),
        ];
    }

    /** @return array<string, mixed> */
    public function sessionPayload(User $user): array
    {
        $user->loadMissing('roles');
        $tree = $user->door_point_factor;
        if (! is_array($tree) || $tree === []) {
            $tree = $this->pricing->doorFactorTree($user);
        }

        $visibility = $user->catalog_visibility;
        if (! is_array($visibility) || $visibility === []) {
            $visibility = UsersCatalogVisibility::query()
                ->where('user_id', $user->id)
                ->pluck('catalog_id')
                ->map(fn ($id) => (string) $id)
                ->values()
                ->all();
        }

        return [
            'point_factor' => (float) ($user->point_factor ?? $this->roleDefaultFactor($user->roles->first()?->name) ?? 0),
            'door_point_factor' => $tree,
            'catalog_visibility' => $visibility,
        ];
    }

    public function resolvePointFactor(Request $request, ?string $roleName): float
    {
        return (float) ($this->roleDefaultFactor($roleName) ?? 0);
    }
}
