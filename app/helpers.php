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

if (! function_exists('tenant_asset_needs_public_prefix')) {
    /** Whether tenant static files are served under /public/ (project root as docroot on live). */
    function tenant_asset_needs_public_prefix(): bool
    {
        $configured = config('tenant_assets.use_public_prefix');
        if ($configured !== null) {
            return (bool) $configured;
        }

        $host = Request::getHost();

        return ! (str_contains($host, 'localhost') || str_contains($host, '127.0.0.1'));
    }
}

if (! function_exists('dynamic_url')) {
    function dynamic_url($path)
    {
        $path = ltrim((string) $path, '/');
        if ($path === '') {
            return tenant_asset_needs_public_prefix() ? url('public') : url('/');
        }

        return tenant_asset_needs_public_prefix()
            ? url('public/'.$path)
            : url($path);
    }
}

if (! function_exists('tenant_asset')) {
    /** Tenant panel CSS/JS/images — uses /public/ prefix on live when docroot is not Laravel's public folder. */
    function tenant_asset(string $path): string
    {
        return dynamic_url($path);
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
     * Yellow highlight class for admin list rows not yet opened (CI is_viewed parity).
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
