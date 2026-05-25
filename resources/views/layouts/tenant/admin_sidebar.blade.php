@php
    $tcNavBadges = $tcNavBadges ?? [];
    $tcAdminNavItems = $tcAdminNavItems ?? [];
@endphp
<div class="vertical-menu-main tc-tenant-nav">
    <nav id="main-nav" aria-label="Main navigation">
        <ul class="sm pixelstrap tc-nav-menu" id="main-menu">
            <li class="tc-nav-mobile-back">
                <div class="text-right mobile-back">Back<i class="pl-2 fa fa-angle-right" aria-hidden="true"></i></div>
            </li>
            @foreach ($tcAdminNavItems as $item)
                @include('layouts.tenant.partials.admin-nav-item', ['item' => $item])
            @endforeach
        </ul>
    </nav>
</div>
