@extends('layouts.tenant.products-list')
@section('title', 'Category / Cabinet Section')

@section('products_title')
    Category / Cabinet Section list
@endsection

@php($vueConfig = \App\Support\ProductSetupVueConfig::get('categories'))

@section('products_content')
    @include('tenants.product_setup.vue-crud')
@endsection

@section('products_script')
    @include('tenants.product_setup.vue-crud-scripts', ['vueConfig' => $vueConfig])
@endsection
