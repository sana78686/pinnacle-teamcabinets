@extends('layouts.tenant.settings')
@section('title', 'Restore Documents')

@section('breadcrumb-title')
    <h2>Restore<span> Documents</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item active">Restore Documents</li>
@endsection

@section('setting_content')
    <div class="p-2 mt-0 card-header no-border">
        <a href="{{ route('tenant_setting_manage_documentation_list') }}" class="text-white btn btn-info btn-sm">
            <i class="icofont icofont-list"></i> Active documents
        </a>
    </div>
    @include('tenants.product_setup.vue-crud')
@endsection

@section('setting_script')
    @include('tenants.product_setup.vue-crud-scripts', ['vueConfig' => $vueConfig])
@endsection
