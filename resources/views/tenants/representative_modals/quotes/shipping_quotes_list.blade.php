@extends('layouts.tenant.role.master')
@section('title', 'Shipping Quotes')

@section('breadcrumb-title')
    <h2>Shipping Quotes <span>List</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Shipping Quotes</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    @include('partial.message')
    @php($vueConfig = \App\Support\RepWorkspaceVueConfig::get('shipping-quotes'))
    @include('tenants.rep.vue-workspace-list')
@endsection

@section('script')
    @include('tenants.rep.vue-workspace-list-scripts', ['vueConfig' => $vueConfig])
@endsection
