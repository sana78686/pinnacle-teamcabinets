@extends('layouts.tenant.master')
@section('title', 'Product Catalog Menu')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
    {{-- <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css"> --}}
@endsection

@section('style')
    <style>
        #name-suggestions {
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
        }

        .list-group-item {
            cursor: pointer;
        }
    </style>

@endsection

@section('breadcrumb-title')
    <h2>Product Catalogs <span>List </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Product</li>
    <li class="breadcrumb-item">Catalogs</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')

    <div class="p-2 mt-0 card-header no-border">
        <a href="{{ route('tenant_product_catalog_create') }}" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new Product Catalog in the system">
            <i class="icofont icofont-plus"></i> Create Product Catalog
        </a>
{{--
        <a href="javascript:void(0)" id="createCatalogLink" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new Product Catalog in the system">
            <i class="icofont icofont-plus"></i> Create Product Catalog
        </a> --}}
        <!-- Modal -->
        <div class="modal fade" id="catalogModal" tabindex="-1" role="dialog" aria-labelledby="catalogModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="catalogModalLabel">Create Product Catalog</h5>
                    </div>
                    <div class="modal-body">
                         <!-- Create Catalog Form -->
                        <form action="{{ route('tenant_product_catalog_store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label" for="name">Product Catalog Name</label>
                                        <input name="name"  type="text" class="form-control" required>
                                        <span class="err" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label">Product Catalog Image</label>
                                        <input type="file" class="form-control" id="image" name="image"
                                            accept="image/jpg,image/jpeg,image/png" required>
                                        <span class="err" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="form-label">Product Catalog PDF</label>
                                        <input type="file" class="form-control" id="pdf" name="pdf"
                                            accept="application/pdf">
                                        <span class="err" style="color: red;"></span>
                                    </div>
                                </div>
                                <div class="text-center col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success" style="margin: 15px;">Create
                                            Catalog</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <a href="{{ route('tenant_deleted_product_catalog_list') }}"class="btn btn-success btn-sm" data-toggle="tooltip"
            title="Restore a previously deleted Product Catalog">
            <i class="icofont icofont-spinner-alt-3"></i> Restore Product Catalog
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
            <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
        </a>
        <div class="pull-right">
            <a href="{{ route('product_catalog_export') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                title="Export Product Catalog data to a file">
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
                            <h5 class="modal-title" id="importModalLabel">Import product Catalog Data</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('product_catalog_import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="userFile">Select a file to import</label>
                                    <input type="file" class="form-control-file" id="userFile"
                                        name="ProductcatalogFile" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Import</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" action="{{ route('tenant_product_catalog_index') }}">
        <div class="pt-0 card-body">
            <div class="table-responsive table-sm">
                <table class="table p-0 m-0 display table-striped table-bordered table-sm" id="">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">
                                Name
                                <input type="text" name="name" id="name" class="form-control form-control-sm"
                                    placeholder="Search Name" autocomplete="off" value="{{ request('name') }}">
                            </th>
                            <th scope="col">
                                Image
                                {{-- <input type="text" name="image" id="image" class="form-control form-control-sm"
                                    value="{{ request('image') }}" placeholder="Search Image"> --}}
                            </th>
                            <th scope="col">
                                PDF
                                {{-- <input type="text" name="pdf" id="pdf" class="form-control form-control-sm"
                                    value="{{ request('pdf') }}" placeholder="Search PDF"> --}}
                            </th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product_catalogs as $key => $catalog)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td>{{ $catalog->name ?? 'N/A' }}</td>
                                <td>{{ $catalog->image ?? 'N/A' }}</td>
                                <td>{{ $catalog->pdf ?? 'N/A' }}</td>
                                <td>
                                    <a class="" href="{{ route('tenant_product_catalog_show', $catalog->id) }}"
                                        data-toggle="tooltip" title="View details of this product catalog">
                                        Show |
                                    </a>

                                    <a class="" href="{{ route('tenant_product_catalog_edit', $catalog->id) }}"
                                        data-toggle="tooltip" title="Edit this product's catalog information">
                                        Edit |
                                    </a>
                                    <a href="{{ route('tenant_product_catalog_destroy', $catalog->id) }}" type="button"
                                        data-toggle="tooltip" title="Delete this product catalog"
                                        onclick="confirmation(event,this.href)">
                                        {{-- <i class="icofont icofont-ui-delete"></i> --}}
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @include('partials.tenant-pagination', ['paginator' => $product_catalogs])
    </form>
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
    <script>
        // Function to handle keyup event for any field (name, image, pdf)
        function handleKeyup(inputId, field) {
            document.getElementById(inputId).addEventListener('keyup', function() {
                const query = this.value.trim();

                if (query.length > 1) { // Start searching after 2 characters
                    fetch(`{{ route('tenant_product_catalog_search') }}?query=${query}&field=${field}`)
                        .then(response => response.json())
                        .then(data => {
                            // Clear the table content
                            const tableBody = document.querySelector('table tbody');
                            tableBody.innerHTML = '';

                            // Populate the table with filtered data
                            if (data.length) {
                                data.forEach(item => {
                                    const row = document.createElement('tr');
                                    row.innerHTML = `
                                    <td>${item.id}</td>
                                    <td>${item.name}</td>
                                    <td>${item.image}</td>
                                    <td>${item.pdf}</td>
                                    <td>
                                        <a href="/product-catalog/${item.id}/show">Show</a> |
                                        <a href="/product-catalog/${item.id}/edit">Edit</a> |
                                        <a href="javascript:void(0);" onclick="deleteCatalog(${item.id})">Delete</a>
                                    </td>
                                `;
                                    tableBody.appendChild(row);
                                });
                            } else {
                                tableBody.innerHTML = '<tr><td colspan="5">No results found</td></tr>';
                            }
                        })
                        .catch(error => console.error('Error fetching filtered data:', error));
                }
            });
        }

        // Call the handleKeyup function for all fields
        handleKeyup('name', 'name');
        handleKeyup('image', 'image');
        handleKeyup('pdf', 'pdf');
    </script>



@endsection
