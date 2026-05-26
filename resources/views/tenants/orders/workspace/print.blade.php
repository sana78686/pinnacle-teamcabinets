@extends('layouts.tenant.standalone')

@section('title', 'Print Order #'.$order->id)

@section('css')
    <link rel="stylesheet" href="{{ tenant_static_asset('css/order-ci-detail.css') }}?v=2">
@endsection

@section('content')
    @include('tenants.orders.partials.ci-order-detail', array_merge($ciDetail, [
        'printMode' => true,
        'backUrl' => route('tenant_order_show', $order->id),
    ]))
@endsection

@section('script')
    <script>window.addEventListener('load', function () { window.print(); });</script>
@endsection
