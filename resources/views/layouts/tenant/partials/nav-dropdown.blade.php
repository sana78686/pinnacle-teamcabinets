{{-- Usage: @include('layouts.tenant.partials.nav-dropdown', ['title' => 'Claims', 'items' => [...]]) --}}
@php($tcNavBadges = $tcNavBadges ?? [])
<ul class="tc-nav-dropdown">
    <li class="tc-nav-dropdown__head">{{ $title }}</li>
    @foreach ($items as $item)
        @php
            $badgeKey = $item['badge_key'] ?? null;
            $badgeCount = $badgeKey ? (int) ($tcNavBadges[$badgeKey] ?? 0) : 0;
        @endphp
        <li class="tc-nav-dropdown__item">
            <a href="{{ $item['url'] }}">
                <i data-feather="{{ $item['icon'] ?? 'circle' }}" aria-hidden="true"></i>
                <span>{{ $item['label'] }}</span>
                @if ($badgeKey)
                    <span
                        class="tc-nav-list-badge{{ $badgeCount > 0 ? ' is-visible' : '' }}"
                        data-nav-badge="{{ $badgeKey }}"
                        @if ($badgeCount <= 0) hidden @endif
                    >{{ $badgeCount > 99 ? '99+' : ($badgeCount > 0 ? $badgeCount : '') }}</span>
                @endif
            </a>
        </li>
    @endforeach
</ul>
