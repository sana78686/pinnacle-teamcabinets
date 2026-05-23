@php
    $affiliateCount = auth()->check()
        ? \App\Models\User::query()->where('parent_id', auth()->id())->count()
        : 0;
@endphp
<div class="iconsidebar-menu iconbar-mainmenu-close">
    <div class="sidebar">
        <ul class="iconMenu-bar custom-scrollbar">
            <li class="{{ request()->routeIs('tenant_dashboard', 'tenant_profile*') ? 'open' : '' }}">
                <a class="bar-icons" href="javascript:;">
                    <i class="pe-7s-home"></i><span>Home</span>
                </a>
                <ul class="iconbar-mainmenu custom-scrollbar">
                    <li class="iconbar-header">Dashboard</li>
                    <li class="{{ request()->routeIs('tenant_dashboard') ? 'active' : '' }}">
                        <a href="{{ route('tenant_dashboard') }}">Dashboard</a>
                    </li>
                    <li class="{{ request()->routeIs('tenant_profile*') ? 'active' : '' }}">
                        <a href="{{ route('tenant_profile') }}">My Profile</a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->routeIs(['tenant_order_*', 'tenant_quotes_*', 'tenant_shipping_quotes_*', 'tenant_stock_check_*', 'tenant_claim_*']) ? 'open' : '' }}">
                <a class="bar-icons" href="javascript:;">
                    <i class="pe-7s-portfolio"></i><span>Orders</span>
                </a>
                <ul class="iconbar-mainmenu custom-scrollbar">
                    <li class="iconbar-header">Orders</li>
                    <li class="{{ request()->routeIs('tenant_order_workspace*') ? 'active' : '' }}">
                        <a href="{{ route('tenant_order_workspace') }}">Create Order</a>
                    </li>
                    <li class="{{ request()->routeIs('tenant_order_list', 'tenant_order_show*') ? 'active' : '' }}">
                        <a href="{{ route('tenant_order_list') }}">My Orders</a>
                    </li>
                    <li class="{{ request()->routeIs('tenant_quotes_*') ? 'active' : '' }}">
                        <a href="{{ route('tenant_quotes_index') }}">My Quotes</a>
                    </li>
                    <li class="{{ request()->routeIs('tenant_shipping_quotes_*') ? 'active' : '' }}">
                        <a href="{{ route('tenant_shipping_quotes_index') }}">Shipping Quotes</a>
                    </li>
                    <li class="{{ request()->routeIs('tenant_stock_check_*') ? 'active' : '' }}">
                        <a href="{{ route('tenant_stock_check_index') }}">Stock Check</a>
                    </li>
                    <li class="{{ request()->routeIs('tenant_claim_*') ? 'active' : '' }}">
                        <a href="{{ route('tenant_claim_index') }}">Claims</a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('tenant_user_child_*') ? 'open' : '' }}">
                @if ($affiliateCount > 0)
                    <span class="badge rounded-pill badge-danger">{{ $affiliateCount > 99 ? '99+' : $affiliateCount }}</span>
                @endif
                <a class="bar-icons" href="javascript:;">
                    <i class="pe-7s-diamond"></i><span>Affiliates</span>
                </a>
                <ul class="iconbar-mainmenu custom-scrollbar">
                    <li class="iconbar-header">Affiliates</li>
                    <li class="{{ request()->routeIs('tenant_user_child_create') ? 'active' : '' }}">
                        <a href="{{ route('tenant_user_child_create') }}">Create Affiliate</a>
                    </li>
                    <li class="{{ request()->routeIs('tenant_user_child_index') ? 'active' : '' }}">
                        <a href="{{ route('tenant_user_child_index') }}">Affiliates List</a>
                    </li>
                </ul>
            </li>
            <li class="{{ request()->routeIs('tenant_commission_report_*') ? 'open' : '' }}">
                <a class="bar-icons" href="javascript:;">
                    <i class="pe-7s-id"></i><span>Commission</span>
                </a>
                <ul class="iconbar-mainmenu custom-scrollbar">
                    <li class="iconbar-header">Commission Report</li>
                    <li class="{{ request()->routeIs('tenant_commission_report_*') ? 'active' : '' }}">
                        <a href="{{ route('tenant_commission_report_index') }}">View Report</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
