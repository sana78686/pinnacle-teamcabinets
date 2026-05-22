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
                'parent' => $parentUser ? $this->doorFactorTree($parentUser, $catalogId) : [],
                'representative' => $repUser ? $this->doorFactorTree($repUser, $catalogId) : [],
            ],
            'cus_rep_id' => $repIds['cus_rep_id'],
            'cus_parent_id' => $repIds['cus_parent_id'],
        ];
    }

    public function adjustedCost(float $rawCost, array $context): float
    {
        $afterPoint = $rawCost * $this->pointMultiplier((float) ($context['point_factor'] ?? 0));
        $doorFactor = (float) ($context['user_door_point'] ?? $context['door_factor'] ?? 0);

        return round($afterPoint * $this->doorMultiplier($doorFactor), 2);
    }

    /**
     * @return array<string, mixed>
     */
    public function lineMeta(Product $product, array $context): array
    {
        $raw = (float) preg_replace('/[^\d.]/', '', (string) $product->cost);
        $adjusted = $this->adjustedCost($raw, $context);

        return [
            'raw_cost' => $raw,
            'adjusted_cost' => $adjusted,
            'weight' => (float) preg_replace('/[^\d.]/', '', (string) $product->weight),
            'assemble_cost' => (float) preg_replace('/[^\d.]/', '', (string) $product->assemble_cost),
            'details' => $product->value_1 ?: ($product->description ?: ''),
            'product_img' => $product->image ? asset($product->image) : '',
            'parent_door_point' => json_encode($context['door_trees']['parent'] ?? []),
            'representative_door_point' => json_encode($context['door_trees']['representative'] ?? []),
            'user_door_point' => json_encode($context['door_trees']['user'] ?? []),
        ];
    }

    public function userMayAccessCatalog(User $user, int $catalogId): bool
    {
        if (! empty($user->is_super_user)) {
            return true;
        }

        if (method_exists($user, 'hasRole') && $user->hasRole(['super-admin', 'admin', 'Super Admin', 'Admin'])) {
            return true;
        }

        return UsersCatalogVisibility::query()
            ->where('user_id', $user->id)
            ->where('catalog_id', $catalogId)
            ->exists();
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
