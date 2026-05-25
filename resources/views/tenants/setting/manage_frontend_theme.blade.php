@extends('layouts.tenant.settings')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_website_designing') }}">Website Designing</a></li>
    <li class="breadcrumb-item active">Storefront theme</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.website-designing-nav')

@php
    $company = tenant('company_name') ?? tenant('name') ?? config('app.name');
@endphp
<div class="mb-3">
    <h4 class="mb-1">Storefront theme</h4>
    <p class="text-muted mb-0 f-14">
        Choose how your public website looks to dealers and visitors. <strong>Hazel</strong> is the professional B2B layout; <strong>Modern</strong> matches a retail cabinets.com-style experience; <strong>Classic</strong> is your original storefront. Only one theme is active at a time.
        @if (!empty($tcFrontendUrl))
            <a href="{{ $tcFrontendUrl }}" target="_blank" rel="noopener">Preview site ↗</a>
        @endif
    </p>
</div>

<form method="POST" action="{{ route('tenant_frontend_theme_store') }}" class="tc-theme-picker" data-no-field-tips>
    @csrf
    <div class="row tc-theme-picker__row">
        @foreach ($themes as $slug => $theme)
            @php
                $isActive = $activeTheme === $slug;
                $isDefault = $defaultTheme === $slug;
                $tipText = $theme['tooltip'] ?? $theme['description'] ?? '';
            @endphp
            <div class="col-md-6 col-lg-4 mb-3">
                <label class="tc-theme-card {{ $isActive ? 'tc-theme-card--active' : '' }}">
                    <input type="radio" name="frontend_theme" value="{{ $slug }}"
                        class="tc-theme-card__input" {{ $isActive ? 'checked' : '' }}>
                    <span class="tc-theme-card__preview" style="--tc-theme-accent: {{ $theme['preview_color'] ?? '#1a4a7a' }};">
                        <span class="tc-theme-card__bar"></span>
                        <span class="tc-theme-card__hero"></span>
                        <span class="tc-theme-card__blocks">
                            <span></span><span></span><span></span>
                        </span>
                    </span>
                    <span class="tc-theme-card__body">
                        <span class="tc-theme-card__title-row">
                            <strong class="tc-theme-card__title">{{ $theme['label'] ?? $theme['name'] }}</strong>
                            @if ($tipText !== '')
                                <span class="tc-tip tc-tip--eye tc-theme-card__tip"
                                    data-tip="{{ $tipText }}"
                                    data-placement="top"
                                    tabindex="0"
                                    role="button"
                                    aria-label="{{ $tipText }}"
                                    onclick="event.preventDefault(); event.stopPropagation();"></span>
                            @endif
                        </span>
                        <span class="tc-theme-card__badges">
                            @if ($isDefault)
                                <span class="badge badge-primary f-12">System default</span>
                            @endif
                            @if (!empty($theme['badge']))
                                <span class="badge badge-success f-12">{{ $theme['badge'] }}</span>
                            @endif
                        </span>
                        <span class="tc-theme-card__desc">{{ $theme['description'] }}</span>
                        <span class="tc-theme-card__status-slot">
                            @if ($isActive)
                                <span class="tc-theme-card__status"><i data-feather="check-circle"></i> Active for {{ $company }}</span>
                            @endif
                        </span>
                    </span>
                </label>
            </div>
        @endforeach
    </div>
    <div class="mt-2">
        <button type="submit" class="btn btn-primary">Save theme</button>
    </div>
</form>
@endsection

@section('style')
<style>
.tc-theme-picker__row {
    align-items: stretch;
}
.tc-theme-picker__row > [class*="col-"] {
    display: flex;
}
.tc-theme-picker .tc-theme-card {
    display: flex;
    flex-direction: column;
    width: 100%;
    height: 100%;
    cursor: pointer;
    border: 2px solid #e8ebf2;
    border-radius: 12px;
    overflow: hidden;
    background: #fff;
    transition: border-color 0.15s, box-shadow 0.15s;
    margin: 0;
}
.tc-theme-picker .tc-theme-card:hover {
    border-color: #b8c5d6;
    box-shadow: 0 4px 14px rgba(26, 74, 122, 0.08);
}
/* Selected theme in the form (radio checked) — stays visible after click, not only on hover */
.tc-theme-picker .tc-theme-card--selected,
.tc-theme-picker .tc-theme-card:has(.tc-theme-card__input:checked) {
    border-color: #1a4a7a !important;
    box-shadow: 0 0 0 3px rgba(26, 74, 122, 0.18) !important;
    background: #f8fafc;
}
.tc-theme-picker .tc-theme-card--selected:hover,
.tc-theme-picker .tc-theme-card:has(.tc-theme-card__input:checked):hover {
    border-color: #1a4a7a !important;
    box-shadow: 0 0 0 3px rgba(26, 74, 122, 0.22) !important;
}
.tc-theme-picker .tc-theme-card--selected .tc-theme-card__title,
.tc-theme-picker .tc-theme-card:has(.tc-theme-card__input:checked) .tc-theme-card__title {
    color: #1a4a7a;
}
.tc-theme-picker .tc-theme-card__input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}
.tc-theme-picker .tc-theme-card__preview {
    display: block;
    flex: 0 0 auto;
    height: 120px;
    background: #f4f7fb;
    padding: 0.75rem;
}
.tc-theme-picker .tc-theme-card__bar {
    display: block;
    height: 10px;
    background: var(--tc-theme-accent);
    border-radius: 4px;
    margin-bottom: 0.5rem;
}
.tc-theme-picker .tc-theme-card__hero {
    display: block;
    height: 48px;
    background: linear-gradient(135deg, var(--tc-theme-accent), #0c2340);
    border-radius: 6px;
    margin-bottom: 0.5rem;
    opacity: 0.9;
}
.tc-theme-picker .tc-theme-card__blocks {
    display: flex;
    gap: 0.35rem;
}
.tc-theme-picker .tc-theme-card__blocks span {
    flex: 1;
    height: 28px;
    background: #fff;
    border-radius: 4px;
    border: 1px solid #e2e8f0;
}
.tc-theme-picker .tc-theme-card__body {
    flex: 1 1 auto;
    display: flex;
    flex-direction: column;
    min-height: 8.5rem;
    padding: 1rem 1.1rem 1.15rem;
}
.tc-theme-picker .tc-theme-card__title-row {
    display: flex;
    align-items: center;
    gap: 0.35rem;
    min-height: 1.35rem;
}
.tc-theme-picker .tc-theme-card__title {
    flex: 1 1 auto;
    min-width: 0;
    font-size: 1rem;
    color: #242934;
    line-height: 1.25;
}
.tc-theme-picker .tc-theme-card__tip.tc-tip--eye {
    width: auto;
    height: auto;
    margin-left: 0;
    border: none;
    border-radius: 0;
    background: transparent;
    color: #64748b;
    flex-shrink: 0;
}
.tc-theme-picker .tc-theme-card__tip.tc-tip--eye::before {
    content: "";
    display: block;
    width: 15px;
    height: 15px;
    background-color: currentColor;
    -webkit-mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'/%3E%3Ccircle cx='12' cy='12' r='3'/%3E%3C/svg%3E") center / contain no-repeat;
    mask: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='black' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z'/%3E%3Ccircle cx='12' cy='12' r='3'/%3E%3C/svg%3E") center / contain no-repeat;
}
.tc-theme-picker .tc-theme-card__tip.tc-tip--eye:hover {
    color: #1a4a7a;
}
.tc-theme-picker .tc-theme-card__badges {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.25rem;
    min-height: 1.4rem;
    margin-top: 0.35rem;
}
.tc-theme-picker .tc-theme-card__desc {
    display: block;
    flex: 1 1 auto;
    font-size: 0.8125rem;
    color: #64748b;
    margin-top: 0.35rem;
    line-height: 1.45;
}
.tc-theme-picker .tc-theme-card__status-slot {
    flex: 0 0 auto;
    min-height: 1.35rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
}
.tc-theme-picker .tc-theme-card__status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #1a4a7a;
}
.tc-theme-picker .tc-theme-card__status svg {
    width: 14px;
    height: 14px;
}
</style>
@endsection

@section('setting_script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof feather !== 'undefined') {
        feather.replace();
    }

    var picker = document.querySelector('.tc-theme-picker');
    if (!picker) {
        return;
    }

    function syncThemeSelection() {
        picker.querySelectorAll('.tc-theme-card').forEach(function (card) {
            var input = card.querySelector('.tc-theme-card__input');
            card.classList.toggle('tc-theme-card--selected', !!(input && input.checked));
        });
    }

    picker.addEventListener('change', syncThemeSelection);
    syncThemeSelection();
});
</script>
@endsection
