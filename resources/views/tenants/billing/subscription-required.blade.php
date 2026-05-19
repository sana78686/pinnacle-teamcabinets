@extends('layouts.tenant.master')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center py-5">
        <div class="col-md-8">
            @if(session('error'))
                <div class="alert alert-warning">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Subscription required</h4>
                </div>
                <div class="card-body">
                    <p>Your trial or subscription is not active. Subscribe to restore full access.</p>
                    <p class="text-muted small mb-4">Paid tenants show as <strong>green</strong> in the super admin tenants list.</p>
                    <a href="{{ route('tenant.billing.checkout') }}" class="btn btn-primary">Pay with Stripe</a>
                    <a href="{{ route('tenant_login') }}" class="btn btn-outline-secondary ml-2">Sign out</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
