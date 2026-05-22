@php
    $tabs = config('tenant_products_menu.list_tabs', []);
    $activeTab = collect($tabs)->first(fn ($t) => request()->routeIs($t['active'] ?? []));
@endphp
<nav class="tc-products-list-tabs tc-wd-subnav" aria-label="Product lists">
    @foreach ($tabs as $tab)
        @php
            $isActive = request()->routeIs($tab['active'] ?? []);
            $icon = $tab['icon'] ?? 'circle';
        @endphp
        <a href="{{ route($tab['route']) }}"
            class="tc-wd-subnav__link {{ $isActive ? 'is-active' : '' }}">
            @if (! empty($tab['step']))
                <span class="tc-products-tab__step" aria-hidden="true">{{ $tab['step'] }}</span>
            @endif
            <i data-feather="{{ $icon }}" aria-hidden="true"></i>
            <span>{{ $tab['label'] }}</span>
        </a>
    @endforeach
</nav>
@if ($activeTab)
    <p class="tc-products-list-hint text-muted mb-0 mt-2 f-14">
        <strong>Step {{ $activeTab['step'] }}:</strong>
        @if ($activeTab['step'] === 1)
            Create and manage catalogs first — everything else builds on a catalog.
        @elseif ($activeTab['step'] === 2)
            Categories organize products inside each catalog.
        @elseif ($activeTab['step'] === 3)
            Door styles are tied to a catalog (used on the order workspace).
        @else
            Add product SKUs after catalog, categories, and door styles are ready.
        @endif
    </p>
@endif
