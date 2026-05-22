@php
    $logoUrl = $logoUrl ?? \App\Models\SiteSetting::query()->value('logo');
    $tenantName = tenant('company_name') ?? tenant('name') ?? config('app.name');
    $homeUrl = $homeUrl ?? route('tenant_dashboard');
    $backUrl = $backUrl ?? route('tenant_order_workspace');
    $backLabel = $backLabel ?? 'Back To Cart';
    $backDisabled = $backDisabled ?? false;
@endphp

<header class="ow-workspace-top-bar" role="banner">
    <a href="{{ $homeUrl }}" class="ow-workspace-top-bar__logo" title="{{ $tenantName }} — Home">
        @if (! empty($logoUrl))
            <img src="{{ asset($logoUrl) }}" alt="{{ $tenantName }}">
        @else
            <span class="ow-workspace-top-bar__logo-text">{{ $tenantName }}</span>
        @endif
    </a>

    <div class="ow-workspace-top-bar__actions">
        @if ($backDisabled)
            <span class="ow-door-strip__back is-disabled" aria-disabled="true">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> {{ $backLabel }}
            </span>
        @else
            <a href="{{ $backUrl }}" class="ow-door-strip__back">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> {{ $backLabel }}
            </a>
        @endif
        <a href="{{ $homeUrl }}" class="ow-door-strip__back ow-workspace-top-bar__home" title="Home">
            <i class="fa fa-home" aria-hidden="true"></i> Home
        </a>
    </div>
</header>
