@props(['title', 'wide' => false])

@php
    $tenantName = tenant('company_name') ?? tenant('name') ?? config('app.name');
@endphp

<div class="tc-auth-card {{ $wide ? 'tc-auth-card--wide' : '' }}">
    <div class="tc-auth-card__inner">
        <div class="tc-auth-brand">
            <img src="{{ tenant_static_asset('assets/logo/pinnacle-tenant.png') }}" alt="{{ $tenantName }}">
            <h2 class="tc-auth-brand__name">{{ $tenantName }}</h2>
        </div>
        <div class="tc-auth-form-wrap tc-form-page">
            <h1 class="tc-auth-title">{{ $title }}</h1>
            {{ $slot }}
        </div>
    </div>
</div>
