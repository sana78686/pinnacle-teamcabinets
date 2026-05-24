@extends('layouts.tenant.role.master')
@section('title', 'My Uploads')

@section('breadcrumb-title')
    <h2>My <span>Uploads</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">My Uploads</li>
@endsection

@section('content')
    @include('tenants.product_setup.vue-crud')
@endsection

@section('script')
    @include('tenants.product_setup.vue-crud-scripts', ['vueConfig' => $vueConfig])
@endsection
