@php
    $pinnacle = $pinnacle ?? config('pinnacle');
    $nav = [
        ['route' => 'pinnacle.services', 'label' => 'Services', 'paths' => ['services', 'features']],
        ['route' => 'pinnacle.team-cabinets', 'label' => 'Team Cabinets', 'paths' => ['team-cabinets']],
        ['route' => 'pinnacle.find-tenant', 'label' => 'Find tenant', 'paths' => ['find-tenant']],
        ['route' => 'pinnacle.contact', 'label' => 'Contact', 'paths' => ['contact']],
    ];
    $isActive = fn ($paths) => collect($paths)->contains(fn ($p) => request()->is($p));
    $superAdmin = auth()->check() && auth()->user()->is_super_user;
@endphp
<header class="pn-header">
    <div class="pn-container pn-header__inner">
        <a href="{{ route('/') }}" class="pn-logo" title="Pinnacle home">
            <img src="{{ asset('assets/logo/pinnacle.png') }}" alt="{{ $pinnacle['name'] }}">
        </a>
        <nav class="pn-nav" aria-label="Main">
            @foreach ($nav as $item)
                <a href="{{ route($item['route']) }}" class="{{ $isActive($item['paths']) ? 'is-active' : '' }}">{{ $item['label'] }}</a>
            @endforeach
        </nav>
        <div class="pn-header__actions">
            @if ($superAdmin)
                <a href="{{ route('dashboard') }}" class="pn-profile-btn" title="Super admin dashboard" aria-label="Open dashboard">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z"/>
                    </svg>
                </a>
            @else
                <a href="{{ route('auth_login') }}" class="pn-btn pn-btn--outline-navy pn-btn--sm">Admin login</a>
            @endif
            <a href="{{ route('registeration') }}" class="pn-btn pn-btn--primary pn-btn--sm">Get started</a>
        </div>
        <button type="button" class="pn-menu-btn" id="pn-menu-btn" aria-label="Open menu" aria-expanded="false" aria-controls="pn-mobile-nav">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>
    <nav class="pn-mobile-nav" id="pn-mobile-nav" aria-label="Mobile">
        @foreach ($nav as $item)
            <a href="{{ route($item['route']) }}">{{ $item['label'] }}</a>
        @endforeach
        @if ($superAdmin)
            <a href="{{ route('dashboard') }}" class="pn-profile-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" width="22" height="22" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.5-1.632z"/>
                </svg>
                <span>Dashboard</span>
            </a>
        @else
            <a href="{{ route('auth_login') }}" class="pn-btn pn-btn--outline-navy pn-btn--block">Admin login</a>
        @endif
        <a href="{{ route('registeration') }}" class="pn-btn pn-btn--primary pn-btn--block">Get started</a>
    </nav>
</header>
<style>[x-cloak]{display:none!important}</style>
