<?php

/**
 * Route patterns for conditional tenant panel CSS/JS (see tenant_layout_flags()).
 * Wildcards use Laravel routeIs() syntax.
 */
return [
    /*
    | Live servers whose web root is the project folder (not public/) need /public/ in asset URLs.
    | null = auto (prefix on any host that is not localhost/127.0.0.1). true/false to force.
    */
    'use_public_prefix' => env('TENANT_ASSET_PUBLIC_PREFIX') === null
        ? null
        : filter_var(env('TENANT_ASSET_PUBLIC_PREFIX'), FILTER_VALIDATE_BOOLEAN),

    'settings_route_patterns' => [
        'tenant_settings_hub',
        'tenant_site_setting',
        'tenant_site_settings_store',
        'tenant_website_designing',
        'tenant_frontend_theme',
        'tenant_frontend_theme_store',
        'tenant_setting_*',
        'tenant_storefront_*',
        'tenant_quickbooks_*',
        'pages.*',
    ],

    'products_form_route_patterns' => [
        'tenant_product_catalog_create',
        'tenant_product_catalog_edit',
        'tenant_product_catalog_show',
        'tenant_product_section_create',
        'tenant_product_section_edit',
        'tenant_product_section_show',
        'tenant_door_style_create',
        'tenant_door_style_edit',
        'tenant_door_style_show',
        'tenant_product_create',
        'tenant_product_edit',
        'tenant_product_show',
    ],
];
