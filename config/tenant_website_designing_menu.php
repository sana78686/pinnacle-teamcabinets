<?php

return [
    'sections' => [
        [
            'label' => 'Overview',
            'route' => 'tenant_website_designing',
            'icon' => 'grid',
            'active' => ['tenant_website_designing'],
        ],
        [
            'label' => 'Storefront theme',
            'route' => 'tenant_frontend_theme',
            'icon' => 'layout',
            'active' => ['tenant_frontend_theme', 'tenant_frontend_theme_store'],
        ],
        [
            'label' => 'Home & FAQ',
            'route' => 'tenant_home_setting_index',
            'icon' => 'home',
            'active' => ['tenant_home_setting_index', 'tenant_home_setting_srore'],
        ],
        [
            'label' => 'CMS pages',
            'route' => 'pages.index',
            'icon' => 'file-text',
            'active' => ['pages.create', 'pages.index', 'pages.edit', 'pages.show', 'pages.store', 'pages.update', 'pages.destroy'],
        ],
        [
            'label' => 'About Us',
            'route' => 'tenant_storefront_about',
            'icon' => 'info',
            'active' => ['tenant_storefront_about', 'pages.edit'],
        ],
        [
            'label' => 'Blog',
            'route' => 'tenant_storefront_blog',
            'icon' => 'book-open',
            'active' => ['tenant_storefront_blog', 'pages.create', 'pages.edit'],
        ],
        [
            'label' => 'Contact Us',
            'route' => 'tenant_setting_manage_index',
            'icon' => 'phone',
            'active' => ['tenant_setting_manage_index', 'tenant_setting_manage_contact_*'],
        ],
    ],
];
