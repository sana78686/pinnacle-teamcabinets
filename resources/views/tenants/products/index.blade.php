@extends('layouts.tenant.products-list')
@section('title', 'Product Menu')

@section('products_title')
    Product list
@endsection

@php($vueConfig = \App\Support\ProductSetupVueConfig::get('products'))

@section('products_content')
    @include('tenants.product_setup.vue-crud')
@endsection

@section('products_script')
    @include('tenants.product_setup.vue-crud-scripts', ['vueConfig' => $vueConfig])
@endsection
