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

<form method="POST" action="{{ route('tenant_frontend_theme_store') }}" class="tc-theme-picker">
    @csrf
    <div class="row">
        @foreach ($themes as $slug => $theme)
            @php
                $isActive = $activeTheme === $slug;
                $isDefault = $defaultTheme === $slug;
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
                        <span class="d-flex align-items-center justify-content-between flex-wrap gap-1">
                            <strong class="tc-theme-card__title">{{ $theme['label'] ?? $theme['name'] }}</strong>
                            @if ($isDefault)
                                <span class="badge badge-primary f-12">System default</span>
                            @endif
                            @if (!empty($theme['badge']) && $slug === 'hazel')
                                <span class="badge badge-success f-12">{{ $theme['badge'] }}</span>
                            @endif
                        </span>
                        <span class="tc-theme-card__desc">{{ $theme['description'] }}</span>
                        @if ($isActive)
                            <span class="tc-theme-card__status"><i data-feather="check-circle"></i> Active for {{ $company }}</span>
                        @endif
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
.tc-theme-picker .tc-theme-card {
    display: block;
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
.tc-theme-picker .tc-theme-card--active {
    border-color: #1a4a7a;
    box-shadow: 0 0 0 3px rgba(26, 74, 122, 0.12);
}
.tc-theme-picker .tc-theme-card__input {
    position: absolute;
    opacity: 0;
    pointer-events: none;
}
.tc-theme-picker .tc-theme-card__preview {
    display: block;
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
    display: block;
    padding: 1rem 1.1rem 1.15rem;
}
.tc-theme-picker .tc-theme-card__title {
    font-size: 1rem;
    color: #242934;
}
.tc-theme-picker .tc-theme-card__desc {
    display: block;
    font-size: 0.8125rem;
    color: #64748b;
    margin-top: 0.35rem;
    line-height: 1.45;
}
.tc-theme-picker .tc-theme-card__status {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    margin-top: 0.5rem;
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
