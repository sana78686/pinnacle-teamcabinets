@extends('layouts.tenant.master')
@section('title', 'Manage Role Menu')
@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css"> --}}
@endsection
@section('style')
@endsection
@section('breadcrumb-title')
    <h2>Manage Role <span>List </span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Manage </li>
    <li class="breadcrumb-item">Role</li>
    <li class="breadcrumb-item active">List</li>
@endsection
@section('content')
    <div class="row">
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
            <div class="form-group">
                <label>Select Showroom</label>
                <select name="showroom_user_id" class="form-control">
                    <option value="">Select Showroom</option>
                </select>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label>Select Representative</label>
                <select name="representatives_name" class="form-control">
                    <option value="">Select Representative</option>
                    <option value="340">ARE</option>
                    <option value="439">Michael</option>
                    <option value="502">Woodhaven</option>
                    <option value="520">Claims</option>
                    <option value="522">Cindi2021</option>
                    <option value="523">1to1</option>
                    <option value="525">Bland</option>
                    <option value="580">Luke Yoder</option>
                    <option value="584">CF remodel</option>
                    <option value="623">DavisMarch1</option>
                    <option value="627">Sissiemae</option>
                    <option value="631">fredhicks2112@yahoo.com</option>
                    <option value="633">Ltilleman</option>
                    <option value="638">TEAM</option>
                    <option value="656">Mlobeck</option>
                    <option value="662">Decora</option>
                    <option value="669">Luispola1</option>
                    <option value="688">Davis_Rep</option>
                    <option value="699">weavergilbert</option>
                    <option value="719">jeet_121</option>
                    <option value="746">testuser-representative</option>
                </select>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label>Select Dealer</label>
                <select name="dealer_user_id" class="form-control">
                    <option value="">Select Dealer</option>
                    <option value="540">Thehomedesigncenter</option>
                    <option value="622">BOSTON DAVE</option>
                    <option value="629">CASH</option>
                    <option value="630">Meridian</option>
                    <option value="647">sclineconstruction@gmail.com</option>
                    <option value="651">allpro</option>
                    <option value="654">ISLAND HOME CONSTRUCTION</option>
                    <option value="678">Sochacreations</option>
                    <option value="691">STEEL</option>
                </select>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label>Select Representative</label>
                <select name="representatives_name_dealer" class="form-control">
                    <option value="">Select Representative</option>
                    <option value="340">ARE</option>
                    <option value="439">Michael</option>
                    <option value="502">Woodhaven</option>
                    <option value="520">Claims</option>
                    <option value="522">Cindi2021</option>
                    <option value="523">1to1</option>
                    <option value="525">Bland</option>
                    <option value="580">Luke Yoder</option>
                    <option value="584">CF remodel</option>
                    <option value="623">DavisMarch1</option>
                    <option value="627">Sissiemae</option>
                    <option value="631">fredhicks2112@yahoo.com</option>
                    <option value="633">Ltilleman</option>
                    <option value="638">TEAM</option>
                    <option value="656">Mlobeck</option>
                    <option value="662">Decora</option>
                    <option value="669">Luispola1</option>
                    <option value="688">Davis_Rep</option>
                    <option value="699">weavergilbert</option>
                    <option value="719">jeet_121</option>
                    <option value="746">testuser-representative</option>
                </select>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label>Select Distributor</label>
                <select name="distributor_user_id" class="form-control">
                    <option value="">Select Distributor</option>
                    <option value="698">HandyAndy</option>
                </select>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label>Select Repersentative</label>
                <select name="distributor_rep_name" class="form-control">
                    <option value="">Select Repersentative</option>
                    <option value="340">ARE</option>
                    <option value="439">Michael</option>
                    <option value="502">Woodhaven</option>
                    <option value="520">Claims</option>
                    <option value="522">Cindi2021</option>
                    <option value="523">1to1</option>
                    <option value="525">Bland</option>
                    <option value="580">Luke Yoder</option>
                    <option value="584">CF remodel</option>
                    <option value="623">DavisMarch1</option>
                    <option value="627">Sissiemae</option>
                    <option value="631">fredhicks2112@yahoo.com</option>
                    <option value="633">Ltilleman</option>
                    <option value="638">TEAM</option>
                    <option value="656">Mlobeck</option>
                    <option value="662">Decora</option>
                    <option value="669">Luispola1</option>
                    <option value="688">Davis_Rep</option>
                    <option value="699">weavergilbert</option>
                    <option value="719">jeet_121</option>
                    <option value="746">testuser-representative</option>
                </select>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label>Stock Check</label><br>
                <input name="is_stock_check" id="is_stock_check" type="checkbox" class="is_stock_check">
                <label>Is Stock Check?</label>
            </div>
        </div>
        <div class="text-center col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <input name="btn_submit" id="btnCabinet" type="submit" class="btn btn-info" value="create Catalog"
                    style="margin: 15px;">
            </div>
        </div>
    </div>
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
