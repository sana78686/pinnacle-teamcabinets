@extends('layouts.tenant.master')

@section('title', 'Checkout')

@section('content')
<div class="container-fluid">
    <div class="tc-card p-4">
        <h1>Checkout</h1>
        <p class="text-muted">Review your cart and complete payment (CI <code>cart_checkout_product</code> flow).</p>
        @if (! empty($payload['job_name']))
            <p><strong>Job:</strong> {{ $payload['job_name'] }}</p>
            <p><strong>Total:</strong> ${{ number_format($payload['totals']['grand_total_cost'] ?? 0, 2) }}</p>
            <p><strong>Weight:</strong> {{ $payload['totals']['sub_total_weight'] ?? 0 }} lbs</p>
        @else
            <p class="text-danger">No checkout data in session. <a href="{{ route('tenant_order_workspace') }}">Start a new order</a>.</p>
        @endif
        <a href="{{ route('tenant_order_workspace') }}" class="btn btn-primary mt-3">Back to catalogs</a>
    </div>
</div>
@endsection
