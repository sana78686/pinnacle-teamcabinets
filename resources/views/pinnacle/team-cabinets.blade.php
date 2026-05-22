@extends('pinnacle.layouts.app')

@section('title', 'Team Cabinets')

@section('content')
<section class="pn-page-hero">
    <div class="pn-container">
        <p class="pn-flagship__label" style="margin-bottom:0.5rem">Flagship tenant</p>
        <h1>{{ $pinnacle['flagship_tenant']['name'] }}</h1>
        <p>{{ $pinnacle['flagship_tenant']['description'] }}</p>
    </div>
</section>

<section class="pn-section">
    <div class="pn-container" style="max-width:48rem">
        <div class="pn-img-panel" style="margin-bottom:2rem">
            @include('pinnacle.partials.visual', [
                'variant' => 'showcase_catalog',
                'alt' => 'Cabinet catalog and ordering',
                'aspect' => '16/10',
            ])
        </div>
        <h2 class="pn-section__head" style="text-align:left;margin:0 0 1rem">What dealers and staff get</h2>
        <ul style="margin:0 0 2rem;padding-left:1.25rem;color:var(--pn-text);line-height:1.8">
            <li>Public website to browse catalogs, request quotes, and place orders</li>
            <li>Secure login for affiliates, dealers, and administrators</li>
            <li>Multi-step ordering with cart, rooms, and job names</li>
            <li>Quotes, shipping quotes, and stock-check requests</li>
            <li>Claims, bulletins, commissions, and document downloads</li>
            <li>QuickBooks-linked products and financial settings</li>
        </ul>
        <p style="color:var(--pn-text-muted);margin-bottom:2rem">
            Subscribe through Pinnacle to provision your own Team Cabinets tenant — branded website and management panel on your subdomain, with a {{ $pinnacle['trial_days'] }}-day trial to get started.
        </p>
        <div style="display:flex;flex-wrap:wrap;gap:1rem">
            <a href="{{ route('registeration') }}" class="pn-btn pn-btn--primary">Get started</a>
            <a href="{{ route('pinnacle.services') }}" class="pn-btn pn-btn--dark">All services</a>
        </div>
    </div>
</section>
@endsection
