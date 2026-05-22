@php
    $logoUrl = $tcSiteLogo ?? \App\Models\SiteSetting::first()?->logo;
    $tenantName = tenant('company_name') ?? tenant('name') ?? config('app.name');
@endphp
@if (!empty($logoUrl))
    <a href="{{ route('tenant_dashboard') }}" title="{{ $tenantName }}">
        <img src="{{ asset($logoUrl) }}" alt="{{ $tenantName }}">
    </a>
@endif
