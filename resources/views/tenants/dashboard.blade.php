@extends('layouts.tenant.master')

@section('title', 'Dashboard')

@section('style')
<style>
.tc-dash-widget {
    display: block;
    border-radius: .25rem;
    box-shadow: 0 0 1px rgba(0,0,0,.125), 0 1px 3px rgba(0,0,0,.2);
    margin-bottom: 1.25rem;
    color: inherit;
    text-decoration: none;
    transition: transform .15s ease, box-shadow .15s ease;
}
.tc-dash-widget:hover {
    color: inherit;
    text-decoration: none;
    transform: translateY(-2px);
    box-shadow: 0 2px 8px rgba(0,0,0,.15);
}
.tc-dash-widget .inner {
    padding: 1rem 1.25rem;
    position: relative;
    z-index: 1;
}
.tc-dash-widget h3 {
    font-size: 1.75rem;
    font-weight: 700;
    margin: 0 0 .25rem;
}
.tc-dash-widget p {
    margin: 0;
    font-weight: 600;
}
.tc-dash-widget .icon {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    font-size: 2.75rem;
    opacity: .25;
    z-index: 0;
}
.tc-dash-widget.bg-warning { background: #f39c12; color: #fff; }
.tc-dash-widget.bg-danger { background: #dd4b39; color: #fff; }
.tc-dash-widget.bg-info { background: #00c0ef; color: #fff; }
.tc-dash-widget.bg-success { background: #00a65a; color: #fff; }
.tc-dash-widget.bg-primary { background: #3c8dbc; color: #fff; }
.tc-dash-widget.bg-secondary { background: #6c757d; color: #fff; }
</style>
@endsection

@section('breadcrumb-title')
<h2>Dashboard</h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Overview</li>
@endsection

@section('content')
@include('tenants.partials.onboarding-checklist')

@php($s = $stats ?? [])

<div class="container-fluid mb-3">
    <div class="row">
        <div class="col-sm-6 col-xl-3 col-lg-3">
            <a href="{{ route('tenant_user_index', ['verified' => 0]) }}" class="tc-dash-widget bg-warning">
                <div class="inner">
                    <h3>{{ number_format($s['unapproved_users'] ?? 0) }}</h3>
                    <p>Un-approved users</p>
                    <span class="icon"><i data-feather="user-x"></i></span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-3">
            <a href="{{ route('tenant_user_index', ['verified' => 1]) }}" class="tc-dash-widget bg-danger">
                <div class="inner">
                    <h3>{{ number_format($s['approved_users'] ?? 0) }}</h3>
                    <p>Approved users</p>
                    <span class="icon"><i data-feather="user-check"></i></span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-3">
            <a href="{{ route('tenant_order_list') }}" class="tc-dash-widget bg-info">
                <div class="inner">
                    <h3>{{ number_format($s['total_orders'] ?? 0) }}</h3>
                    <p>Total orders</p>
                    <span class="icon"><i data-feather="shopping-cart"></i></span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-3">
            <a href="{{ route('tenant_order_list') }}" class="tc-dash-widget bg-success">
                <div class="inner">
                    <h3>{{ number_format($s['pending_shipping_orders'] ?? 0) }}</h3>
                    <p>Pending shipping</p>
                    <span class="icon"><i data-feather="truck"></i></span>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xl-3 col-lg-3">
            <a href="{{ route('tenant_product_index') }}" class="tc-dash-widget bg-primary">
                <div class="inner">
                    <h3>{{ number_format($s['total_products'] ?? 0) }}</h3>
                    <p>Products</p>
                    <span class="icon"><i data-feather="package"></i></span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-3">
            <a href="{{ route('tenant_quotes_index') }}" class="tc-dash-widget bg-secondary">
                <div class="inner">
                    <h3>{{ number_format($s['total_quotes'] ?? 0) }}</h3>
                    <p>Quotes</p>
                    <span class="icon"><i data-feather="file-text"></i></span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-3">
            <a href="{{ route('tenant_user_index') }}" class="tc-dash-widget bg-info">
                <div class="inner">
                    <h3>{{ number_format($s['dealer_count'] ?? 0) }}</h3>
                    <p>Dealers</p>
                    <span class="icon"><i data-feather="briefcase"></i></span>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-xl-3 col-lg-3">
            <a href="{{ route('tenant_user_index') }}" class="tc-dash-widget bg-warning">
                <div class="inner">
                    <h3>{{ number_format($s['representative_count'] ?? 0) }}</h3>
                    <p>Representatives</p>
                    <span class="icon"><i data-feather="users"></i></span>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0">Recent orders</h5>
            <a href="{{ route('tenant_order_list') }}" class="btn btn-sm btn-primary">View all orders</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Job name</th>
                            <th>Customer name</th>
                            <th>Customer type</th>
                            <th>Customer email</th>
                            <th>Order weight</th>
                            <th>Order amount</th>
                            <th>Shipping</th>
                            <th>Order date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($recentOrders) && $recentOrders->count() > 0)
                            @foreach ($recentOrders as $order)
                            <tr class="{{ tenant_admin_unviewed_row_class($order) }}">
                                <td>
                                    <a href="{{ route('tenant_order_show', $order->id) }}">{{ $order->id }}</a>
                                </td>
                                <td>{{ $order->job_name }}</td>
                                <td>{{ $order->user?->name ?? '—' }}</td>
                                <td>{{ $order->user?->getRoleNames()->first() ?? '—' }}</td>
                                <td>{{ $order->user?->email ?? $order->user_email ?? '—' }}</td>
                                <td>{{ $order->sub_total_weight ?? '0' }} lbs</td>
                                <td>${{ number_format((float) ($order->grand_total_cost ?? 0), 2) }}</td>
                                <td>{{ ucfirst($order->shipping_status ?? 'pending') }}</td>
                                <td>{{ $order->created_at ? $order->created_at->format('M j, Y g:i A') : '—' }}</td>
                                <td>
                                    <a href="{{ route('tenant_order_show', $order->id) }}">View</a>
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="10" class="text-center text-muted py-4">
                                    No orders yet.
                                    <a href="{{ route('tenant_order_workspace') }}">Create an order</a>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.feather) {
            window.feather.replace();
        }
    });
</script>
@endsection
