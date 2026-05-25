<?php

namespace App\Services;

use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TenantPanelSearchService
{
    /** @return array<int, array<string, string>> */
    public function suggest(string $query): array
    {
        $q = trim($query);
        if (strlen($q) < (int) config('tenant_panel_search.min_chars', 2)) {
            return [];
        }

        $needle = '%'.$q.'%';
        $limit = (int) config('tenant_panel_search.max_results', 12);
        $perGroup = (int) config('tenant_panel_search.limit_per_group', 4);
        $out = [];

        foreach ($this->matchShortcuts($q) as $item) {
            $out[] = $item;
            if (count($out) >= $limit) {
                return $out;
            }
        }

        $users = User::query()
            ->where(function ($builder) use ($needle) {
                $builder->where('name', 'like', $needle)
                    ->orWhere('email', 'like', $needle)
                    ->orWhere('username', 'like', $needle)
                    ->orWhere('company_name', 'like', $needle);
            })
            ->limit($perGroup)
            ->get(['id', 'name', 'email', 'username']);

        foreach ($users as $user) {
            $out[] = [
                'type' => 'Users',
                'label' => $user->name ?: $user->username,
                'meta' => $user->email,
                'url' => tenant_user_has_admin_role($user)
                    ? (Auth::id() === $user->id
                        ? route(Auth::user()?->isAdmin() ? 'tenant_setting_profile' : 'tenant_profile')
                        : route('tenant_user_show', $user->id))
                    : route('tenant_user_edit', $user->id),
                'icon' => 'user',
            ];
        }

        $products = Product::query()
            ->where(function ($builder) use ($needle) {
                $builder->where('label', 'like', $needle)
                    ->orWhere('sku', 'like', $needle);
            })
            ->limit($perGroup)
            ->get(['id', 'label', 'sku']);

        foreach ($products as $product) {
            $out[] = [
                'type' => 'Products',
                'label' => $product->label ?: 'Product #'.$product->id,
                'meta' => $product->sku ? 'SKU: '.$product->sku : '',
                'url' => route('tenant_product_index'),
                'icon' => 'package',
            ];
        }

        $catalogs = ProductCatalog::query()
            ->where('name', 'like', $needle)
            ->limit(3)
            ->get(['id', 'name']);

        foreach ($catalogs as $catalog) {
            $out[] = [
                'type' => 'Catalogs',
                'label' => $catalog->name,
                'meta' => 'Product catalog',
                'url' => route('tenant_product_catalog_index'),
                'icon' => 'layers',
            ];
        }

        $pages = Page::query()
            ->where('status', 'published')
            ->where(function ($builder) use ($needle) {
                $builder->where('title', 'like', $needle)
                    ->orWhere('slug', 'like', $needle);
            })
            ->limit($perGroup)
            ->get(['title', 'slug']);

        foreach ($pages as $page) {
            $out[] = [
                'type' => 'Pages',
                'label' => $page->title,
                'meta' => $page->slug,
                'url' => route('cms.page', $page->slug),
                'icon' => 'file-text',
            ];
        }

        return array_slice($out, 0, $limit);
    }

    /** @return array<int, array<string, string>> */
    protected function matchShortcuts(string $q): array
    {
        $qLower = Str::lower($q);
        $matched = [];

        foreach (config('tenant_panel_search.shortcuts', []) as $shortcut) {
            $haystack = Str::lower($shortcut['label'].' '.($shortcut['keywords'] ?? ''));
            if (Str::contains($haystack, $qLower)) {
                $matched[] = [
                    'type' => 'Quick link',
                    'label' => $shortcut['label'],
                    'meta' => 'Go to page',
                    'url' => route($shortcut['url']),
                    'icon' => $shortcut['icon'] ?? 'arrow-right',
                ];
            }
        }

        return $matched;
    }
}
