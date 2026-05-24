@extends('layouts.tenant.role.master')
@section('title', 'Stock Check Menu')

@section('breadcrumb-title')
    <h2>Stock Check<span>List </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Stock Check</li>
    <li class="breadcrumb-item">List</li>
@endsection

@section('content')
    @include('partial.message')
    @php($vueConfig = \App\Support\RepWorkspaceVueConfig::get('stock-check'))
    @include('tenants.rep.vue-workspace-list')
@endsection

@section('script')
    @include('tenants.rep.vue-workspace-list-scripts', ['vueConfig' => $vueConfig])
@endsection
