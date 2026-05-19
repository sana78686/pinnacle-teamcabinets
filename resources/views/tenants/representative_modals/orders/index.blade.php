@extends('layouts.light.master')
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
        {{-- <h5>Best Selling Product</h5> --}}
        <a href="" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new order in the system">
            <i class="icofont icofont-plus"></i> Create Order
        </a>
        <a href="" class="btn btn-success btn-sm" data-toggle="tooltip" title="Restore a previously deleted order">
            <i class="icofont icofont-spinner-alt-3"></i> Restore Order
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
            <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
        </a>
        <div class=" pull-right">
            <!-- Import & Export Buttons -->
            <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Export order data to a file">
                <i class="text-white icofont icofont-upload-alt"></i> Export
            </button>

            <button class="btn btn-dark btn-sm" data-toggle="tooltip" title="Import order data from a file">
                <i class="text-white icofont icofont-download-alt"></i> Import
            </button>
        </div>
    </div>
    <table id="example1" class="table table-bordered dataTable" cellspacing="0" width="100%"
        aria-describedby="example1_info" style="width: 100%;">
        <thead>
            <tr role="row">
                <th class="sorting_desc" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-sort="descending" aria-label="Order ID: activate to sort column ascending"
                    style="width: 37.7778px;">Order ID</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Customer Name: activate to sort column ascending" style="width: 77.7778px;">
                    Customer Name</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Customer Type: activate to sort column ascending" style="width: 84.7778px;">
                    Customer Type</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Customer Email: activate to sort column ascending" style="width: 243.778px;">
                    Customer Email</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Job Name: activate to sort column ascending" style="width: 130.778px;">Job
                    Name</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Company Name: activate to sort column ascending" style="width: 96.7778px;">
                    Company Name</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Order Weight: activate to sort column ascending" style="width: 46.7778px;">
                    Order Weight</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Order Amount: activate to sort column ascending" style="width: 53.7778px;">
                    Order Amount</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Order Status: activate to sort column ascending" style="width: 126.778px;">
                    Order Status</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Transaction ID: activate to sort column ascending"
                    style="width: 78.7778px;">
                    Transaction ID</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Order Date: activate to sort column ascending" style="width: 37.7778px;">
                    Order Date</th>
                <th class="sorting" role="columnheader" tabindex="0" aria-controls="example1" rowspan="1"
                    colspan="1" aria-label="Action: activate to sort column ascending" style="width: 43.7778px;">
                    Action</th>
            </tr>
        </thead>

        <tbody role="alert" aria-live="polite" aria-relevant="all">
            <tr class="odd">
                <td class=" sorting_1">1518<br>Q #: 817</td>
                <td class="">TestUser Representative</td>
                <td class="">Representatives</td>
                <td class="">san.bism786illah@gmail.com</td>
                <td class="">testing-job</td>
                <td class="">N/A</td>
                <td class="">96 lbs</td>
                <td class="">$1,311.00</td>
                <!-- <td></td>
                <td></td>
                <td></td>
                <td></td> -->
                <td class="">
                    <select id="status" name="order_status" class="btn cls_grey">
                        <option value="PROCESSING_1518">PROCESSING</option>
                        <option value="PAID_1518">PAID</option>
                        <option value="PENDING_1518">PENDING</option>
                        <option value="CANCELLED_1518">CANCELLED</option>
                        <option value="COMPLETED_1518" selected="selected">COMPLETED</option>
                    </select>
                </td>
                <td class="">1593764208</td>
                <td class="">Jan, 19 2025</td>
                <td class="">
                    abc
                </td><!--order enhanced details 13-12-2022-->
            </tr>
        </tbody>
    </table>
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
