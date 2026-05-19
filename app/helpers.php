<?php

use Illuminate\Support\Facades\Request;

if (! function_exists('tenant_base_domain')) {
    /** Tenant subdomain base from APP_DOMAIN (.env), default localhost in config/app.php */
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

if (!function_exists('dynamic_url')) {
    function dynamic_url($path)
    {
        $host = Request::getHost();
        $isLocal = str_contains($host, 'localhost') || str_contains($host, '127.0.0.1');

        return $isLocal ? url($path) : url('public/' . ltrim($path, '/'));
    }
}
