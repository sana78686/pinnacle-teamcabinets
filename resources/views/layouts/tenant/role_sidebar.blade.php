@php
    $tcNavBadges = $tcNavBadges ?? [];
    $affiliateCount = auth()->check()
        ? \App\Models\User::query()->where('parent_id', auth()->id())->count()
        : 0;
@endphp
<div class="vertical-menu-main tc-tenant-nav">
    <nav id="main-nav" aria-label="Main navigation">
        <ul class="sm pixelstrap tc-nav-menu" id="main-menu">
            <li class="tc-nav-mobile-back">
                <div class="text-right mobile-back">Back<i class="pl-2 fa fa-angle-right" aria-hidden="true"></i></div>
            </li>
            <li class="{{ request()->routeIs('tenant_dashboard', 'tenant_profile*') ? 'tc-nav-active' : '' }}">
                <a href="{{ route('tenant_dashboard') }}">
                    <i data-feather="home"></i><span>Home</span>
                </a>
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs(['tenant_order_*', 'tenant_quotes_*', 'tenant_shipping_quotes_*', 'tenant_stock_check_*', 'tenant_claim_*']) ? 'tc-nav-active' : '' }}" data-nav-module="orders">
                <a href="#">
                    <i data-feather="shopping-cart"></i><span>Orders</span>
                    @if ((int) ($tcNavBadges['orders'] ?? 0) > 0)
                        <span class="tc-nav-module-dot is-visible" data-nav-badge="orders" aria-hidden="true"></span>
                    @endif
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Orders',
                    'items' => [
                        ['url' => route('tenant_order_workspace'), 'icon' => 'plus-circle', 'label' => 'Create Order'],
                        ['url' => route('tenant_order_list'), 'icon' => 'list', 'label' => 'My Orders', 'badge_key' => 'orders_list'],
                        ['url' => route('tenant_quotes_index'), 'icon' => 'file-text', 'label' => 'My Quotes', 'badge_key' => 'quotes_list'],
                        ['url' => route('tenant_shipping_quotes_index'), 'icon' => 'truck', 'label' => 'Shipping Quotes', 'badge_key' => 'shipping_quotes_list'],
                        ['url' => route('tenant_stock_check_index'), 'icon' => 'search', 'label' => 'Stock Check', 'badge_key' => 'stock_check_list'],
                        ['url' => route('tenant_claim_index'), 'icon' => 'alert-circle', 'label' => 'Claims', 'badge_key' => 'claims_list'],
                    ],
                ])
            </li>
            <li class="tc-nav-has-children {{ request()->routeIs('tenant_user_child_*') ? 'tc-nav-active' : '' }}">
                <a href="#">
                    <i data-feather="users"></i><span>Affiliates</span>
                    @if ($affiliateCount > 0)
                        <span class="tc-nav-list-badge is-visible">{{ $affiliateCount > 99 ? '99+' : $affiliateCount }}</span>
                    @endif
                </a>
                @include('layouts.tenant.partials.nav-dropdown', [
                    'title' => 'Affiliates',
                    'items' => [
                        ['url' => route('tenant_user_child_create'), 'icon' => 'user-plus', 'label' => 'Create Affiliate'],
                        ['url' => route('tenant_user_child_index'), 'icon' => 'list', 'label' => 'Affiliates List'],
                    ],
                ])
            </li>
            <li class="{{ request()->routeIs('tenant_commission_report_*') ? 'tc-nav-active' : '' }}">
                <a href="{{ route('tenant_commission_report_index') }}">
                    <i data-feather="trending-up"></i><span>Commission Report</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
