@extends('layouts.tenant.master')
@section('title', 'Bulletins Menu')
@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css"> --}}
@endsection
@section('style')
@endsection
@section('breadcrumb-title')
    <h2>Create <span>Bulletins</span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Bulletins</li>
    <li class="breadcrumb-item active">List</li>
@endsection
@section('content')
    <form action="{{ route('tenant_bulletin_store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                <div class="form-group">
                    <label>Select User Send Option<span class="asterisk"> *</span></label>
                    <select name="user_option" id="select_user_send_option"
                        class="select_user_send_option form-control">
                        <option value="">Select</option>
                        <option value="every_one">Every One</option>
                        <option value="specific_user">Specific User</option>
                    </select>
                    <span class="err" style="color: red;"></span>
                </div>
            </div>
            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <div class="form-group">
                    <label>Title<span class="asterisk"> *</span></label>
                    <input name="bulletin_title" id="bulletin_title" type="text" class="form-control">
                    <span class="err" style="color: red;"></span>
                </div>
            </div>
            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <div class="form-group">
                    <label>Description *<span class="asterisk"> *</span></label>
                    <input name="bulletin_description" id="Description *" type="text" class="form-control">
                    <span class="err" style="color: red;"></span>
                </div>
            </div>
            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                @include('layouts.tenant.partials.image-upload-field', [
                    'name' => 'image',
                    'id' => 'bulletin_file',
                    'label' => 'Image or PDF',
                    'accept' => 'image/*,application/pdf',
                    'wrapperClass' => 'form-group',
                ])
            </div>
            <div class="text-center col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <input name="btn_submit" id="btnSubmit" type="submit" class="btn btn-info" value="create Bulletins"
                        style="margin: 15px;">
                </div>
            </div>
        </div>
    </form>
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
