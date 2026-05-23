@extends('layouts.tenant.products-list')
@section('title', 'Door styles')

@section('products_title')
    Door style list
@endsection

@php($vueConfig = \App\Support\ProductSetupVueConfig::get('door-styles'))

@section('products_content')
    <p class="text-muted f-12 mb-3">Step 3: Door styles are tied to a catalog (used on the order workspace).</p>
    @include('tenants.product_setup.vue-crud')
@endsection

@section('products_script')
    @include('tenants.product_setup.vue-crud-scripts', ['vueConfig' => $vueConfig])
@endsection
