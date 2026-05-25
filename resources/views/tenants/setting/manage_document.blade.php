@extends('layouts.tenant.settings')
@section('title', 'Create Document')

@section('breadcrumb-title')
    <h2>Create<span> Document</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Setting</li>
    <li class="breadcrumb-item active">Create Document</li>
@endsection

@section('setting_content')
    <p class="text-muted small mb-2">Use the list page to manage documents, or add one below.</p>
    <div class="mb-2">
        <a href="{{ route('tenant_setting_manage_documentation_list') }}" class="btn btn-light btn-sm">Back to list</a>
    </div>
    @include('tenants.product_setup.vue-crud')
@endsection

@section('setting_script')
    @include('tenants.product_setup.vue-crud-scripts', ['vueConfig' => $vueConfig])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(function () {
                var btn = document.querySelector('#product-setup-app button.btn-info');
                if (btn) btn.click();
            }, 400);
        });
    </script>
@endsection
