@extends('layouts.tenant.master')
@section('title', 'Commission Report Menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
@endsection
@section('style')
@endsection
@section('breadcrumb-title')
    <h2>Create  <span>Commission Report </span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Commission Report </li>
    <li class="breadcrumb-item active">List</li>
@endsection
@section('content')
<form action="" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label" for="catalogues_name_val">Order By</label>
                <input name="catalogues_name_val" id="catalogues_name_val" type="text" class="form-control" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Customer Name</label>
                <input type="" class="form-control" id="catalogue_image" name="catalogue_image"
                    accept="image/jpg,image/jpeg,image/png" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Invoice number </label>
                <input type="" class="form-control" id="catalogue_image" name="catalogue_image"
                    accept="image/jpg,image/jpeg,image/png" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Job name</label>
                <input type="" class="form-control" id="catalogue_image" name="catalogue_image"
                     required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Invoice Date</label>
                <input type="" class="form-control" id="catalogue_image" name="catalogue_image"
                    accept="image/jpg,image/jpeg,image/png" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Door style</label>
                <input type="" class="form-control" id="catalogue_pdf" name="catalogue_pdf"
                    accept="application/pdf" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">List Price</label>
                <input type="" class="form-control" id="catalogue_pdf" name="catalogue_pdf"
                    accept="application/pdf" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Customer point factor</label>
                <input type="" class="form-control" id="catalogue_pdf" name="catalogue_pdf"
                    accept="application/pdf" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Customer cost</label>
                <input type="" class="form-control" id="catalogue_pdf" name="catalogue_pdf"
                    accept="application/pdf" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Affiliation</label>
                <input type="" class="form-control" id="catalogue_pdf" name="catalogue_pdf"
                    accept="application/pdf" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Affiliation point factor</label>
                <input type="" class="form-control" id="catalogue_pdf" name="catalogue_pdf"
                    accept="application/pdf" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Affiliation cost</label>
                <input type="" class="form-control" id="catalogue_pdf" name="catalogue_pdf"
                    accept="application/pdf" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Affiliation</label>
                <input type="" class="form-control" id="catalogue_pdf" name="catalogue_pdf"
                    accept="application/pdf" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <div class="form-group">
                <label class="form-label">Affiliation commission</label>
                <input type="" class="form-control" id="catalogue_pdf" name="catalogue_pdf"
                    accept="application/pdf" required>
                <span class="err" style="color: red;"></span>
            </div>
        </div>
        <div class="text-center col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <input name="btn_submit" id="btnCabinet" type="submit" class="btn btn-info" value="Create Commission Report"
                    style="margin: 15px;">
            </div>
        </div>
    </div>
</form>
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
