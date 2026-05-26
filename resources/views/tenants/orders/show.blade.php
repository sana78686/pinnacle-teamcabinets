@extends('layouts.tenant.master')
@section('title', 'View Order Details')

@section('css')
    <link rel="stylesheet" href="{{ $panelAsset('css/order-ci-detail.css') }}?v=2">
@endsection

@section('breadcrumb-title')
    <h2>Orders</h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_order_list') }}">Orders</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    @include('partial.message')

    @include('tenants.orders.partials.ci-order-detail', array_merge($ciDetail, [
        'printMode' => false,
        'backUrl' => route('tenant_order_list'),
    ]))

    @if ($canClaim ?? false)
        <div class="mt-3 px-2">
            <a href="{{ route('tenant_claim_create', ['order_id' => $record->id]) }}" class="btn btn-warning btn-sm">File claim</a>
        </div>
    @endif
@endsection
