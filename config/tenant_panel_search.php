<?php

return [
    'min_chars' => 2,
    'debounce_ms' => 100,
    'limit_per_group' => 4,
    'max_results' => 12,

    'shortcuts' => [
        ['label' => 'Dashboard', 'url' => 'tenant_dashboard', 'icon' => 'home', 'keywords' => 'dashboard home'],
        ['label' => 'Users list', 'url' => 'tenant_user_index', 'icon' => 'users', 'keywords' => 'users dealers'],
        ['label' => 'Create user', 'url' => 'tenant_user_create', 'icon' => 'user-plus', 'keywords' => 'create user'],
        ['label' => 'Products list', 'url' => 'tenant_product_index', 'icon' => 'package', 'keywords' => 'products'],
        ['label' => 'Orders list', 'url' => 'tenant_order_list', 'icon' => 'shopping-cart', 'keywords' => 'orders'],
        ['label' => 'Settings', 'url' => 'tenant_settings_hub', 'icon' => 'settings', 'keywords' => 'settings site'],
        ['label' => 'Website designing', 'url' => 'tenant_website_designing', 'icon' => 'monitor', 'keywords' => 'website theme homepage faq cms'],
        ['label' => 'Site settings', 'url' => 'tenant_site_setting', 'icon' => 'sliders', 'keywords' => 'site logo email'],
        ['label' => 'Roles list', 'url' => 'tenant_role_index', 'icon' => 'shield', 'keywords' => 'roles permissions'],
    ],
];
