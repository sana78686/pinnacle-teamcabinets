@php($tcNavBadges = $tcNavBadges ?? [])
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
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_user_*') ? 'tc-nav-active' : '' }}" data-nav-module="users">
                <a href="#">
                    <i data-feather="users"></i><span>Users</span>
                    <span class="tc-nav-module-dot{{ (int) ($tcNavBadges['users'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="users" {{ (int) ($tcNavBadges['users'] ?? 0) <= 0 ? 'hidden' : '' }} aria-hidden="true"></span>
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Users',
                    'items' => [
                        ['url' => route('tenant_user_create'), 'icon' => 'user-plus', 'label' => 'Create User'],
                        ['url' => route('tenant_user_index'), 'icon' => 'list', 'label' => 'Users List', 'badge_key' => 'users_list'],
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
            <li class="{{ request()->routeIs(config('tenant_products_menu.chrome_route_patterns', [])) ? 'tc-nav-active' : '' }}">
                <a href="{{ route('tenant_products_hub') }}"><i data-feather="package"></i><span>Products</span></a>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_order_*') ? 'tc-nav-active' : '' }}" data-nav-module="orders">
                <a href="#">
                    <i data-feather="shopping-cart"></i><span>Orders</span>
                    <span class="tc-nav-module-dot{{ (int) ($tcNavBadges['orders'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="orders" {{ (int) ($tcNavBadges['orders'] ?? 0) <= 0 ? 'hidden' : '' }} aria-hidden="true"></span>
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Orders',
                    'items' => [
                        ['url' => route('tenant_order_workspace'), 'icon' => 'plus-circle', 'label' => 'Create Order'],
                        ['url' => route('tenant_order_list'), 'icon' => 'list', 'label' => 'Orders List', 'badge_key' => 'orders_list'],
                    ],
                ])
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_claim_*') ? 'tc-nav-active' : '' }}" data-nav-module="claims">
                <a href="#">
                    <i data-feather="alert-circle"></i><span>Claims</span>
                    <span class="tc-nav-module-dot{{ (int) ($tcNavBadges['claims'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="claims" {{ (int) ($tcNavBadges['claims'] ?? 0) <= 0 ? 'hidden' : '' }} aria-hidden="true"></span>
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Claims',
                    'items' => [
                        ['url' => route('tenant_claim_create'), 'icon' => 'plus-circle', 'label' => 'Create Claim'],
                        ['url' => route('tenant_claim_index'), 'icon' => 'list', 'label' => 'Claims List', 'badge_key' => 'claims_list'],
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
            <li class="tc-nav-has-children {{ request()->routeIs(['tenant_quotes_*', 'tenant_shipping_quotes_*']) ? 'tc-nav-active' : '' }}" data-nav-module="quotes">
                <a href="#">
                    <i data-feather="file-text"></i><span>Quotes</span>
                    <span class="tc-nav-module-dot{{ (int) ($tcNavBadges['quotes'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="quotes" {{ (int) ($tcNavBadges['quotes'] ?? 0) <= 0 ? 'hidden' : '' }} aria-hidden="true"></span>
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Quotes',
                    'items' => [
                        ['url' => route('tenant_quotes_index'), 'icon' => 'list', 'label' => 'Quotes List', 'badge_key' => 'quotes_list'],
                        ['url' => route('tenant_shipping_quotes_index'), 'icon' => 'list', 'label' => 'Shipping Quotes List', 'badge_key' => 'shipping_quotes_list'],
                    ],
                ])
            </li>
        </ul>
    </nav>
</div>
