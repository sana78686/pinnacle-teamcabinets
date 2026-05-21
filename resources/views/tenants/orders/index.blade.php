@extends('layouts.tenant.master')
@section('title', 'Order Menu')

@section('css')


    {{-- <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css"> --}}
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Orders <span>List </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Orders</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')

    <div class="p-2 mt-0 card-header no-border">
        <a href="{{ route('tenant_order_workspace') }}" class="text-white btn btn-info btn-sm">
            <i class="icofont icofont-plus"></i> Create Order
        </a>
        <a href="{{ route('tenant_deleted_order_list') }}" class="btn btn-success btn-sm">Restore Orders</a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm"><i class="icofont icofont-refresh"></i> Refresh</a>
    </div>

    @include('tenants.partials.workspace-records-table', [
        'records' => $records,
        'rowLabel' => 'Order',
        'showRoute' => 'tenant_order_show',
        'destroyRoute' => 'tenant_order_destroy',
    ])

    {{-- <div class="p-2 mt-0 card-header no-border d-none">
        <a href="{{ route('tenant_user_create') }}" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new user in the system">
            <i class="icofont icofont-plus"></i> Create Order
        </a>

        <a href="{{ route('tenant_deleted_order_list') }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Restore a previously deleted user">
            <i class="icofont icofont-spinner-alt-3"></i> Restore Order
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
            <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
        </a>
        <div class=" pull-right">

            <a href="" class="btn btn-primary btn-sm" data-toggle="tooltip" title="Export user data to a file">
                <i class="text-white icofont icofont-upload-alt"></i> Export
            </a>

            <button class="btn btn-dark btn-sm" data-toggle="tooltip" title="Import user data from a file">
                <i class="text-white icofont icofont-download-alt"></i> Import
            </button>

        </div>
    </div> --}}

@endsection

@section('script')






    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>


    {{-- <script src="{{ route('/') }}/assets/main/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/jszip.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/pdfmake.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/vfs_fonts.js"></script> --}}


    <script>
        $(document).ready(function() {
            // Load Data
            function loadCatalogs() {
                $.ajax({
                    url: "{{ route('product_catalogs.index') }}",
                    method: "GET",
                    success: function(data) {
                        let rows = '';
                        data.product_catalogs.forEach((catalog, index) => {
                            rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${catalog.name}</td>
                                <td>${catalog.image ?? 'N/A'}</td>
                                <td>${catalog.pdf ?? 'N/A'}</td>
                                <td>
                                    <select class="form-select status-dropdown" data-id="${catalog.id}">
                                        <option value="1" ${catalog.status == 1 ? 'selected' : ''}>Visible</option>
                                        <option value="0" ${catalog.status == 0 ? 'selected' : ''}>Not-Visible</option>
                                    </select>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning editCatalog" data-id="${catalog.id}">Edit</button>
                                    <button class="btn btn-sm btn-danger deleteCatalog" data-id="${catalog.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                        });
                        $('#catalogTable tbody').html(rows);
                    }
                });
            }

            loadCatalogs();

            // Handle Create/Edit
            $('#createCatalog').click(function() {
                $('#catalogModalLabel').text('Create Catalog');
                $('#catalogForm')[0].reset();
                $('#catalogId').val('');
                $('#catalogModal').modal('show');
            });

            $('#catalogForm').submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                let id = $('#catalogId').val();
                let url = id ? `/product_catalogs/${id}` : "{{ route('product_catalogs.store') }}";
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    method: method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#catalogModal').modal('hide');
                        loadCatalogs();
                    }
                });
            });

            // Handle Delete
            $(document).on('click', '.deleteCatalog', function() {
                let id = $(this).data('id');
                if (confirm('Are you sure?')) {
                    $.ajax({
                        url: `/product_catalogs/${id}`,
                        method: 'DELETE',
                        success: function() {
                            loadCatalogs();
                        }
                    });
                }
            });

            // Handle Status Change
            $(document).on('change', '.status-dropdown', function() {
                let id = $(this).data('id');
                let status = $(this).val();

                $.ajax({
                    url: `/product_catalogs/${id}`,
                    method: 'PUT',
                    data: {
                        status
                    },
                    success: function() {
                        loadCatalogs();
                    }
                });
            });
        });
    </script>

@endsection
