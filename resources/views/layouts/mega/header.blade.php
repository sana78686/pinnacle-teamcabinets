<div class="page-main-header pn-admin-header">
   <div class="main-header-right d-flex align-items-center flex-nowrap w-100">
      <div class="mobile-sidebar d-flex d-lg-none align-items-center flex-shrink-0">
         <button type="button" class="pn-admin-menu-btn" id="sidebar-toggle" aria-label="Open modules menu" aria-expanded="false" aria-controls="pn-admin-sidebar">
            <i data-feather="menu" aria-hidden="true"></i>
            <span class="pn-admin-menu-btn__label">Menu</span>
         </button>
      </div>
      <div class="main-header-left flex-grow-1 min-w-0">
         <div class="logo-wrapper">
            <a href="{{ route('dashboard') }}">
               @if (auth()->user()->logo)
                  <img src="{{ dynamic_url(auth()->user()->logo) }}" alt="{{ config('app.name') }}" class="pn-admin-logo">
               @else
                  <img src="{{ dynamic_url('assets/logo/pinnacle.png') }}" alt="Pinnacle" class="pn-admin-logo">
               @endif
            </a>
         </div>
      </div>
      <div class="nav-right flex-shrink-0">
         <ul class="nav-menus list-unstyled mb-0 d-flex align-items-center">
            <li class="onhover-dropdown">
               <button type="button" class="pn-admin-user-btn" aria-label="Account menu">
                  <span class="pn-admin-user-btn__initials">{{ auth()->user()->initials ?? 'P' }}</span>
               </button>
               <ul class="onhover-show-div profile-dropdown">
                  <li class="gradient-primary">
                     <h5 class="mb-0 f-w-600">{{ auth()->user()->name ?? 'Pinnacle User' }}</h5>
                     <span>{{ auth()->user()->getRoleNames()->implode(', ') }}</span>
                  </li>
                  <li><a href="{{ route('profile') }}"><i data-feather="user"></i> {{ __('Profile') }}</a></li>
               </ul>
            </li>
            <li>
               <a href="{{ route('auth_logout') }}" class="pn-admin-logout-btn" aria-label="Log out">
                  <i data-feather="log-out" aria-hidden="true"></i>
               </a>
            </li>
         </ul>
      </div>
   </div>
</div>
