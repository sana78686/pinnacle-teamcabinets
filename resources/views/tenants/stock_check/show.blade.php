@extends('layouts.tenant.master')
@section('title', 'Stock Check Request')

@section('content')
    @include('tenants.stock_check.partials.admin-show')
@endsection

@section('script')
    <script src="{{ tenant_static_asset('js/stock-check-admin.js') }}?v=3"></script>
@endsection
