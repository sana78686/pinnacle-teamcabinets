@extends('layouts.tenant.master')

@section('title', 'Dashboard')

@section('breadcrumb-title')
<h2>Dashboard</h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Overview</li>
@endsection

@section('content')
@include('tenants.partials.onboarding-checklist')

@php
    $s = $stats ?? [];
    $widgets = [
        ['href' => route('tenant_user_index', ['verified' => 0]), 'value' => $s['unapproved_users'] ?? 0, 'label' => 'Un-approved users', 'icon' => 'user-x', 'gradient' => 'gradient-warning'],
        ['href' => route('tenant_user_index', ['verified' => 1]), 'value' => $s['approved_users'] ?? 0, 'label' => 'Approved users', 'icon' => 'user-check', 'gradient' => 'gradient-primary'],
        ['href' => route('tenant_order_list'), 'value' => $s['total_orders'] ?? 0, 'label' => 'Total orders', 'icon' => 'shopping-cart', 'gradient' => 'gradient-secondary'],
        ['href' => route('tenant_order_list'), 'value' => $s['pending_shipping_orders'] ?? 0, 'label' => 'Pending shipping', 'icon' => 'truck', 'gradient' => 'gradient-info'],
        ['href' => route('tenant_product_index'), 'value' => $s['total_products'] ?? 0, 'label' => 'Products', 'icon' => 'package', 'gradient' => 'gradient-primary'],
        ['href' => route('tenant_quotes_index'), 'value' => $s['total_quotes'] ?? 0, 'label' => 'Quotes', 'icon' => 'file-text', 'gradient' => 'gradient-secondary'],
        ['href' => route('tenant_user_index'), 'value' => $s['dealer_count'] ?? 0, 'label' => 'Dealers', 'icon' => 'briefcase', 'gradient' => 'gradient-info'],
        ['href' => route('tenant_user_index'), 'value' => $s['representative_count'] ?? 0, 'label' => 'Representatives', 'icon' => 'users', 'gradient' => 'gradient-warning'],
    ];
@endphp

<div class="container-fluid general-widget tc-dash-widgets mb-3">
    <div class="row g-3">
        @foreach ($widgets as $widget)
        <div class="col-sm-6 col-xl-3 col-lg-3">
            <a href="{{ $widget['href'] }}" class="tc-dash-stat-link">
                <div class="card {{ $widget['gradient'] }} o-hidden mb-0">
                    <div class="card-body b-r-4">
                        <div class="d-flex static-top-widget">
                            <div class="align-self-center text-center">
                                <i data-feather="{{ $widget['icon'] }}" aria-hidden="true"></i>
                            </div>
                            <div class="flex-grow-1">
                                <span class="m-0">{{ $widget['label'] }}</span>
                                <h4 class="mb-0 counter">{{ number_format($widget['value']) }}</h4>
                                <i class="icon-bg" data-feather="{{ $widget['icon'] }}" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>

<div class="container-fluid">
    <div class="card tc-dash-card">
        <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
            <h5 class="mb-0 tc-dash-card__title">Recent orders</h5>
            <a href="{{ route('tenant_order_list') }}" class="btn btn-sm tc-pn-btn tc-pn-btn--navy">View all orders</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive tc-admin-datatable">
                <table class="table table-hover mb-0">
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
                                    <a href="{{ route('tenant_order_show', $order->id) }}" class="tc-admin-datatable__edit">View</a>
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
