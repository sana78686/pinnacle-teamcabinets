<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudflare Turnstile
    |--------------------------------------------------------------------------
    | Site key (public) and secret key from Cloudflare dashboard → Turnstile.
    | When enabled with both keys set, auth forms require a valid token.
    */
    'enabled' => env('TURNSTILE_ENABLED', true),

    'site_key' => env('TURNSTILE_SITE_KEY'),

    'secret_key' => env('TURNSTILE_SECRET_KEY'),

    /**
     * When true and site/secret keys are empty, use Cloudflare's documented test keys
     * so the widget renders and siteverify passes on any hostname (including staging).
     * Set false in production once real keys are configured in .env.
     */
    'use_test_keys' => env('TURNSTILE_USE_TEST_KEYS', true),

    'test_site_key' => '1x00000000000000000000AA',

    'test_secret_key' => '1x0000000000000000000000000000000AA',

    /** Widget theme: light, dark, auto */
    'theme' => env('TURNSTILE_THEME', 'light'),

    /** Widget size: normal, compact, flexible */
    'size' => env('TURNSTILE_SIZE', 'normal'),

    /**
     * Send visitor IP to Cloudflare siteverify. Leave false behind proxies/CDNs
     * (common cause of "green widget" but server still rejects the token).
     */
    'verify_remote_ip' => env('TURNSTILE_VERIFY_REMOTE_IP', false),

    /**
     * Skip Turnstile on localhost / 127.0.0.1 (widget can show Success but
     * siteverify fails with hostname-mismatch unless those hosts are in Cloudflare).
     * Defaults to true when APP_ENV=local.
     */
    'skip_on_localhost' => env('TURNSTILE_SKIP_LOCALHOST', env('APP_ENV', 'production') === 'local'),
];
