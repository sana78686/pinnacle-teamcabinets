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
    public function __construct(
        protected OrderPricingService $pricing
    ) {}

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

        $errors = [];
        foreach ($catalogIds as $catalogId) {
            $catalog = ProductCatalog::query()->find($catalogId);
            $catalogLabel = $catalog?->name ?? "Catalog #{$catalogId}";
            $doors = DoorColors::query()->where('product_catalog_id', $catalogId)->get();

            if ($doors->isEmpty()) {
                $errors["catalog_visibility.{$catalogId}"] = ["{$catalogLabel} has no door styles configured."];

                continue;
            }

            $factors = $request->input("door_factors.{$catalogId}", []);
            if (! is_array($factors)) {
                $factors = [];
            }

            foreach ($doors as $door) {
                $val = trim((string) ($factors[$door->id] ?? ''));
                if ($val === '' || ! is_numeric($val)) {
                    $errors["door_factors.{$catalogId}.{$door->id}"] = [
                        "Door point factor required for {$door->product_label} ({$catalogLabel}).",
                    ];
                } elseif ((float) $val < 0) {
                    $errors["door_factors.{$catalogId}.{$door->id}"] = [
                        'Factor must be zero or greater.',
                    ];
                }
            }
        }

        return $errors === [] ? null : $errors;
    }

    public function persistForUser(User $user, Request $request): void
    {
        DB::transaction(function () use ($user, $request) {
            $selectedIds = $this->selectedCatalogIds($request);

            UsersCatalogDoorPointFactor::withTrashed()
                ->where('user_id', $user->id)
                ->when($selectedIds !== [], fn ($q) => $q->whereNotIn('catalog_id', $selectedIds))
                ->forceDelete();

            UsersCatalogVisibility::withTrashed()
                ->where('user_id', $user->id)
                ->when($selectedIds !== [], fn ($q) => $q->whereNotIn('catalog_id', $selectedIds))
                ->forceDelete();

            foreach ($selectedIds as $catalogId) {
                $visibility = UsersCatalogVisibility::withTrashed()->firstOrNew([
                    'user_id' => $user->id,
                    'catalog_id' => $catalogId,
                ]);

                if ($visibility->exists) {
                    if ($visibility->trashed()) {
                        $visibility->restore();
                    }
                } else {
                    $visibility->save();
                }

                UsersCatalogDoorPointFactor::withTrashed()
                    ->where('user_id', $user->id)
                    ->where('catalog_id', $catalogId)
                    ->forceDelete();

                $factors = $request->input("door_factors.{$catalogId}", []);
                if (! is_array($factors)) {
                    continue;
                }

                foreach ($factors as $doorColorId => $factor) {
                    $factor = trim((string) $factor);
                    if ($factor === '' || ! is_numeric($factor)) {
                        continue;
                    }

                    UsersCatalogDoorPointFactor::query()->create([
                        'user_catalog_visibility_id' => $visibility->id,
                        'user_id' => $user->id,
                        'catalog_id' => $catalogId,
                        'door_style' => $doorColorId,
                        'factor' => $factor,
                    ]);
                }
            }

            $this->syncCiJsonColumns($user);
        });
    }

    public function syncCiJsonColumns(User $user): void
    {
        $user->refresh();

        $tree = $this->pricing->doorFactorTree($user);

        $visibilityNames = UsersCatalogVisibility::query()
            ->where('user_id', $user->id)
            ->with('productCatalog')
            ->get()
            ->map(function (UsersCatalogVisibility $row) {
                $name = trim((string) ($row->productCatalog?->name ?? ''));

                return $name !== '' ? str_replace(' ', '_', $name) : (string) $row->catalog_id;
            })
            ->filter()
            ->values()
            ->all();

        $updates = [];

        if (Schema::hasColumn('users', 'door_point_factor')) {
            $updates['door_point_factor'] = $tree;
        }
        if (Schema::hasColumn('users', 'catalog_visibility')) {
            $updates['catalog_visibility'] = $visibilityNames;
        }

        if (
            Schema::hasColumn('users', 'point_factor')
            && ($user->point_factor === null || $user->point_factor === '')
        ) {
            $role = $user->roles()->first()?->name;
            $default = $this->roleDefaultFactor($role);
            if ($default !== null) {
                $updates['point_factor'] = $default;
            }
        }

        if ($updates !== []) {
            $user->forceFill($updates)->save();
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
