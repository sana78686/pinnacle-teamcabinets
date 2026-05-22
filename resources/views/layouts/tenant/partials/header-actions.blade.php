@php
    $tcUser = auth()->user();
    $tcUserName = $tcUser?->name ?? 'User';
    $tcUserEmail = $tcUser?->email ?? '';
    $tcUserRole = $tcUser?->getRoleNames()->implode(', ') ?: 'User';
    $tcUserAvatar = $tcUser?->logo ? asset($tcUser->logo) : null;
    $tcUserInitials = $tcUser?->initials ?? 'U';
@endphp
<ul class="nav-menus tc-pn-nav-menus d-flex align-items-center flex-nowrap list-unstyled mb-0">
    @if (!empty($tcSubscriptionStatus) && $tcSubscriptionStatus === 'active' && !empty($tcTenant?->subscription_ends_at) && empty($tcShowTrialBanner))
        <li class="d-none d-md-flex align-items-center">
            <span class="badge badge-success f-12" role="status">
                Paid until {{ $tcTenant->subscription_ends_at->format('M j, Y') }}
            </span>
        </li>
        <li class="d-none d-md-flex align-items-center txt-muted f-12 px-1" aria-hidden="true">|</li>
    @endif

    @include('layouts.tenant.partials.panel-search')
    <li>
        <a class="tc-header-icon-btn" href="#!" onclick="javascript:toggleFullScreen(); return false;" aria-label="Fullscreen">
            <i data-feather="maximize"></i>
        </a>
    </li>
    @auth
        @include('layouts.tenant.partials.notifications-dropdown')
    @endauth
    <li class="onhover-dropdown tc-profile-wrap tc-header-user tc-pn-header-user">
        <button type="button" class="tc-profile-trigger" aria-haspopup="true" aria-expanded="false">
            <span class="tc-profile-trigger__text d-none d-md-block">
                <span class="tc-profile-trigger__name">{{ $tcUserName }}</span>
                <span class="tc-profile-trigger__role">{{ $tcUserRole }}</span>
            </span>
            <span class="tc-header-avatar" title="{{ $tcUserName }}">
                @if ($tcUserAvatar)
                    <img src="{{ $tcUserAvatar }}" alt="{{ $tcUserName }}" class="tc-header-avatar__img">
                @else
                    <span class="tc-header-avatar__initials">{{ $tcUserInitials }}</span>
                @endif
            </span>
        </button>
        <ul class="onhover-show-div profile-dropdown tc-header-dropdown" role="menu">
            <li class="tc-header-dropdown__head">
                <h5>{{ $tcUserName }}</h5>
                @if ($tcUserEmail)
                    <span class="tc-header-dropdown__email">{{ $tcUserEmail }}</span>
                @endif
                <span class="tc-header-dropdown__role">{{ $tcUserRole }}</span>
            </li>
            <li class="tc-header-dropdown__item">
                <a href="{{ Auth::user()->hasRole('Admin') ? route('tenant_setting_profile') : route('tenant_profile') }}" role="menuitem">
                    <i data-feather="user" aria-hidden="true"></i>
                    <span>{{ __('Profile') }}</span>
                </a>
            </li>
            <li class="tc-header-dropdown__item">
                <a href="{{ route('tenant_settings_hub') }}" role="menuitem">
                    <i data-feather="settings" aria-hidden="true"></i>
                    <span>{{ __('Settings') }}</span>
                </a>
            </li>
            <li class="tc-header-dropdown__item">
                <a href="{{ route('tenant_notifications_index') }}" role="menuitem">
                    <i data-feather="bell" aria-hidden="true"></i>
                    <span>{{ __('All notifications') }}</span>
                </a>
            </li>
            <li class="tc-header-dropdown__item tc-header-dropdown__item--danger">
                <form action="{{ route('tenant_logout') }}" method="POST" class="m-0 w-100">
                    @csrf
                    <button type="submit" class="tc-header-dropdown__logout" role="menuitem">
                        <i data-feather="log-out" aria-hidden="true"></i>
                        <span>{{ __('Logout') }}</span>
                    </button>
                </form>
            </li>
        </ul>
    </li>
</ul>
