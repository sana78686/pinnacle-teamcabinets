<?php

/**
 * Tenant panel Spatie permissions (module-action naming).
 * Run: php artisan db:seed --class=PermissionTableSeeder
 */
return [
    'guard' => 'web',

    /** Admin role bypasses checks (receives all permissions via seeder). */
    'admin_role' => 'Admin',

    /**
     * Legacy permission names kept in DB — treated as equivalent when checking access.
     *
     * @var array<string, list<string>>
     */
    'aliases' => [
        'bulletin-list' => ['bulliten-list'],
        'bulletin-create' => ['bulliten-create'],
        'bulletin-edit' => ['bulliten-edit'],
        'bulletin-delete' => ['bulliten-delete'],
        'bulletin-restore' => ['bulliten-restore'],
        'bulletin-import' => ['bulliten-import'],
        'bulletin-export' => ['bulliten-export'],
    ],

    /**
     * Route names (or fnmatch patterns) that do not require a module permission.
     */
    'always_allowed' => [
        'tenant_dashboard',
        'tenant_logout',
        'tenant_profile',
        'tenant_profile_*',
        'tenant_setting_profile',
        'tenant_setting_profile_*',
        'tenant_notifications_*',
        'tenant_support_chat_user',
        'tenant_support_chat_api_current_thread',
        'tenant_support_chat_api_threads',
        'tenant_support_chat_api_messages',
        'tenant_support_chat_api_send',
        'tenant_support_chat_api_read',
        'tenant_support_chat_api_unread',
        'tenant_subscription.*',
        'tenant.billing.*',
        'tenant_user_role_default',
        'cart.*',
        'tenant_nav_menu_*',
    ],

    /**
     * Modules => human label + CRUD-style actions seeded into permissions table.
     */
    'modules' => [
        'dashboard' => ['label' => 'Dashboard', 'actions' => ['view']],
        'role' => ['label' => 'Roles', 'actions' => ['list', 'create', 'edit', 'delete', 'export', 'import']],
        'manage_role' => ['label' => 'Manage User Role', 'actions' => ['list', 'create', 'edit', 'delete']],
        'user' => ['label' => 'Users', 'actions' => ['list', 'create', 'edit', 'delete', 'restore', 'export', 'import']],
        'product' => ['label' => 'Products', 'actions' => ['list', 'create', 'edit', 'delete', 'restore', 'export', 'import']],
        'product_catalog' => ['label' => 'Product Catalogs', 'actions' => ['list', 'create', 'edit', 'delete', 'restore', 'export', 'import']],
        'product_section' => ['label' => 'Product Sections', 'actions' => ['list', 'create', 'edit', 'delete', 'restore', 'export', 'import']],
        'door_style' => ['label' => 'Door Styles', 'actions' => ['list', 'create', 'edit', 'delete', 'restore']],
        'order' => ['label' => 'Orders', 'actions' => ['list', 'create', 'edit', 'delete', 'restore', 'export', 'import']],
        'claim' => ['label' => 'Claims', 'actions' => ['list', 'create', 'edit', 'delete', 'restore']],
        'bulletin' => ['label' => 'Bulletins', 'actions' => ['list', 'create', 'edit', 'delete', 'restore', 'export', 'import']],
        'quote' => ['label' => 'Quotes', 'actions' => ['list', 'create', 'edit', 'delete', 'restore']],
        'shipping_quote' => ['label' => 'Shipping Quotes', 'actions' => ['list', 'create', 'edit', 'delete', 'restore']],
        'stock_check' => ['label' => 'Stock Check', 'actions' => ['list', 'create', 'edit', 'delete', 'restore']],
        'support_chat' => ['label' => 'Support Chat', 'actions' => ['list', 'create', 'edit', 'delete']],
        'settings' => ['label' => 'Settings', 'actions' => ['list', 'edit']],
        'commission' => ['label' => 'Commission Report', 'actions' => ['list', 'create', 'edit', 'delete', 'restore', 'export']],
        'download' => ['label' => 'Downloads', 'actions' => ['list']],
        'upload' => ['label' => 'Uploads', 'actions' => ['list', 'create', 'delete']],
        'quickbooks' => ['label' => 'QuickBooks', 'actions' => ['list', 'edit']],
        'contact_query' => ['label' => 'Contact Queries', 'actions' => ['list', 'edit', 'delete']],
    ],

    /**
     * Default permissions synced to system roles (non-Admin) on seed.
     * Use "*" within a module to grant all actions for that module.
     *
     * @var array<string, list<string>>
     */
    'default_role_permissions' => [
        'Representative' => [
            'dashboard-view',
            'order-*',
            'quote-*',
            'shipping_quote-*',
            'stock_check-*',
            'claim-*',
            'download-list',
            'upload-*',
            'commission-*',
            'support_chat-list',
        ],
        'Distributor' => [
            'dashboard-view',
            'order-*',
            'quote-*',
            'shipping_quote-*',
            'stock_check-*',
            'claim-*',
            'download-list',
            'upload-*',
            'commission-*',
        ],
        'Dealer' => [
            'dashboard-view',
            'order-*',
            'quote-*',
            'shipping_quote-*',
            'stock_check-*',
            'claim-*',
            'download-list',
            'upload-*',
        ],
        'Showroom' => [
            'dashboard-view',
            'order-*',
            'quote-*',
            'shipping_quote-*',
            'stock_check-*',
            'claim-*',
            'download-list',
            'upload-list',
        ],
        'Customer' => [
            'dashboard-view',
            'order-list',
            'order-create',
            'claim-list',
            'claim-create',
            'download-list',
        ],
    ],

    /**
     * Admin sidebar / nav: permission required to show module (any listed permission grants access).
     *
     * @var array<string, list<string>>
     */
    'nav' => [
        'dashboard' => ['dashboard-view'],
        'users' => ['user-list', 'user-create'],
        'roles' => ['role-list', 'manage_role-list'],
        'products' => ['product-list', 'product_catalog-list', 'product_section-list'],
        'orders' => ['order-list', 'order-create'],
        'claims' => ['claim-list', 'claim-create'],
        'bulletins' => ['bulletin-list', 'bulliten-list', 'bulletin-create', 'bulliten-create'],
        'support_chat' => ['support_chat-list'],
        'settings' => ['settings-list', 'settings-edit'],
        'quotes' => ['quote-list', 'shipping_quote-list'],
        'stock_check' => ['stock_check-list'],
    ],

    /** Rep workspace API type => permission. */
    'rep_workspace_types' => [
        'orders' => 'order-list',
        'quotes' => 'quote-list',
        'shipping-quotes' => 'shipping_quote-list',
        'stock-check' => 'stock_check-list',
        'claims' => 'claim-list',
    ],
];
