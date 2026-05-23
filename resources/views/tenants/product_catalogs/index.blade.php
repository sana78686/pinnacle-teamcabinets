@extends('layouts.tenant.products-list')
@section('title', 'Product Catalog Menu')

@section('products_title')
    Catalog list
@endsection

@php($vueConfig = \App\Support\ProductSetupVueConfig::get('catalogs'))

@section('products_content')
    @include('tenants.product_setup.vue-crud')
@endsection

@section('products_script')
    @include('tenants.product_setup.vue-crud-scripts', ['vueConfig' => $vueConfig])
@endsection
