@extends('layouts.tenant.settings')
@section('title', 'Tax & Fees')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Tax &amp; Fees</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.tax-fees-nav')

<div class="tc-wd-overview">
    <p class="text-muted mb-3 f-14">
        Configure checkout payment fees, shipping quote charges, Florida county sales tax rates, and Paytrace credentials.
        Taxable users are set per account under <a href="{{ route('tenant_user_index') }}">Users</a>.
    </p>

    <div class="row">
        <div class="col-md-4 mb-3">
            <a href="{{ route('tenant_setting_tax_fees_payment') }}" class="tc-wd-card">
                <span class="tc-wd-card__icon"><i data-feather="credit-card"></i></span>
                <strong>Payment &amp; fuel</strong>
                <span class="tc-wd-card__desc">Fuel surcharge, card/ACH fees, and fallback sales tax %.</span>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('tenant_setting_tax_fees_shipping') }}" class="tc-wd-card">
                <span class="tc-wd-card__icon"><i data-feather="truck"></i></span>
                <strong>Shipping charges</strong>
                <span class="tc-wd-card__desc">Commercial delivery, liftgate, unload, and pallet costs for quotes.</span>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('tenant_setting_tax_fees_sales_tax') }}" class="tc-wd-card">
                <span class="tc-wd-card__icon"><i data-feather="map-pin"></i></span>
                <strong>Sales tax counties</strong>
                <span class="tc-wd-card__meta">{{ $countyCount }} Florida {{ $countyCount === 1 ? 'county' : 'counties' }}</span>
                <span class="tc-wd-card__desc">County tax rates applied at checkout by ship-to county name.</span>
            </a>
        </div>
        <div class="col-md-4 mb-3">
            <a href="{{ route('tenant_setting_tax_fees_paytrace') }}" class="tc-wd-card">
                <span class="tc-wd-card__icon"><i data-feather="lock"></i></span>
                <strong>Paytrace</strong>
                <span class="tc-wd-card__desc">API username and password for card processing at checkout.</span>
            </a>
        </div>
    </div>
</div>
@endsection
