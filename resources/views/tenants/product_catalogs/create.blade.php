@extends('layouts.tenant.products-form')
@section('title', 'Product Catalog Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('products_title')
    Create catalog
@endsection


@section('products_content')

    @include('partial.message')

    <form action="{{ route('tenant_product_catalog_store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <div class="form-group">
                    <label class="form-label" for="name">Product Catalog Name</label>
                    <input name="name" id="name" type="text" class="form-control" required>
                    <span class="err" style="color: red;"></span>
                </div>
            </div>

            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                @include('layouts.tenant.partials.image-upload-field', [
                    'name' => 'image',
                    'label' => 'Product Catalog Image',
                    'wrapperClass' => 'form-group',
                ])
            </div>

            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                @include('layouts.tenant.partials.image-upload-field', [
                    'name' => 'pdf',
                    'label' => 'Product Catalog PDF',
                    'mediaType' => 'pdf',
                    'wrapperClass' => 'form-group',
                ])
            </div>

            <div class="text-center col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <button type="submit" class="btn btn-success" style="margin: 15px;">Create Catalog</button>

                </div>
            </div>
        </div>
    </form>


@endsection

@section('products_script')



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
