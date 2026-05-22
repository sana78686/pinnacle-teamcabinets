@php
    $sections = config('tenant_products_menu.form_sections', []);
    $activeSection = collect($sections)->first(fn ($s) => request()->routeIs($s['active'] ?? []));
@endphp
<aside class="tc-settings-sidebar tc-products-sidebar">
    <h3 class="tc-settings-sidebar-title">Product setup</h3>
    <p class="tc-products-sidebar-intro">Follow the steps in order for the easiest setup.</p>
    <nav class="tc-settings-nav" aria-label="Product setup steps">
        @foreach ($sections as $section)
            @php
                $isActive = request()->routeIs($section['active'] ?? []);
                $icon = $section['icon'] ?? 'circle';
            @endphp
            <a href="{{ route($section['create_route']) }}"
                class="tc-settings-nav-link {{ $isActive ? 'is-active' : '' }}">
                <span class="tc-settings-nav-link__main">
                    <span class="tc-products-sidebar-step" aria-hidden="true">{{ $section['step'] }}</span>
                    <i data-feather="{{ $icon }}" class="tc-settings-nav-icon" aria-hidden="true"></i>
                    <span class="tc-settings-nav-label">{{ $section['create_label'] }}</span>
                </span>
                <span class="tc-settings-nav-dot" aria-hidden="true"></span>
            </a>
            <a href="{{ route($section['list_route']) }}"
                class="tc-products-sidebar-list-link {{ request()->routeIs($section['list_route']) ? 'is-active' : '' }}">
                View {{ strtolower($section['label']) }} list
            </a>
        @endforeach
    </nav>
    @if ($activeSection && ! empty($activeSection['hint']))
        <p class="tc-products-sidebar-hint">{{ $activeSection['hint'] }}</p>
    @endif
</aside>
