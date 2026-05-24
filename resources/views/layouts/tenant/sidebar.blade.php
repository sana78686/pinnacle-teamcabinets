@php
    $affiliateCount = auth()->check()
        ? \App\Models\User::query()->where('parent_id', auth()->id())->count()
        : 0;
    $isAffiliatePanel = tenant_user_is_affiliate_panel();
    $childUserLabel = auth()->user()?->hasRole('Representative') ? 'Add User' : 'Create Affiliate';
    $tcNavBadges = $tcNavBadges ?? [];
@endphp
<div class="iconsidebar-menu iconbar-mainmenu-close tc-compact-icon-sidebar">
    <div class="sidebar">
        <ul class="iconMenu-bar custom-scrollbar">
            @if (tenant_can('dashboard-view'))
            <li class="{{ request()->routeIs('tenant_dashboard') ? 'open' : '' }}">
                <a class="bar-icons" href="{{ route('tenant_dashboard') }}">
                    <i class="pe-7s-home"></i><span>Dashboard</span>
                </a>
            </li>
            @endif
            @if (tenant_can('order-list'))
            <li class="{{ request()->routeIs('tenant_order_*') && ! request()->routeIs(['tenant_quotes_*', 'tenant_shipping_quotes_*', 'tenant_stock_check_*', 'tenant_claim_*']) ? 'open' : '' }}">
                <a class="bar-icons" href="{{ route('tenant_order_list') }}">
                    @if ((int) ($tcNavBadges['orders_list'] ?? 0) > 0)
                        <span class="tc-nav-list-badge is-visible" data-nav-badge="orders_list">{{ (int) $tcNavBadges['orders_list'] > 99 ? '99+' : (int) $tcNavBadges['orders_list'] }}</span>
                    @endif
                    <i class="pe-7s-portfolio"></i><span>My Orders</span>
                </a>
            </li>
            @endif
            @if (tenant_can('quote-list'))
            <li class="{{ request()->routeIs('tenant_quotes_*') ? 'open' : '' }}">
                <a class="bar-icons" href="{{ route('tenant_quotes_index') }}">
                    @if ((int) ($tcNavBadges['quotes_list'] ?? 0) > 0)
                        <span class="tc-nav-list-badge is-visible" data-nav-badge="quotes_list">{{ (int) $tcNavBadges['quotes_list'] > 99 ? '99+' : (int) $tcNavBadges['quotes_list'] }}</span>
                    @endif
                    <i class="pe-7s-note2"></i><span>My Quotes</span>
                </a>
            </li>
            @endif
            @if (tenant_can('shipping_quote-list'))
            <li class="{{ request()->routeIs('tenant_shipping_quotes_*') ? 'open' : '' }}">
                <a class="bar-icons" href="{{ route('tenant_shipping_quotes_index') }}">
                    @if ((int) ($tcNavBadges['shipping_quotes_list'] ?? 0) > 0)
                        <span class="tc-nav-list-badge is-visible" data-nav-badge="shipping_quotes_list">{{ (int) $tcNavBadges['shipping_quotes_list'] > 99 ? '99+' : (int) $tcNavBadges['shipping_quotes_list'] }}</span>
                    @endif
                    <i class="pe-7s-car"></i><span>My Shipping Quotes</span>
                </a>
            </li>
            @endif
            @if (tenant_can('stock_check-list'))
            <li class="{{ request()->routeIs('tenant_stock_check_*') ? 'open' : '' }}">
                <a class="bar-icons" href="{{ route('tenant_stock_check_index') }}">
                    @if ((int) ($tcNavBadges['stock_check_list'] ?? 0) > 0)
                        <span class="tc-nav-list-badge is-visible" data-nav-badge="stock_check_list">{{ (int) $tcNavBadges['stock_check_list'] > 99 ? '99+' : (int) $tcNavBadges['stock_check_list'] }}</span>
                    @endif
                    <i class="pe-7s-search"></i><span>My Stock Check Request</span>
                </a>
            </li>
            @endif
            @if (tenant_can('claim-list'))
            <li class="{{ request()->routeIs('tenant_claim_*') ? 'open' : '' }}">
                <a class="bar-icons" href="{{ route('tenant_claim_index') }}">
                    @if ((int) ($tcNavBadges['claims_list'] ?? 0) > 0)
                        <span class="tc-nav-list-badge is-visible" data-nav-badge="claims_list">{{ (int) $tcNavBadges['claims_list'] > 99 ? '99+' : (int) $tcNavBadges['claims_list'] }}</span>
                    @endif
                    <i class="pe-7s-attention"></i><span>My Claims</span>
                </a>
            </li>
            @endif
            @if (tenant_can('download-list'))
            <li class="{{ request()->routeIs('tenant_downloads_index') ? 'open' : '' }}">
                <a class="bar-icons" href="{{ route('tenant_downloads_index') }}">
                    <i class="pe-7s-download"></i><span>Downloads</span>
                </a>
            </li>
            @endif
            @if (tenant_can('upload-list') || tenant_can('upload-create'))
            <li class="{{ request()->routeIs('tenant_uploads_*') ? 'open' : '' }}">
                <a class="bar-icons" href="{{ route('tenant_uploads_index') }}">
                    <i class="pe-7s-upload"></i><span>Uploads</span>
                </a>
            </li>
            @endif
            <li class="{{ request()->routeIs('tenant_profile*') ? 'open' : '' }}">
                <a class="bar-icons" href="{{ route('tenant_profile') }}">
                    <i class="pe-7s-user"></i><span>Profile</span>
                </a>
            </li>
            <li class="{{ request()->routeIs('tenant_support_chat_*') ? 'open' : '' }}">
                <a class="bar-icons" href="{{ route('tenant_support_chat_user') }}">
                    <span class="tc-nav-list-badge{{ (int) ($tcNavBadges['support_chat'] ?? 0) > 0 ? ' is-visible' : '' }}" data-nav-badge="support_chat" {{ (int) ($tcNavBadges['support_chat'] ?? 0) <= 0 ? 'hidden' : '' }}>{{ (int) ($tcNavBadges['support_chat'] ?? 0) > 99 ? '99+' : (int) ($tcNavBadges['support_chat'] ?? 0) }}</span>
                    <i class="pe-7s-chat"></i><span>Support</span>
                </a>
            </li>
            @if (! $isAffiliatePanel && tenant_can('commission-list'))
                <li class="{{ request()->routeIs('tenant_commission_report_*') ? 'open' : '' }}">
                    <a class="bar-icons" href="{{ route('tenant_commission_report_index') }}">
                        <i class="pe-7s-id"></i><span>Commission</span>
                    </a>
                </li>
                @if (tenant_can('user-create') || tenant_can('user-list'))
                <li class="{{ request()->routeIs('tenant_user_child_*') ? 'open' : '' }}">
                    @if ($affiliateCount > 0)
                        <span class="badge rounded-pill badge-danger">{{ $affiliateCount > 99 ? '99+' : $affiliateCount }}</span>
                    @endif
                    <a class="bar-icons" href="{{ route('tenant_user_child_index') }}">
                        <i class="pe-7s-diamond"></i><span>Affiliates</span>
                    </a>
                </li>
                @endif
            @endif
            <li>
                <a class="bar-icons" href="{{ route('tenant_profile') }}#tc-change-password">
                    <i class="pe-7s-key"></i><span>Password</span>
                </a>
            </li>
            <li>
                <a class="bar-icons" href="#tc-order-help-modal" data-bs-toggle="modal" data-bs-target="#tc-order-help-modal">
                    <i class="pe-7s-help"></i><span>Help</span>
                </a>
            </li>
        </ul>
    </div>
</div>
