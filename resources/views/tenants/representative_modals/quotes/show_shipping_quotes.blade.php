@extends('layouts.tenant.master')
@section('title', 'View Shipping Quote')

@section('breadcrumb-title')
    <h2>View Shipping Quote</h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_shipping_quotes_index') }}">Shipping Quotes</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    @include('tenants.quotes.partials.shipping-quote-admin-show', [
        'quoteView' => array_merge($userView, [
            'showAdminForm' => false,
            'canProceedToCheckout' => $canProceedToCheckout,
            'proceedCheckoutRoute' => $proceedCheckoutRoute,
        ]),
    ])
@endsection
