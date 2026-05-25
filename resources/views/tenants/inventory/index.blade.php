@extends('layouts.tenant.settings')
@section('title', 'Inventory Admin')

@section('breadcrumb-title')
    <h2>Manage <span>Inventory</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item active">Inventory</li>
@endsection

@section('setting_content')
    @include('tenants.product_setup.vue-crud')
@endsection

@section('setting_script')
    @include('tenants.product_setup.vue-crud-scripts', ['vueConfig' => $vueConfig])
@endsection
