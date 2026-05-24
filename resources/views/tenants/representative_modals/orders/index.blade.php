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
    @include('partial.message')
    @php($vueConfig = \App\Support\RepWorkspaceVueConfig::get('orders'))
    @include('tenants.rep.vue-workspace-list')
@endsection

@section('script')
    @include('tenants.rep.vue-workspace-list-scripts', ['vueConfig' => $vueConfig])
@endsection
