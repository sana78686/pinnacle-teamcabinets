{{-- Theme header (Poco / assets/main) — included from layouts.light.master --}}
<div class="page-main-header">
    <div class="main-header-right">
        <div class="main-header-left">
            <div class="logo-wrapper">
                @include('layouts.tenant.partials.tenant-logo')
            </div>
            <div class="tc-page-header__titles">
                @yield('breadcrumb-title')
                @hasSection('breadcrumb-subtitle')
                    <p class="tc-page-header__subtitle mb-0">@yield('breadcrumb-subtitle')</p>
                @endif
            </div>
        </div>
        <div class="mobile-sidebar d-none">
            <div class="text-right media-body switch-sm">
                <label class="ml-3 switch"><i class="font-primary" id="sidebar-toggle" data-feather="align-center"></i></label>
            </div>
        </div>
        <div class="vertical-mobile-sidebar"><i class="fa fa-bars sidebar-bar"></i></div>
        @auth
            <div class="nav-right col pull-right right-menu">
                @include('layouts.tenant.partials.header-actions')
            </div>
        @endauth
        <div class="d-lg-none mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
    </div>
</div>
