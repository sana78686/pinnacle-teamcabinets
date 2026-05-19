<ul class="nav-menus">
    @if (!empty($tcShowTrialBanner) && $tcTrialEndsAt)
        <li class="d-none d-md-flex align-items-center">
            <span class="badge badge-warning f-12" role="status">
                Trial until {{ $tcTrialEndsAt->format('M j, Y') }}
            </span>
        </li>
        <li class="d-none d-md-flex align-items-center txt-muted f-12 px-1" aria-hidden="true">|</li>
    @elseif (!empty($tcSubscriptionStatus) && $tcSubscriptionStatus === 'active' && !empty($tcTenant?->subscription_ends_at))
        <li class="d-none d-md-flex align-items-center">
            <span class="badge badge-success f-12" role="status">
                Paid until {{ $tcTenant->subscription_ends_at->format('M j, Y') }}
            </span>
        </li>
        <li class="d-none d-md-flex align-items-center txt-muted f-12 px-1" aria-hidden="true">|</li>
    @endif

    <li class="d-none d-lg-block">
        <form class="form-inline search-form mb-0" action="#" method="get">
            <div class="form-group mb-0">
                <div class="Typeahead Typeahead--twitterUsers">
                    <div class="u-posRelative">
                        <input class="Typeahead-input form-control-plaintext" type="text" name="q"
                            placeholder="Search…" autocomplete="off">
                        <span class="d-sm-none mobile-search"><i data-feather="search"></i></span>
                    </div>
                </div>
            </div>
        </form>
    </li>
    <li class="d-lg-none">
        <a class="text-dark" href="#!" aria-label="Search"><i data-feather="search"></i></a>
    </li>
    <li>
        <a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()" aria-label="Fullscreen">
            <i data-feather="maximize"></i>
        </a>
    </li>
    @auth
        @include('layouts.tenant.partials.notifications-dropdown')
    @endauth
    <li class="onhover-dropdown tc-header-user pl-2 ml-1 border-left">
        <div class="d-flex align-items-center">
            <div class="media-body text-right d-none d-md-block mr-2">
                <h6 class="mb-0 f-w-600">{{ auth()->user()->name ?? 'User' }}</h6>
                <p class="mb-0 f-12">{{ auth()->user()->getRoleNames()->implode(', ') ?: 'Dealer user' }}</p>
            </div>
            <span class="media user-header">
                <em>{{ auth()->user()->initials ?? 'P' }}</em>
            </span>
        </div>
        <ul class="onhover-show-div profile-dropdown">
            <li class="gradient-primary">
                <h5 class="mb-0 f-w-600">{{ auth()->user()->name ?? 'User' }}</h5>
                <span>{{ auth()->user()->getRoleNames()->implode(', ') ?: 'Dealer user' }}</span>
            </li>
            <li>
                <a href="{{ route('tenant_profile_step_1') }}"><i data-feather="user"></i> {{ __('Profile') }}</a>
            </li>
            <li>
                <a href="{{ route('tenant_settings_hub') }}"><i data-feather="settings"></i> {{ __('Settings') }}</a>
            </li>
            <li>
                <a href="{{ route('tenant_notifications_index') }}"><i data-feather="bell"></i> {{ __('All notifications') }}</a>
            </li>
            <li>
                <form action="{{ route('tenant_logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-link text-danger p-0 border-0">
                        <i data-feather="log-out"></i> {{ __('Logout') }}
                    </button>
                </form>
            </li>
        </ul>
    </li>
</ul>
