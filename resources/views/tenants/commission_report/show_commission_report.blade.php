@extends('layouts.tenant.master')
@section('title', 'Commission Report Menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
@endsection
@section('style')
@endsection
@section('breadcrumb-title')
    <h2>Product <span> Commission Report</span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Commission Report </li>
    <li class="breadcrumb-item active">View</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                <table class="table table-bordered ">
                    <thead class="table-secondary">
                        <th colspan="2">Commission Report Information</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Order By</th>
                            <td></td>
                        </tr>
                        <tr>
                            <th>Customer Name</th>
                            <td>

                            </td>
                        </tr>
                        <tr>
                            <th>Invoice Number</th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Job Name</th>
                            <td> </td>
                        </tr>

                        <tr>
                            <th>Door Style</th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>List Price (Multiplied with qty)</th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Customer's Point Factor</th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Customer's Cost</th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Affiliation</th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Affiliation Point Factor</th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Affiliation Cost</th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Affiliation Commission</th>
                            <td> </td>
                        </tr>
                        <!-- Add other fields as necessary -->
                    </tbody>
                </table>
            </div>
            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <table class="table table-bordered ">
                    <thead class="table-secondary">
                        <th colspan="2">Commission Report Information</th>
                    </thead>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ route('/') }}/assets/main/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/jszip.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/pdfmake.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/vfs_fonts.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.autoFill.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.select.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.bootstrap4.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.html5.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.print.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.bootstrap4.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.responsive.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/responsive.bootstrap4.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.keyTable.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.colReorder.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.fixedHeader.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.rowReorder.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.scroller.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/custom.js"></script>
@endsection
