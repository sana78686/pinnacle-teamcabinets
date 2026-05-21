@extends('layouts.tenant.master')
@section('title', 'Bulletins Menu')
@section('css')
@endsection
@section('style')
@endsection
@section('breadcrumb-title')
    <h2>Bulletins <span>List </span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Bulletins</li>
    <li class="breadcrumb-item active">List</li>
@endsection
@section('content')
    <div class="p-2 mt-0 card-header no-border">
        {{-- <h5>Best Selling Product</h5> --}}
        <a href="javascript:void(0)" id="createCatalogLink" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new Bulletins in the system">
            <i class="icofont icofont-plus"></i> Create Bulletins
        </a>
        <div class="modal fade" id="catalogModal" tabindex="-1" role="dialog" aria-labelledby="catalogModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="catalogModalLabel">Create Bulletin</h5>
                    </div>
                    <div class="modal-body">
                        <!-- Create bulletin Form -->
                        <form action="{{ route('tenant_bulletin_store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                                    <div class="form-group">
                                        <label>Select  Option<span class="asterisk"> *</span></label>
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
                                        <input name="bulletin_title" id="bulletin_title" type="text"
                                            class="form-control">
                                        <span class="err" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Description *<span class="asterisk"> *</span></label>
                                        <input name="bulletin_description" id="Description *" type="text"
                                            class="form-control">
                                        <span class="err" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label>Select File<span class="asterisk"> *</span></label>
                                        <input name="image" id="bulletin_file" type="file" class="form-control"
                                            accept=".jpg,.jpeg,.pdf,.doc,.docx">
                                        <span class="err" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="text-center col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <input name="btn_submit" id="btnSubmit" type="submit" class="btn btn-info"
                                            value="create Bulletins" style="margin: 15px;">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('tenant_deleted_bulletin_list') }}" class="btn btn-success btn-sm" data-toggle="tooltip"
            title="Restore a previously deleted Bulletins">
            <i class="icofont icofont-spinner-alt-3"></i> Restore Bulletins
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
            <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
        </a>
        <div class=" pull-right">
            <!-- Import & Export Buttons -->
            <a href="{{ route('bulletin_export') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                title="Export Bulletins data to a file">
                <i class="text-white icofont icofont-upload-alt"></i> Export
            </a>
            <a href="#" class="btn btn-dark btn-sm " data-toggle="modal" data-target="#importModal"
                title="Import product data from a file">
                <i class="text-white icofont icofont-download-alt"></i> Import
            </a>
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Import Bulletin Data</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('bulletin_import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="bulletinFile">Select a file to import</label>
                                    <input type="file" class="form-control-file" id="userFile" name="bulletinFile"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pt-0 card-body">
        <div class="table-responsive table-sm">
            <table class="table display table-striped table-bordered table-sm " id="catalogTable">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>
                            User Option
                        </th>
                        <th> Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bulletin as $bulletin)
                        <tr>
                            <td>{{ $bulletin->id }}</td>
                            <td>{{ $bulletin->user_option }}</td>
                            <td>{{ $bulletin->bulletin_title }}</td>
                            <td>{{ $bulletin->bulletin_description }}</td>
                            <td>{{ $bulletin->image }}</td>
                            <td>
                                <a class="" href="{{ route('tenant_bulletin_show', $bulletin->id) }}"
                                    data-toggle="tooltip" title="View details of this Bulletin">
                                    Show |
                                </a>
                                <a class="" href="{{ route('tenant_bulletin_edit', $bulletin->id) }}"
                                    data-toggle="tooltip" title="Edit this Bulletin's information">
                                    Edit |
                                </a>
                                <a type="button"href="{{ route('tenant_bulletin_destroy', $bulletin->id) }}"
                                    class="" data-toggle="tooltip" title="Delete this Bulletin">
                                    Delete
                                </a>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>Id</th>
                        <th> User Option</th>
                        <th> Title</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @include('partials.tenant-pagination', ['paginator' => $bulletin])
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    {{-- <script src="{{ route('/') }}/assets/main/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/jszip.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/pdfmake.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/vfs_fonts.js"></script> --}}
<script>
    document.getElementById('createCatalogLink').addEventListener('click', function() {
        // Show the modal
        $('#catalogModal').modal('show');
    });
</script>
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
