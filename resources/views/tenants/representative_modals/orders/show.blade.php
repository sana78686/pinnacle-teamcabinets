@extends('layouts.tenant.master')
@section('title', 'Order Details')

@section('breadcrumb-title')
    <h2>Order<span> Details</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_order_list') }}">Orders</a></li>
    <li class="breadcrumb-item active">Details</li>
@endsection

@section('content')
@include('tenants.partials.workspace-record-detail', [
    'record' => $record,
    'recordLabel' => $recordLabel,
    'nameRowLabel' => $nameRowLabel,
    'recordName' => $recordName,
    'billName' => $billName,
    'shipName' => $shipName,
    'catalogLabel' => $catalogLabel,
    'doorLabel' => $doorLabel,
    'rooms' => $rooms,
    'listRoute' => $listRoute,
    'editRoute' => $editRoute ?? null,
])
@endsection
