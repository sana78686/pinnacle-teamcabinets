@extends('layouts.tenant.role.master')
@section('title', 'Quotes Menu')

@section('breadcrumb-title')
    <h2>Quotes<span>List </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Quotes</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    @include('partial.message')
    @php($vueConfig = \App\Support\RepWorkspaceVueConfig::get('quotes'))
    @include('tenants.rep.vue-workspace-list')
@endsection

@section('script')
    @include('tenants.rep.vue-workspace-list-scripts', ['vueConfig' => $vueConfig])
@endsection
