{{-- Usage: @include('layouts.tenant.partials.nav-dropdown', ['title' => 'Claims', 'items' => [...]]) --}}
@php
    $tcNavBadges = $tcNavBadges ?? [];
@endphp
<ul class="tc-nav-dropdown">
    <li class="tc-nav-dropdown__head">{{ $title }}</li>
    @foreach ($items as $item)
        @php
            $badgeKey = $item['badge_key'] ?? null;
            $badgeCount = $badgeKey ? (int) ($tcNavBadges[$badgeKey] ?? 0) : 0;
            $badgeLabel = $badgeCount > 99 ? '99+' : ($badgeCount > 0 ? (string) $badgeCount : '');
            $badgeClass = 'tc-nav-list-badge' . ($badgeCount > 0 ? ' is-visible' : '');
        @endphp
        <li class="tc-nav-dropdown__item">
            <a href="{{ $item['url'] }}">
                <i data-feather="{{ $item['icon'] ?? 'circle' }}" aria-hidden="true"></i>
                <span>{{ $item['label'] }}</span>
                @if ($badgeKey)
                    <span class="{{ $badgeClass }}" data-nav-badge="{{ $badgeKey }}">{{ $badgeLabel }}</span>
                @endif
            </a>
        </li>
    @endforeach
</ul>
