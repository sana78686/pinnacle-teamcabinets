@php
    $tcNavBadges = $tcNavBadges ?? [];
    $isActive = request()->routeIs($item['route_patterns'] ?? []);
    $hasDropdown = ($item['type'] ?? '') === 'dropdown' && ! empty($item['dropdown']['items']);
    $navModule = $item['nav_module'] ?? null;
    $badgeParent = $navModule ? (int) ($tcNavBadges[$navModule] ?? 0) : 0;
@endphp
<li class="{{ $hasDropdown ? 'tc-nav-has-children' : '' }} {{ $isActive ? 'tc-nav-active' : '' }}" @if($navModule) data-nav-module="{{ $navModule }}" @endif>
    @if ($hasDropdown)
        <a href="#">
            <i data-feather="{{ $item['icon'] }}"></i><span>{{ $item['label'] }}</span>
            @if ($badgeParent > 0)
                <span class="tc-nav-module-dot is-visible" data-nav-badge="{{ $navModule }}" aria-hidden="true"></span>
            @else
                <span class="tc-nav-module-dot" data-nav-badge="{{ $navModule }}" hidden aria-hidden="true"></span>
            @endif
        </a>
        @include('layouts.tenant.partials.nav-dropdown', [
            'title' => $item['dropdown']['title'],
            'items' => $item['dropdown']['items'],
        ])
    @else
        <a href="{{ $item['url'] }}">
            @if ($navModule === 'support_chat' && $badgeParent > 0)
                <span class="tc-nav-module-dot is-visible" data-nav-badge="support_chat" aria-hidden="true"></span>
            @endif
            <i data-feather="{{ $item['icon'] }}"></i><span>{{ $item['label'] }}</span>
        </a>
    @endif
</li>
