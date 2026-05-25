@extends('layouts.tenant.settings')
@section('title', 'Documentation Menu')

@section('breadcrumb-title')
    <h2>Documentation<span> Setting Details</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Setting</li>
    <li class="breadcrumb-item">Documentation</li>
@endsection

@section('setting_content')
    <div class="p-2 mt-0 card-header no-border d-flex flex-wrap gap-2">
        <a href="{{ route('tenant_setting_manage_document') }}" class="text-white btn btn-info btn-sm">
            <i class="icofont icofont-plus"></i> Create Document
        </a>
        <a href="{{ route('tenant_deleted_manage_document_list') }}" class="btn btn-success btn-sm">
            <i class="icofont icofont-spinner-alt-3"></i> Restore Document
        </a>
    </div>
    @include('tenants.product_setup.vue-crud')
@endsection

@section('setting_script')
    @include('tenants.product_setup.vue-crud-scripts', ['vueConfig' => $vueConfig])
@endsection
