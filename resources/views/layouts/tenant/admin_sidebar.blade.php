<div class="vertical-menu-main tc-tenant-nav">
    <nav id="main-nav" aria-label="Main navigation">
        <ul class="sm pixelstrap tc-nav-menu" id="main-menu">
            <li class="tc-nav-mobile-back">
                <div class="text-right mobile-back">Back<i class="pl-2 fa fa-angle-right" aria-hidden="true"></i></div>
            </li>
            <li class="{{ request()->routeIs('tenant_dashboard') ? 'tc-nav-active' : '' }}">
                <a href="{{ route('tenant_dashboard') }}">
                    <i data-feather="home"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_user_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="users"></i><span>Users</span></a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Users',
                    'items' => [
                        ['url' => route('tenant_user_create'), 'icon' => 'user-plus', 'label' => 'Create User'],
                        ['url' => route('tenant_user_index'), 'icon' => 'list', 'label' => 'Users List'],
                    ],
                ])
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs(['tenant_role_*', 'tenant_manage_role_*']) ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="shield"></i><span>Roles</span></a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Roles',
                    'items' => [
                        ['url' => route('tenant_manage_role_create'), 'icon' => 'sliders', 'label' => 'Manage User Role'],
                        ['url' => route('tenant_role_create'), 'icon' => 'plus-circle', 'label' => 'Create Role'],
                        ['url' => route('tenant_role_index'), 'icon' => 'list', 'label' => 'Roles List'],
                    ],
                ])
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs(['tenant_product_*', 'tenant_door_style_*', 'tenant_product_catalog_*', 'tenant_product_section_*']) ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="package"></i><span>Products</span></a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Products',
                    'items' => [
                        ['url' => route('tenant_product_create'), 'icon' => 'plus-circle', 'label' => 'Create Product'],
                        ['url' => route('tenant_product_index'), 'icon' => 'list', 'label' => 'Products List'],
                        ['url' => route('tenant_product_catalog_create'), 'icon' => 'book', 'label' => 'Create Catalog'],
                        ['url' => route('tenant_product_catalog_index'), 'icon' => 'layers', 'label' => 'Catalog List'],
                        ['url' => route('tenant_product_section_create'), 'icon' => 'folder-plus', 'label' => 'Create Category'],
                        ['url' => route('tenant_product_section_index'), 'icon' => 'folder', 'label' => 'Category List'],
                        ['url' => route('tenant_door_style_create'), 'icon' => 'image', 'label' => 'Create Door Style'],
                        ['url' => route('tenant_door_style_index'), 'icon' => 'grid', 'label' => 'Door Style List'],
                    ],
                ])
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_order_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="shopping-cart"></i><span>Orders</span></a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Orders',
                    'items' => [
                        ['url' => route('tenant_order_workspace'), 'icon' => 'plus-circle', 'label' => 'Create Order'],
                        ['url' => route('tenant_order_list'), 'icon' => 'list', 'label' => 'Orders List'],
                    ],
                ])
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_claim_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="alert-circle"></i><span>Claims</span></a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Claims',
                    'items' => [
                        ['url' => '#', 'icon' => 'plus-circle', 'label' => 'Create Claim'],
                        ['url' => route('tenant_claim_index'), 'icon' => 'list', 'label' => 'Claims List'],
                    ],
                ])
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_bulletin_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="speaker"></i><span>Bulletins</span></a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Bulletins',
                    'items' => [
                        ['url' => route('tenant_bulletin_create'), 'icon' => 'plus-circle', 'label' => 'Create Bulletin'],
                        ['url' => route('tenant_bulletin_index'), 'icon' => 'list', 'label' => 'Bulletins List'],
                    ],
                ])
            </li>
            <li class="{{ request()->routeIs(['tenant_settings_hub', 'tenant_site_setting', 'tenant_website_designing', 'tenant_home_setting_*', 'tenant_setting_manage_index', 'tenant_setting_manage_contact_*', 'tenant_storefront_about', 'tenant_storefront_blog', 'tenant_setting_*', 'pages.*', 'tenant_frontend_theme*']) ? 'tc-nav-active' : '' }}">
                <a href="{{ route('tenant_settings_hub') }}">
                    <i data-feather="settings"></i><span>Settings</span>
                </a>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_stock_check_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="layers"></i><span>Stock Check</span></a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Stock Check',
                    'items' => [
                        ['url' => route('tenant_order_workspace'), 'icon' => 'plus-circle', 'label' => 'Create Stock Check'],
                        ['url' => route('tenant_stock_check_index'), 'icon' => 'list', 'label' => 'Stock Check List'],
                    ],
                ])
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs(['tenant_quotes_*', 'tenant_shipping_quotes_*']) ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="file-text"></i><span>Quotes</span></a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Quotes',
                    'items' => [
                        ['url' => route('tenant_order_workspace'), 'icon' => 'plus-circle', 'label' => 'Create Quote'],
                        ['url' => route('tenant_quotes_index'), 'icon' => 'list', 'label' => 'Quotes List'],
                        ['url' => route('tenant_order_workspace'), 'icon' => 'truck', 'label' => 'Create Shipping Quote'],
                        ['url' => route('tenant_shipping_quotes_index'), 'icon' => 'list', 'label' => 'Shipping Quotes List'],
                    ],
                ])
            </li>
        </ul>
    </nav>
</div>
