@extends('layouts.tenant.role.master')
@section('title', 'Order Menu')

@section('breadcrumb-title')
    <h2>Orders <span>List</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Orders</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    <div class="p-2 mt-0 card-header no-border">
        <a href="{{ route('tenant_order_workspace') }}" class="text-white btn btn-info btn-sm">
            <i class="icofont icofont-plus"></i> Create Order
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm"><i class="icofont icofont-refresh"></i> Refresh</a>
    </div>

    @include('tenants.partials.workspace-records-table', [
        'records' => $records,
        'rowLabel' => 'Order',
        'showRoute' => 'tenant_order_show',
        'destroyRoute' => 'tenant_order_destroy',
        'perPage' => $perPage ?? null,
        'search' => $search ?? '',
    ])
@endsection
