<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserNavMenuOrder;
use Illuminate\Support\Facades\Route;

class TenantAdminNavService
{
    /** @return list<array<string, mixed>> */
    public function itemsForUser(User $user): array
    {
        $resolved = [];
        foreach ($this->orderedKeysForUser($user) as $key) {
            $item = $this->resolveItem($key, $user);
            if ($item !== null) {
                $resolved[] = $item;
            }
        }

        return $resolved;
    }

    /** @return list<array{key: string, label: string, icon: string}> */
    public function customizableItemsForUser(User $user): array
    {
        $out = [];
        foreach ($this->orderedKeysForUser($user) as $key) {
            $def = config('tenant_admin_nav.items.'.$key);
            if (! $def || ! tenant_can_nav($key, $user)) {
                continue;
            }
            $out[] = [
                'key' => $key,
                'label' => $def['label'] ?? $key,
                'icon' => $def['icon'] ?? 'circle',
            ];
        }

        return $out;
    }

    /** @param  list<string>  $keys */
    public function saveOrderForUser(User $user, array $keys): void
    {
        $allowed = collect($this->customizableItemsForUser($user))->pluck('key')->all();
        $allowedLookup = array_fill_keys($allowed, true);
        $sanitized = [];
        foreach ($keys as $key) {
            if (isset($allowedLookup[$key]) && ! in_array($key, $sanitized, true)) {
                $sanitized[] = $key;
            }
        }
        foreach ($allowed as $key) {
            if (! in_array($key, $sanitized, true)) {
                $sanitized[] = $key;
            }
        }

        UserNavMenuOrder::query()->updateOrCreate(
            ['user_id' => $user->id],
            ['menu_order' => $sanitized],
        );
    }

    public function resetOrderForUser(User $user): void
    {
        UserNavMenuOrder::query()->where('user_id', $user->id)->delete();
    }

    /** @return list<string> */
    protected function orderedKeysForUser(User $user): array
    {
        $default = config('tenant_admin_nav.default_order', []);
        $saved = UserNavMenuOrder::query()->where('user_id', $user->id)->value('menu_order');
        if (! is_array($saved) || $saved === []) {
            return $default;
        }

        $ordered = [];
        foreach ($saved as $key) {
            if (is_string($key) && config('tenant_admin_nav.items.'.$key) && ! in_array($key, $ordered, true)) {
                $ordered[] = $key;
            }
        }
        foreach ($default as $key) {
            if (! in_array($key, $ordered, true)) {
                $ordered[] = $key;
            }
        }

        return $ordered;
    }

    /** @return array<string, mixed>|null */
    protected function resolveItem(string $key, User $user): ?array
    {
        if (! tenant_can_nav($key, $user)) {
            return null;
        }

        $def = config('tenant_admin_nav.items.'.$key);
        if (! $def) {
            return null;
        }

        $type = $def['type'] ?? 'link';
        $item = [
            'key' => $key,
            'label' => $def['label'] ?? $key,
            'icon' => $def['icon'] ?? 'circle',
            'type' => $type,
            'route_patterns' => $def['route_patterns'] ?? [],
            'nav_module' => $def['nav_module'] ?? null,
            'url' => null,
            'dropdown' => null,
        ];

        if ($type === 'dropdown') {
            $children = $this->resolveChildren($def['children'] ?? [], $user);
            if ($children === []) {
                return null;
            }
            $item['dropdown'] = [
                'title' => $item['label'],
                'items' => $children,
            ];
        } else {
            $routeName = $def['route'] ?? null;
            if (! $routeName || ! Route::has($routeName)) {
                return null;
            }
            $item['url'] = route($routeName);
        }

        return $item;
    }

    /** @param  list<array<string, mixed>>  $children
     * @return list<array<string, mixed>>
     */
    protected function resolveChildren(array $children, User $user): array
    {
        $resolved = [];
        foreach ($children as $child) {
            $permission = $child['permission'] ?? null;
            if ($permission !== null && ! $this->childAllowed($user, $permission)) {
                continue;
            }
            $routeName = $child['route'] ?? null;
            if (! $routeName || ! Route::has($routeName)) {
                continue;
            }
            $resolved[] = [
                'url' => route($routeName),
                'icon' => $child['icon'] ?? 'circle',
                'label' => $child['label'] ?? '',
                'badge_key' => $child['badge_key'] ?? null,
            ];
        }

        return $resolved;
    }

    protected function childAllowed(User $user, string|array $permission): bool
    {
        if (is_array($permission)) {
            foreach ($permission as $name) {
                if (tenant_can($name, $user)) {
                    return true;
                }
            }

            return false;
        }

        return tenant_can($permission, $user);
    }
}
