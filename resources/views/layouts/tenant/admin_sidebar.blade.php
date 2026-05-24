@php($tcNavBadges = $tcNavBadges ?? [])
<div class="vertical-menu-main tc-tenant-nav">
    <nav id="main-nav" aria-label="Main navigation">
        <ul class="sm pixelstrap tc-nav-menu" id="main-menu">
            <li class="tc-nav-mobile-back">
                <div class="text-right mobile-back">Back<i class="pl-2 fa fa-angle-right" aria-hidden="true"></i></div>
            </li>
            @if (tenant_can_nav('dashboard'))
            <li class="{{ request()->routeIs('tenant_dashboard') ? 'tc-nav-active' : '' }}">
                <a href="{{ route('tenant_dashboard') }}">
                    <i data-feather="home"></i><span>Dashboard</span>
                </a>
            </li>
            @endif
            @if (tenant_can_nav('users'))
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_user_*') ? 'tc-nav-active' : '' }}" data-nav-module="users">
                <a href="#">
                    <i data-feather="users"></i><span>Users</span>
                    <span class="tc-nav-module-dot{{ (int) ($tcNavBadges['users'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="users" {{ (int) ($tcNavBadges['users'] ?? 0) <= 0 ? 'hidden' : '' }} aria-hidden="true"></span>
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Users',
                    'items' => array_filter([
                        tenant_can('user-create') ? ['url' => route('tenant_user_create'), 'icon' => 'user-plus', 'label' => 'Create User'] : null,
                        tenant_can('user-list') ? ['url' => route('tenant_user_index'), 'icon' => 'list', 'label' => 'Users List', 'badge_key' => 'users_list'] : null,
                    ]),
                ])
            </li>
            @endif
            @if (tenant_can_nav('roles'))
            <li class="tc-nav-has-children {{ request()->routeIs(['tenant_role_*', 'tenant_manage_role_*']) ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="shield"></i><span>Roles</span></a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Roles',
                    'items' => array_filter([
                        tenant_can('manage_role-list') ? ['url' => route('tenant_manage_role_create'), 'icon' => 'sliders', 'label' => 'Manage User Role'] : null,
                        tenant_can('role-create') ? ['url' => route('tenant_role_create'), 'icon' => 'plus-circle', 'label' => 'Create Role'] : null,
                        tenant_can('role-list') ? ['url' => route('tenant_role_index'), 'icon' => 'list', 'label' => 'Roles List'] : null,
                    ]),
                ])
            </li>
            @endif
            @if (tenant_can_nav('products'))
            <li class="{{ request()->routeIs(config('tenant_products_menu.chrome_route_patterns', [])) ? 'tc-nav-active' : '' }}">
                <a href="{{ route('tenant_products_hub') }}"><i data-feather="package"></i><span>Products</span></a>
            </li>
            @endif
            @if (tenant_can_nav('orders'))
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_order_*') ? 'tc-nav-active' : '' }}" data-nav-module="orders">
                <a href="#">
                    <i data-feather="shopping-cart"></i><span>Orders</span>
                    <span class="tc-nav-module-dot{{ (int) ($tcNavBadges['orders'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="orders" {{ (int) ($tcNavBadges['orders'] ?? 0) <= 0 ? 'hidden' : '' }} aria-hidden="true"></span>
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Orders',
                    'items' => array_filter([
                        tenant_can('order-create') ? ['url' => route('tenant_order_workspace'), 'icon' => 'plus-circle', 'label' => 'Create Order'] : null,
                        tenant_can('order-list') ? ['url' => route('tenant_order_list'), 'icon' => 'list', 'label' => 'Orders List', 'badge_key' => 'orders_list'] : null,
                    ]),
                ])
            </li>
            @endif
            @if (tenant_can_nav('quotes'))
            <li class="tc-nav-has-children {{ request()->routeIs(['tenant_quotes_*', 'tenant_shipping_quotes_*']) ? 'tc-nav-active' : '' }}" data-nav-module="quotes">
                <a href="#">
                    <i data-feather="file-text"></i><span>Quotes</span>
                    <span class="tc-nav-module-dot{{ (int) ($tcNavBadges['quotes'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="quotes" {{ (int) ($tcNavBadges['quotes'] ?? 0) <= 0 ? 'hidden' : '' }} aria-hidden="true"></span>
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Quotes',
                    'items' => array_filter([
                        tenant_can('quote-list') ? ['url' => route('tenant_quotes_index'), 'icon' => 'list', 'label' => 'Quotes List', 'badge_key' => 'quotes_list'] : null,
                        tenant_can('shipping_quote-list') ? ['url' => route('tenant_shipping_quotes_index'), 'icon' => 'list', 'label' => 'Shipping Quotes List', 'badge_key' => 'shipping_quotes_list'] : null,
                    ]),
                ])
            </li>
            @endif
            @if (tenant_can_nav('stock_check'))
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_stock_check_*') ? 'tc-nav-active' : '' }}" data-nav-module="stock_check">
                <a href="#">
                    <i data-feather="search"></i><span>Stock Check</span>
                    <span class="tc-nav-module-dot{{ (int) ($tcNavBadges['stock_check'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="stock_check" {{ (int) ($tcNavBadges['stock_check'] ?? 0) <= 0 ? 'hidden' : '' }} aria-hidden="true"></span>
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Stock Check',
                    'items' => array_filter([
                        tenant_can('stock_check-list') ? ['url' => route('tenant_stock_check_index'), 'icon' => 'list', 'label' => 'Stock Check Requests', 'badge_key' => 'stock_check_list'] : null,
                    ]),
                ])
            </li>
            @endif
            @if (tenant_can_nav('claims'))
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_claim_*') ? 'tc-nav-active' : '' }}" data-nav-module="claims">
                <a href="#">
                    <i data-feather="alert-circle"></i><span>Claims</span>
                    <span class="tc-nav-module-dot{{ (int) ($tcNavBadges['claims'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="claims" {{ (int) ($tcNavBadges['claims'] ?? 0) <= 0 ? 'hidden' : '' }} aria-hidden="true"></span>
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Claims',
                    'items' => array_filter([
                        tenant_can('claim-create') ? ['url' => route('tenant_claim_create'), 'icon' => 'plus-circle', 'label' => 'Create Claim'] : null,
                        tenant_can('claim-list') ? ['url' => route('tenant_claim_index'), 'icon' => 'list', 'label' => 'Claims List', 'badge_key' => 'claims_list'] : null,
                    ]),
                ])
            </li>
            @endif
            @if (tenant_can_nav('bulletins'))
            <li class="{{ request()->routeIs('tenant_bulletin_*') ? 'tc-nav-active' : '' }}">
                <a href="#"><i data-feather="speaker"></i><span>Bulletins</span></a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Bulletins',
                    'items' => array_filter([
                        tenant_can('bulletin-create') || tenant_can('bulliten-create') ? ['url' => route('tenant_bulletin_create'), 'icon' => 'plus-circle', 'label' => 'Create Bulletin'] : null,
                        tenant_can('bulletin-list') || tenant_can('bulliten-list') ? ['url' => route('tenant_bulletin_index'), 'icon' => 'list', 'label' => 'Bulletins List'] : null,
                    ]),
                ])
            </li>
            @endif
            @if (tenant_can_nav('support_chat'))
            <li class="{{ request()->routeIs('tenant_support_chat_*') ? 'tc-nav-active' : '' }}" data-nav-module="support_chat">
                <a href="{{ route('tenant_support_chat_index') }}">
                    <i data-feather="message-circle"></i><span>Support Chat</span>
                    <span class="tc-nav-module-dot{{ (int) ($tcNavBadges['support_chat'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="support_chat" {{ (int) ($tcNavBadges['support_chat'] ?? 0) <= 0 ? 'hidden' : '' }} aria-hidden="true"></span>
                </a>
            </li>
            @endif
            @if (tenant_can_nav('settings'))
            <li class="{{ request()->routeIs(['tenant_settings_hub', 'tenant_site_setting', 'tenant_website_designing', 'tenant_home_setting_*', 'tenant_setting_manage_index', 'tenant_setting_manage_contact_*', 'tenant_storefront_about', 'tenant_storefront_blog', 'tenant_setting_*', 'pages.*', 'tenant_frontend_theme*']) ? 'tc-nav-active' : '' }}">
                <a href="{{ route('tenant_settings_hub') }}">
                    <i data-feather="settings"></i><span>Settings</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>
</div>
