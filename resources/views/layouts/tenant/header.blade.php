{{-- Corporate Pinnacle header (pinnacle.partials.nav) — tenant panel --}}
@php
    $tcTenantName = tenant('company_name') ?? tenant('name') ?? config('app.name');
    $tcLogoUrl = $tcSiteLogo ?? \App\Models\SiteSetting::first()?->logo;
@endphp
<header class="pn-header tc-pn-header" style="height:auto !important">
    <div class="pn-container pn-header__inner d-flex align-items-center justify-content-between flex-nowrap w-100">
        <a href="{{ route('tenant_dashboard') }}" class="pn-logo flex-shrink-1 text-truncate" title="{{ $tcTenantName }}">
            @if (!empty($tcLogoUrl))
                <img src="{{ asset($tcLogoUrl) }}" alt="{{ $tcTenantName }}">
            @else
                <span class="tc-pn-header__brand-text">{{ $tcTenantName }}</span>
            @endif
        </a>

        <div class="pn-header__actions tc-pn-header__actions nav-right right-menu flex-shrink-0 d-flex align-items-center">
            @auth
                @include(tenant_user_is_panel_admin() ? 'layouts.tenant.partials.header-actions' : 'layouts.tenant.role.partials.header-actions')
            @endauth
        </div>

        <button type="button" class="pn-menu-btn tc-pn-menu-btn flex-shrink-0 d-xl-none" id="tc-pn-menu-btn" aria-label="Open menu" aria-expanded="false" aria-controls="main-nav">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
</header>
