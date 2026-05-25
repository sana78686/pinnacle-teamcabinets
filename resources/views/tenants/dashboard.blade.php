@extends('layouts.tenant.master')

@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ $panelAsset('assets/main/css/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ $panelAsset('assets/main/css/select2.css') }}">
@endsection

@section('breadcrumb-title')
<h2>Dashboard</h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Overview</li>
@endsection

@section('content')
@php
    $s = $stats ?? [];
    $widgets = [
        ['href' => route('tenant_user_index', ['verified' => 0]), 'value' => $s['unapproved_users'] ?? 0, 'label' => 'Un-approved users', 'hint' => 'Awaiting verification', 'icon' => 'user-x', 'accent' => 'amber'],
        ['href' => route('tenant_user_index', ['verified' => 1]), 'value' => $s['approved_users'] ?? 0, 'label' => 'Approved users', 'hint' => 'Active portal accounts', 'icon' => 'user-check', 'accent' => 'green'],
        ['href' => route('tenant_order_list'), 'value' => $s['total_orders'] ?? 0, 'label' => 'Total orders', 'hint' => 'All time', 'icon' => 'shopping-cart', 'accent' => 'blue'],
        ['href' => route('tenant_order_list'), 'value' => $s['pending_shipping_orders'] ?? 0, 'label' => 'Pending shipping', 'hint' => 'Need fulfillment', 'icon' => 'truck', 'accent' => 'orange'],
        ['href' => route('tenant_product_index'), 'value' => $s['total_products'] ?? 0, 'label' => 'Products', 'hint' => 'In catalog', 'icon' => 'package', 'accent' => 'purple'],
        ['href' => route('tenant_quotes_index'), 'value' => $s['total_quotes'] ?? 0, 'label' => 'Quotes', 'hint' => 'Customer requests', 'icon' => 'file-text', 'accent' => 'teal'],
        ['href' => route('tenant_user_index'), 'value' => $s['dealer_count'] ?? 0, 'label' => 'Dealers', 'hint' => 'B2B accounts', 'icon' => 'briefcase', 'accent' => 'navy'],
        ['href' => route('tenant_user_index'), 'value' => $s['representative_count'] ?? 0, 'label' => 'Representatives', 'hint' => 'Sales reps', 'icon' => 'users', 'accent' => 'slate'],
    ];
    $onboardingTotal = ! empty($onboardingSteps) ? count($onboardingSteps) : 0;
    $onboardingDone = ! empty($onboardingSteps)
        ? collect($onboardingSteps)->where('done', true)->count()
        : 0;
    $onboardingPct = $onboardingTotal > 0 ? (int) round(($onboardingDone / $onboardingTotal) * 100) : 0;
@endphp

<div class="container-fluid tc-dash-page">
    <p class="tc-dash-page__lead mb-3">Overview of users, orders, and catalog activity.</p>

    <div class="tc-dash-widgets mb-4">
        <div class="row g-3">
            @foreach ($widgets as $widget)
            <div class="col-6 col-md-4 col-xl-3">
                <a href="{{ $widget['href'] }}" class="tc-metric-card tc-metric-card--link">
                    <div class="tc-metric-card__icon tc-metric-card__icon--{{ $widget['accent'] }}">
                        <i data-feather="{{ $widget['icon'] }}" aria-hidden="true"></i>
                    </div>
                    <div class="tc-metric-card__body">
                        <span class="tc-metric-card__label">{{ $widget['label'] }}</span>
                        <div class="tc-metric-card__value">{{ number_format($widget['value']) }}</div>
                        @if (!empty($widget['hint']))
                            <span class="tc-metric-card__hint">{{ $widget['hint'] }}</span>
                        @endif
                    </div>
                </a>
            </div>
            @endforeach
                </div>
            </div>

    @include('tenants.dashboard.partials.order-tracker', [
        'trackerRows' => $trackerRows ?? collect(),
        'trackerStatuses' => $trackerStatuses ?? [],
        'fuelChargePercent' => $fuelChargePercent ?? 0,
    ])

    @include('tenants.dashboard.partials.catalog-sales')

    <div class="row g-3 align-items-start">
        <div class="col-12 col-lg-8 order-2 order-lg-1">
            <div class="card tc-dash-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <h5 class="mb-0 tc-dash-card__title">Recent orders</h5>
                    <a href="{{ route('tenant_order_list') }}" class="btn btn-sm tc-pn-btn tc-pn-btn--navy">View all orders</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive tc-admin-datatable">
                        <table id="tcRecentOrdersTable" class="table table-striped table-bordered table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Transaction ID</th>
                                    <th>Customer name</th>
                                    <th>Customer type</th>
                                    <th>Customer email</th>
                                    <th>Order weight</th>
                                    <th>Order amount</th>
                                    <th>Order status</th>
                                    <th>Order date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recentOrders) && $recentOrders->count() > 0)
                                    @foreach ($recentOrders as $order)
                                    <tr class="{{ tenant_admin_unviewed_row_class($order) }}">
                                        <td>
                                            <a href="{{ route('tenant_order_show', $order->id) }}" class="fw-semibold">#{{ $order->id }}</a>
                                        </td>
                                        <td>{{ $order->transaction_pro_id ?? '—' }}</td>
                                        <td>{{ $order->user?->name ?? '—' }}</td>
                                        <td>{{ $order->user?->getRoleNames()->first() ?? '—' }}</td>
                                        <td>{{ $order->user?->email ?? $order->user_email ?? '—' }}</td>
                                        <td>{{ $order->sub_total_weight ?? '0' }} lbs</td>
                                        <td>${{ number_format((float) ($order->grand_total_cost ?? $order->order_amount ?? 0), 2) }}</td>
                                        <td><span class="tc-dash-badge">{{ strtoupper($order->status ?? 'pending') }}</span></td>
                                        <td class="text-nowrap">{{ $order->created_at ? $order->created_at->format('M j, Y g:i A') : '—' }}</td>
                                        <td>
                                            <a href="{{ route('tenant_order_show', $order->id) }}" class="tc-admin-datatable__edit">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-5">
                                            <p class="mb-2">No orders yet.</p>
                                            <a href="{{ route('tenant_order_workspace') }}" class="btn btn-sm tc-pn-btn tc-pn-btn--navy">Create an order</a>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                    </div>

        <div class="col-12 col-lg-4 order-1 order-lg-2">
            @include('tenants.partials.onboarding-checklist', ['compact' => true, 'onboardingPct' => $onboardingPct])
            </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ $panelAsset('assets/main/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ $panelAsset('assets/main/js/select2/select2.full.min.js') }}"></script>
<script src="{{ $panelAsset('js/tenant-dashboard-tracker.js') }}?v=4"></script>
<script>
    window.TC_CATALOG_SALES_URL = @json(route('tenant_dashboard_catalog_sales'));
</script>
<script src="{{ $panelAsset('js/dashboard-catalog-sales.js') }}?v=1"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.feather) {
            window.feather.replace();
        }
    });
</script>
@endsection
