@php
    $taxSections = config('tenant_tax_fees_menu.sections', []);
@endphp
<nav class="tc-wd-subnav" aria-label="Tax and fees sections">
    @foreach ($taxSections as $section)
        @php
            $isActive = request()->routeIs($section['active'] ?? []);
            $icon = $section['icon'] ?? 'circle';
        @endphp
        <a href="{{ route($section['route']) }}"
            class="tc-wd-subnav__link {{ $isActive ? 'is-active' : '' }}">
            <i data-feather="{{ $icon }}" aria-hidden="true"></i>
            <span>{{ $section['label'] }}</span>
        </a>
    @endforeach
</nav>
