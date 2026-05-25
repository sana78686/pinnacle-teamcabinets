<?php

namespace App\Services;

use App\Models\DoorColors;
use App\Models\PointFactorDefault;
use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\UsersCatalogDoorPointFactor;
use App\Models\UsersCatalogVisibility;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class OrderPricingService
{
    /**
     * CI user_register point_factor + door_point_factor chain for accordion/cart.
     *
     * @return array<string, mixed>
     */
    public function contextFor(User $user, int $catalogId, int $doorId): array
    {
        $catalog = ProductCatalog::query()->find($catalogId);
        $door = DoorColors::query()->find($doorId);
        $catalogKey = $this->catalogKey($catalog?->name ?? '');
        $doorKey = $this->doorKey($door?->product_label ?? '');

        $chain = $this->resolveUserChain($user);
        $actingUser = $chain['acting'];
        $parentUser = $chain['parent'];
        $repUser = $chain['representative'];

        $userDoorFactor = $this->doorFactorScalar($actingUser, $catalogId, $doorId);
        $parentDoorFactor = $parentUser ? $this->doorFactorScalar($parentUser, $catalogId, $doorId) : 0.0;
        $repDoorFactor = $repUser ? $this->doorFactorScalar($repUser, $catalogId, $doorId) : 0.0;

        $pointFactor = $this->pointFactorForUser($actingUser);
        $repIds = $this->resolveRepIds($actingUser);

        return [
            'point_factor' => $pointFactor,
            'door_factor' => $userDoorFactor,
            'parent_door_point' => $parentDoorFactor,
            'representative_door_point' => $repDoorFactor,
            'user_door_point' => $userDoorFactor,
            'catalog_key' => $catalogKey,
            'door_key' => $doorKey,
            'door_trees' => [
                'user' => $this->doorFactorTree($actingUser, $catalogId),
                'user_full' => $this->doorFactorTree($actingUser),
                'parent' => $parentUser ? $this->doorFactorTree($parentUser, $catalogId) : [],
                'parent_full' => $parentUser ? $this->doorFactorTree($parentUser) : [],
                'representative' => $repUser ? $this->doorFactorTree($repUser, $catalogId) : [],
                'representative_full' => $repUser ? $this->doorFactorTree($repUser) : [],
            ],
            'cus_rep_id' => $repIds['cus_rep_id'],
            'cus_parent_id' => $repIds['cus_parent_id'],
        ];
    }

    /**
     * CI cart unit price: base cost × door factor (direct multiply, no point markup).
     */
    public function cartUnitCost(float $rawCost, array $context): float
    {
        $factor = $this->doorFactorForCatalogDoor($context);
        if ($factor > 0) {
            return round($rawCost * $factor, 2);
        }

        return round($rawCost, 2);
    }

    /** @deprecated Use cartUnitCost — kept for callers expecting adjustedCost. */
    public function adjustedCost(float $rawCost, array $context): float
    {
        return $this->cartUnitCost($rawCost, $context);
    }

    protected function doorFactorForCatalogDoor(array $context): float
    {
        $scalar = (float) ($context['user_door_point'] ?? $context['door_factor'] ?? 0);
        if ($scalar > 0) {
            return $scalar;
        }

        $catalogKey = (string) ($context['catalog_key'] ?? '');
        $doorKey = (string) ($context['door_key'] ?? '');
        $tree = $context['door_trees']['user'] ?? [];

        if ($catalogKey !== '' && $doorKey !== '' && is_array($tree)) {
            $val = $tree[$catalogKey][$doorKey] ?? null;
            if ($val !== null && $val !== '' && strtolower((string) $val) !== 'null') {
                return (float) $val;
            }
        }

        $full = $context['door_trees']['user_full'] ?? [];
        if ($doorKey !== '' && is_array($full)) {
            foreach ($full as $doors) {
                if (! is_array($doors)) {
                    continue;
                }
                $val = $doors[$doorKey] ?? null;
                if ($val !== null && $val !== '' && strtolower((string) $val) !== 'null') {
                    return (float) $val;
                }
            }
        }

        return 0.0;
    }

    /**
     * @return array<string, mixed>
     */
    public function lineMeta(Product $product, array $context): array
    {
        $raw = (float) preg_replace('/[^\d.]/', '', (string) $product->cost);
        $cartUnit = $this->cartUnitCost($raw, $context);

        return [
            'raw_cost' => $raw,
            'cart_unit_cost' => $cartUnit,
            'adjusted_cost' => $cartUnit,
            'door_factor' => $this->doorFactorForCatalogDoor($context),
            'weight' => (float) preg_replace('/[^\d.]/', '', (string) $product->weight),
            'assemble_cost' => (float) preg_replace('/[^\d.]/', '', (string) $product->assemble_cost),
            'details' => $product->value_1 ?: ($product->description ?: ''),
            'product_img' => $product->image ? asset($product->image) : '',
            'user_door_point_tree' => $context['door_trees']['user'] ?? [],
            'parent_door_point_tree' => $context['door_trees']['parent'] ?? [],
            'representative_door_point_tree' => $context['door_trees']['representative'] ?? [],
        ];
    }

    /**
     * Catalog IDs this user may use when creating orders.
     * null = unrestricted (tenant admin / super user).
     *
     * @return array<int, int>|null
     */
    public function visibleCatalogIdsFor(User $user): ?array
    {
        if (! empty($user->is_super_user)) {
            return null;
        }

        if ((method_exists($user, 'isAdmin') && $user->isAdmin()) || (method_exists($user, 'hasRole') && $user->hasRole(['super-admin', 'admin']))) {
            return null;
        }

        return UsersCatalogVisibility::query()
            ->where('user_id', $user->id)
            ->pluck('catalog_id')
            ->map(fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    /** Active product catalogs visible to this user for order creation (empty when none assigned). */
    public function catalogsForOrder(User $user): Collection
    {
        $query = ProductCatalog::query()->where('status', 1)->orderBy('name');
        $ids = $this->visibleCatalogIdsFor($user);

        if ($ids !== null) {
            if ($ids === []) {
                return collect();
            }

            $query->whereIn('id', $ids);
        }

        return $query->get();
    }

    public function userMayAccessCatalog(User $user, int $catalogId): bool
    {
        $ids = $this->visibleCatalogIdsFor($user);

        if ($ids === null) {
            return true;
        }

        return in_array($catalogId, $ids, true);
    }

    /**
     * @return array{acting: User, parent: ?User, representative: ?User}
     */
    public function userChain(User $user): array
    {
        return $this->resolveUserChain($user);
    }

    /**
     * @return array{acting: User, parent: ?User, representative: ?User}
     */
    protected function resolveUserChain(User $user): array
    {
        $user->loadMissing('roles');
        $acting = $user;
        $parent = null;
        $representative = null;

        if ($user->parent_id && (string) $user->parent_id !== '4') {
            $parent = User::query()->find($user->parent_id);
            if ($parent && $parent->parent_id && (string) $parent->parent_id !== '4') {
                $representative = User::query()->find($parent->parent_id);
            }
        }

        return [
            'acting' => $acting,
            'parent' => $parent,
            'representative' => $representative,
        ];
    }

    protected function pointFactorForUser(User $user): float
    {
        if (Schema::hasColumn('users', 'point_factor') && $user->point_factor !== null && $user->point_factor !== '') {
            return (float) $user->point_factor;
        }

        $role = $user->roles->first()?->name;
        if (! $role) {
            return 0.0;
        }

        $default = PointFactorDefault::query()
            ->where('user_type', $role)
            ->value('point_factor_percentage');

        return $default !== null ? (float) $default : 0.0;
    }

    protected function doorFactorScalar(User $user, int $catalogId, int $doorId): float
    {
        $factor = UsersCatalogDoorPointFactor::query()
            ->where('user_id', $user->id)
            ->where('catalog_id', $catalogId)
            ->where('door_style', $doorId)
            ->value('factor');

        return $factor !== null ? (float) $factor : 0.0;
    }

    /**
     * CI door_point_factor JSON shape: {Catalog_Name: {Door_Label: factor}}.
     *
     * @return array<string, array<string, string>>
     */
    public function doorFactorTree(User $user, ?int $catalogId = null): array
    {
        $query = UsersCatalogDoorPointFactor::query()
            ->where('user_id', $user->id)
            ->with(['catalog', 'doorStyle']);

        if ($catalogId) {
            $query->where('catalog_id', $catalogId);
        }

        $tree = [];
        foreach ($query->get() as $row) {
            $catKey = $this->catalogKey($row->catalog?->name ?? '');
            $doorKey = $this->doorKey($row->doorStyle?->product_label ?? '');
            if ($catKey === '' || $doorKey === '') {
                continue;
            }
            $tree[$catKey][$doorKey] = (string) $row->factor;
        }

        if ($tree !== []) {
            return $tree;
        }

        return $this->doorFactorTreeFromUserJson($user, $catalogId);
    }

    /**
     * CI user_register.door_point_factor JSON when relational rows are missing.
     *
     * @return array<string, array<string, string>>
     */
    protected function doorFactorTreeFromUserJson(User $user, ?int $catalogId = null): array
    {
        $raw = $user->door_point_factor;
        if (! is_array($raw) || $raw === []) {
            return [];
        }

        $tree = [];
        foreach ($raw as $catalogName => $doors) {
            if (! is_array($doors)) {
                continue;
            }
            $catKey = is_string($catalogName) ? $this->catalogKey($catalogName) : (string) $catalogName;
            if ($catKey === '') {
                continue;
            }
            if ($catalogId !== null) {
                $catalog = ProductCatalog::query()->find($catalogId);
                if ($catalog && $this->catalogKey($catalog->name) !== $catKey) {
                    continue;
                }
            }
            foreach ($doors as $doorLabel => $factor) {
                if ($factor === null || $factor === '' || strtolower((string) $factor) === 'null') {
                    continue;
                }
                $doorKey = is_string($doorLabel) ? $this->doorKey($doorLabel) : (string) $doorLabel;
                if ($doorKey === '') {
                    continue;
                }
                $tree[$catKey][$doorKey] = (string) $factor;
            }
        }

        return $tree;
    }

    protected function catalogKey(string $name): string
    {
        return str_replace(' ', '_', trim($name));
    }

    protected function doorKey(string $label): string
    {
        return str_replace(' ', '_', trim($label));
    }

    protected function pointMultiplier(float $point): float
    {
        if ($point <= 0) {
            return 1.0;
        }
        if ($point < 1) {
            return 1 + $point;
        }

        return $point;
    }

    protected function doorMultiplier(float $door): float
    {
        if ($door <= 0) {
            return 1.0;
        }
        if ($door < 1) {
            return 1 + $door;
        }

        return $door;
    }

    public function resolveRepIdForUser(User $user): ?int
    {
        return $this->resolveRepIds($user)['cus_rep_id'];
    }

    /**
     * @return array{cus_rep_id: int|null, cus_parent_id: int|string|null}
     */
    protected function resolveRepIds(User $user): array
    {
        $cusParentId = $user->parent_id;
        $cusRepId = null;
        $current = $user;

        for ($i = 0; $i < 20 && $current; $i++) {
            if ((string) $current->parent_id === '4') {
                $cusRepId = (int) $current->id;
                break;
            }
            if (! $current->parent_id) {
                break;
            }
            $current = User::query()->find($current->parent_id);
        }

        return [
            'cus_rep_id' => $cusRepId,
            'cus_parent_id' => $cusParentId,
        ];
    }

    /**
     * @param  Collection<int, \App\Models\ProductSection>  $sections
     * @return Collection<int, \App\Models\ProductSection>
     */
    public function applyPricingToSections(Collection $sections, array $context): Collection
    {
        return $sections->map(function ($section) use ($context) {
            $section->setRelation(
                'products',
                $section->products->map(function (Product $product) use ($context) {
                    $product->setAttribute('pricing', $this->lineMeta($product, $context));

                    return $product;
                })
            );

            return $section;
        });
    }
}
