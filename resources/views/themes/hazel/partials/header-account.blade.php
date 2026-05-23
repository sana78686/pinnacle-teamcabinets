@php
    $variant = $variant ?? 'desktop';
    $userName = auth()->user()->name ?? auth()->user()->email ?? 'Account';
@endphp
@if ($variant === 'mobile')
    <div class="hz-account hz-account--mobile">
        <span class="hz-account__label"><i class="fa-solid fa-user" aria-hidden="true"></i> {{ $userName }}</span>
        <a href="{{ route('tenant_dashboard') }}">Dashboard</a>
        <a href="{{ route('tenant_profile') }}">Profile</a>
        <form method="POST" action="{{ route('tenant_logout') }}" class="hz-account__logout-form">
            @csrf
            <button type="submit" class="hz-account__logout-btn">Log out</button>
        </form>
    </div>
@else
    <div class="hz-account" id="hz-account">
        <button type="button" class="hz-account__toggle" id="hz-account-btn" aria-label="Account menu" aria-expanded="false" aria-haspopup="true">
            <i class="fa-solid fa-user" aria-hidden="true"></i>
        </button>
        <div class="hz-account__menu" id="hz-account-menu" role="menu" hidden>
            <p class="hz-account__name" role="presentation">{{ $userName }}</p>
            <a href="{{ route('tenant_dashboard') }}" role="menuitem">Dashboard</a>
            <a href="{{ route('tenant_profile') }}" role="menuitem">Profile</a>
            <form method="POST" action="{{ route('tenant_logout') }}" role="none">
                @csrf
                <button type="submit" class="hz-account__logout-btn" role="menuitem">Log out</button>
            </form>
        </div>
    </div>
@endif
