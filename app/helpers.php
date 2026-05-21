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

if (!function_exists('dynamic_url')) {
    function dynamic_url($path)
    {
        $host = Request::getHost();
        $isLocal = str_contains($host, 'localhost') || str_contains($host, '127.0.0.1');

        return $isLocal ? url($path) : url('public/' . ltrim($path, '/'));
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
