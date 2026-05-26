<?php

return [
    'env' => env('PAYTRACE_ENV', 'production'),
    'base_url' => rtrim((string) env('PAYTRACE_BASE_URL', 'https://api.paytrace.com'), '/'),
    'username' => env('PAYTRACE_USERNAME'),
    'password' => env('PAYTRACE_PASSWORD'),
    'integrator_id' => env('PAYTRACE_INTEGRATOR_ID', '92371rHTLxWk'),
    /** When true, .env credentials override tenant Settings → Paytrace (recommended for sandbox). */
    'prefer_env_credentials' => filter_var(env('PAYTRACE_PREFER_ENV', true), FILTER_VALIDATE_BOOL),
];
