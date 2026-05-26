@extends('layouts.tenant.master')
@section('title', 'Bulletins')

@section('breadcrumb-title')
    <h2>Bulletins <span>List</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Bulletins</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="tc-bulletin-admin">
        <div class="d-flex flex-wrap gap-2 align-items-center mb-3">
            <a href="{{ route('tenant_deleted_bulletin_list') }}" class="btn btn-outline-success btn-sm">Restore</a>
            <div class="ms-auto d-flex flex-wrap gap-2">
                <a href="{{ route('bulletin_export') }}" class="btn btn-outline-primary btn-sm">Export</a>
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#bulletinImportModal">Import</button>
            </div>
        </div>

        @include('tenants.product_setup.vue-crud')
    </div>

    <div class="modal fade" id="bulletinImportModal" tabindex="-1" aria-labelledby="bulletinImportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bulletinImportModalLabel">Import bulletins</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('bulletin_import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label class="form-label" for="bulletinFile">Excel / CSV file</label>
                        <input type="file" class="form-control" id="bulletinFile" name="bulletinFile" accept=".xlsx,.xls,.csv" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @include('tenants.product_setup.vue-crud-scripts', ['vueConfig' => $vueConfig])
@endsection
