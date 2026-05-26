@extends('layouts.tenant.master')
@section('title', 'Stock Check Request')

@section('breadcrumb-title')
    <h2>Stock Check<span> Request</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_stock_check_index') }}">Stock Check</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    @include('tenants.stock_check.partials.admin-show')
@endsection

@section('script')
    @if ($isAdminView ?? false)
        <script src="{{ tenant_static_asset('js/stock-check-admin.js') }}?v=3"></script>
    @else
        <script src="{{ tenant_static_asset('js/stock-check-user.js') }}?v=2"></script>
    @endif
@endsection
