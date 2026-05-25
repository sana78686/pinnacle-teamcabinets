<?php

use Illuminate\Support\Facades\Request;

if (! function_exists('central_domain')) {
    /** Central Pinnacle admin host from CENTRAL_DOMAIN (.env). */
    function central_domain(): string
    {
        return (string) config('app.central_domain', 'localhost');
    }
}

if (! function_exists('central_url')) {
    /** Base URL for the central app (scheme/host from APP_URL). */
    function central_url(string $path = ''): string
    {
        $base = rtrim((string) config('app.url', 'http://localhost'), '/');
        if ($path === '') {
            return $base;
        }

        return $base.'/'.ltrim($path, '/');
    }
}

if (! function_exists('tenant_base_domain')) {
    /** Tenant wildcard base from TENANT_DOMAIN (.env), e.g. apimstec.com */
    function tenant_base_domain(): string
    {
        return (string) config('app.domain', 'localhost');
    }
}

if (! function_exists('tenant_url')) {
    /** Full URL for a tenant host, honouring APP_URL scheme/port (e.g. http://acme.localhost:8000) */
    function tenant_url(string $tenantId, string $path = ''): string
    {
        $appUrl = (string) config('app.url', 'http://localhost');
        $scheme = parse_url($appUrl, PHP_URL_SCHEME) ?: 'http';
        $port = parse_url($appUrl, PHP_URL_PORT);
        $host = $tenantId.'.'.tenant_base_domain();
        $url = "{$scheme}://{$host}";
        if ($port) {
            $url .= ':'.$port;
        }
        if ($path !== '') {
            $url .= '/'.ltrim($path, '/');
        }

        return $url;
    }
}

if (! function_exists('tenant_email')) {
    /** CI Team Cabinets email renderer/sender. */
    function tenant_email(): \App\Services\TenantEmailService
    {
        return app(\App\Services\TenantEmailService::class);
    }
}

if (! function_exists('central_mail')) {
    /** Pinnacle / super-admin mail (Gmail from .env CENTRAL_MAIL_*). */
    function central_mail(): \App\Services\CentralMailService
    {
        return app(\App\Services\CentralMailService::class);
    }
}

if (! function_exists('tenant_static_asset_is_local')) {
    /** Only true on dev machines — do not use APP_ENV (live .env often has APP_ENV=local). */
    function tenant_static_asset_is_local(): bool
    {
        $host = Request::getHost();

        return str_contains($host, 'localhost') || str_contains($host, '127.0.0.1');
    }
}

if (! function_exists('tenant_request_uses_public_asset_root')) {
    function tenant_request_uses_public_asset_root(): bool
    {
        if (tenant_static_asset_is_local()) {
            return false;
        }

        $host = Request::getHost();
        $centralHosts = config('tenancy.central_domains', []);

        return $host !== '' && ! in_array($host, $centralHosts, true);
    }
}

if (! function_exists('tenant_static_asset')) {
    /**
     * All tenant-host static files (panel, auth, storefront) on live.
     * https://{tenant-host}/public/{path} — asset() breaks (tenancy or missing /public/).
     */
    function tenant_static_asset(string $path): string
    {
        $path = ltrim($path, '/');

        if (tenant_static_asset_is_local()) {
            return asset($path);
        }

        return rtrim(Request::getSchemeAndHttpHost(), '/').'/public/'.$path;
    }
}

if (! function_exists('tenant_media_url')) {
    /** Local public path, storage path, or external https:// URL → browser URL. */
    function tenant_media_url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (\App\Support\PublicUploadedFile::isExternalUrl($path)) {
            return $path;
        }

        $path = ltrim(str_replace('\\', '/', $path), '/');

        if (str_starts_with($path, 'public/')) {
            return asset('storage/'.substr($path, 7));
        }

        $storageFile = storage_path('app/public/'.$path);
        if (is_file($storageFile)) {
            return asset('storage/'.$path);
        }

        if (is_file(public_path($path))) {
            return tenant_static_asset($path);
        }

        // Legacy CI cabinet images (assets/admin/cabinet_img/…)
        if (str_starts_with($path, 'assets/admin/cabinet_img/')) {
            return tenant_static_asset($path);
        }

        return tenant_static_asset($path);
    }
}

if (! function_exists('tenant_brand_logo_url')) {
    /** Site Settings logo URL, or Pinnacle default when the tenant has not uploaded one. */
    function tenant_brand_logo_url(): string
    {
        $logo = trim((string) (\App\Models\SiteSetting::query()->value('logo') ?? ''));
        if ($logo !== '') {
            return tenant_media_url($logo) ?? asset($logo);
        }

        return tenant_static_asset((string) config('pinnacle.email.logo', 'assets/logo/pinnacle-tenant.png'));
    }
}

if (! function_exists('tenant_panel_asset_is_local')) {
    function tenant_panel_asset_is_local(): bool
    {
        return tenant_static_asset_is_local();
    }
}

if (! function_exists('tenant_panel_asset')) {
    function tenant_panel_asset(string $path): string
    {
        return tenant_static_asset($path);
    }
}

if (! function_exists('dynamic_url')) {
    /** Legacy helper for central/super-admin layouts — plain asset paths, no /public/ prefix. */
    function dynamic_url($path)
    {
        $path = ltrim((string) $path, '/');

        return $path === '' ? url('/') : asset($path);
    }
}

if (! function_exists('tenant_asset')) {
    /**
     * App helper for panel static files. Not Stancl's tenant_asset() (that route is /tenancy/assets/).
     *
     * @deprecated Use tenant_panel_asset() or $panelAsset in Blade.
     */
    function tenant_asset(string $path): string
    {
        return tenant_static_asset($path);
    }
}

if (! function_exists('other_page_content')) {
    /** Success/error page or pop-up HTML by slug (legacy manage_other_page_contents). */
    function other_page_content(string $slug): string
    {
        return app(\App\Services\ManageOtherPageContentService::class)->contentForSlug($slug);
    }
}

if (! function_exists('tax_value')) {
    /** Tenant fee/tax setting from tax_values (fuel, card charges, etc.). */
    function tax_value(string $key, ?string $default = null): ?string
    {
        return app(\App\Services\TaxValuesService::class)->get($key, $default);
    }
}

if (! function_exists('tenant_list_per_page')) {
    function tenant_list_per_page(): int
    {
        return max(1, (int) config('tenant_panel.list_per_page', 15));
    }
}

if (! function_exists('tenant_admin_unviewed_row_class')) {
    /**
     * Light-yellow row class for admin list rows not yet opened (CI is_viewed parity).
     */
    function tenant_admin_unviewed_row_class(object $record): string
    {
        return app(\App\Services\AdminRecordViewService::class)->isUnviewed($record)
            ? 'tc-row-unviewed'
            : '';
    }
}

if (! function_exists('tenant_layout_flags')) {
    /**
     * Per-request flags for slimming tenant panel assets without changing page behavior.
     *
     * @return array{settings_extras: bool}
     */
    function tenant_layout_flags(): array
    {
        static $flags = null;

        if ($flags !== null) {
            return $flags;
        }

        $settingsPatterns = config('tenant_assets.settings_route_patterns', []);
        $productsFormPatterns = config('tenant_assets.products_form_route_patterns', []);

        $flags = [
            'settings_extras' => $settingsPatterns !== [] && request()->routeIs(...$settingsPatterns)
                || ($productsFormPatterns !== [] && request()->routeIs(...$productsFormPatterns)),
        ];

        return $flags;
    }
}

if (! function_exists('request_is_tenant_context')) {
    /** True when the HTTP request targets a tenant site or tenant admin panel (not central Pinnacle). */
    function request_is_tenant_context(?\Illuminate\Http\Request $request = null): bool
    {
        $request ??= request();

        if (function_exists('tenant') && tenant()) {
            return true;
        }

        $host = $request->getHost();
        $centralHosts = config('tenancy.central_domains', []);

        if ($host !== '' && in_array($host, $centralHosts, true)) {
            return $request->is('tenants', 'tenants/*');
        }

        if ($request->is('tenants', 'tenants/*', 'login', 'registration', 'post-login', 'post-registration', 'forgot/*', 'verify-otp', 'reset-password-update', 'show-resetform/*')) {
            return true;
        }

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('domains')) {
                $domainModel = config('tenancy.domain_model', \Stancl\Tenancy\Database\Models\Domain::class);
                if (class_exists($domainModel) && $domainModel::query()->where('domain', $host)->exists()) {
                    return true;
                }
            }
        } catch (\Throwable) {
            // DB unavailable during early boot — fall through to host heuristic
        }

        $base = tenant_base_domain();
        if ($host !== '' && $host !== $base && str_ends_with($host, '.'.$base)) {
            return true;
        }

        return false;
    }
}

if (! function_exists('tenant_guest_redirect_url')) {
    /** Login URL for unauthenticated users on tenant hosts / tenant panel routes. */
    function tenant_guest_redirect_url(?\Illuminate\Http\Request $request = null): string
    {
        $request ??= request();

        if (! request_is_tenant_context($request)) {
            return route('auth_login');
        }

        if (function_exists('tenant') && tenant()) {
            return route('tenant_login');
        }

        return rtrim($request->getSchemeAndHttpHost(), '/').'/login';
    }
}

if (! function_exists('pinnacle_public_asset_url')) {
    /** Resolved public asset URL when the file exists on disk, otherwise null. */
    function pinnacle_public_asset_url(?string $relativePath): ?string
    {
        if ($relativePath === null || $relativePath === '') {
            return null;
        }

        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
        $fullPath = public_path($relativePath);

        return is_file($fullPath) ? asset($relativePath) : null;
    }
}

if (! function_exists('tenant_user_has_admin_role')) {
    /** Tenant panel Admin accounts are managed via profile settings, not user CRUD. */
    function tenant_user_has_admin_role(?\App\Models\User $user): bool
    {
        if (! $user) {
            return false;
        }

        if ((int) ($user->is_super_user ?? 0) === 1) {
            return true;
        }

        try {
            return $user->hasRole('Admin');
        } catch (\Throwable) {
            return false;
        }
    }
}

if (! function_exists('tenant_user_status_options')) {
    /** @return array<string, string> value => label */
    function tenant_user_status_options(): array
    {
        return [
            'approved' => 'Approved',
            'un-approved' => 'Unapproved',
            'active' => 'Active',
            'deactive' => 'Deactive',
            'block' => 'Block',
        ];
    }
}

if (! function_exists('tenant_user_status_skin')) {
    /**
     * UI class + label for user status dropdowns / pills.
     *
     * @return array{label: string, skin: string}
     */
    function tenant_user_status_skin(?string $status): array
    {
        return match ($status) {
            'approved', 'active' => ['label' => $status === 'active' ? 'Active' : 'Approved', 'skin' => 'green'],
            'un-approved', 'pending' => ['label' => 'Unapproved', 'skin' => 'amber'],
            'block', 'deactive' => ['label' => $status === 'deactive' ? 'Deactive' : 'Block', 'skin' => 'red'],
            default => ['label' => $status ? ucfirst(str_replace('-', ' ', $status)) : 'Unknown', 'skin' => 'neutral'],
        };
    }
}

if (! function_exists('tenant_user_is_panel_admin')) {
    function tenant_user_is_panel_admin(?\App\Models\User $user = null): bool
    {
        return tenant_user_has_admin_role($user ?? auth()->user());
    }
}

if (! function_exists('tenant_can')) {
    function tenant_can(string $permission, ?\App\Models\User $user = null): bool
    {
        $user ??= auth()->user();

        return $user
            ? \App\Services\TenantPermissionService::userCan($user, $permission)
            : false;
    }
}

if (! function_exists('tenant_can_nav')) {
    function tenant_can_nav(string $navKey, ?\App\Models\User $user = null): bool
    {
        $user ??= auth()->user();

        return $user
            ? \App\Services\TenantPermissionService::userCanNav($user, $navKey)
            : false;
    }
}

if (! function_exists('tenant_panel_layout')) {
    /** Blade layout for the authenticated tenant panel (admin vs dealer/rep/etc.). */
    function tenant_panel_layout(): string
    {
        return tenant_user_is_panel_admin()
            ? 'layouts.tenant.master'
            : 'layouts.tenant.role.master';
    }
}

if (! function_exists('tenant_panel_display_name')) {
    function tenant_panel_display_name(?\App\Models\User $user = null): string
    {
        $user ??= auth()->user();
        if (! $user) {
            return 'User';
        }

        $name = trim((string) ($user->name ?? ''));
        if ($name !== '' && strcasecmp($name, (string) ($user->username ?? '')) !== 0) {
            return $name;
        }

        return trim((string) ($user->username ?? $name ?: 'User'));
    }
}

if (! function_exists('tenant_user_chat_avatar')) {
    /** @return array{url: ?string, initials: string, name: string} */
    function tenant_user_chat_avatar(?\App\Models\User $user = null): array
    {
        if (! $user) {
            return ['url' => null, 'initials' => '?', 'name' => 'User'];
        }

        $url = null;
        $logo = trim((string) ($user->logo ?? ''));
        if ($logo !== '') {
            $mediaUrl = tenant_media_url($logo);
            if ($mediaUrl) {
                $url = $mediaUrl;
            }
        }

        return [
            'url' => $url,
            'initials' => (string) ($user->initials ?? 'U'),
            'name' => tenant_panel_display_name($user),
        ];
    }
}

if (! function_exists('tenant_panel_role_label')) {
    function tenant_panel_role_label(?\App\Models\User $user = null): string
    {
        $user ??= auth()->user();
        if (! $user) {
            return 'User';
        }

        try {
            $role = $user->getRoleNames()->first();
        } catch (\Throwable) {
            $role = null;
        }

        return $role ?: 'User';
    }
}

if (! function_exists('tenant_role_factor_key')) {
    function tenant_role_factor_key(string $roleName): string
    {
        return \Illuminate\Support\Str::slug(strtolower(trim($roleName)), '-');
    }
}

if (! function_exists('tenant_user_is_affiliate_panel')) {
    /** CI hides commission / add-affiliate for affiliate and sub-affiliate roles. */
    function tenant_user_is_affiliate_panel(?\App\Models\User $user = null): bool
    {
        $label = strtolower(tenant_panel_role_label($user));

        return str_contains($label, 'affiliate');
    }
}

if (! function_exists('tenant_manage_document_types_for_user')) {
    /** @return list<string> */
    function tenant_manage_document_types_for_user(?\App\Models\User $user = null): array
    {
        $user ??= auth()->user();
        $types = ['all'];

        if ($user) {
            $types[] = (string) $user->id;
            $role = tenant_panel_role_label($user);
            $types[] = strtolower($role);
            $types[] = tenant_role_factor_key($role);
            $types[] = str_replace('-', '_', tenant_role_factor_key($role));
            if (strcasecmp($role, 'Representative') === 0) {
                $types[] = 'representatives';
            }
        }

        return array_values(array_unique(array_filter($types)));
    }
}
