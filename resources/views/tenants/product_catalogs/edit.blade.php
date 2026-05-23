@extends('layouts.tenant.products-form')
@section('title', 'Product Catalog Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('products_title')
    Edit catalog
@endsection


@section('products_content')
    @include('partial.message')
    <form action="{{ route('tenant_product_catalog_update', $product_catalog->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <div class="form-group">
                    <label class="form-label" for="catalogues_name_val">Product Catalog Name</label>
                    <input name="name" value="{{ $product_catalog->name }}" id="catalogues_name_val" type="text"
                        class="form-control" required>
                </div>
            </div>

            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                @include('layouts.tenant.partials.image-upload-field', [
                    'name' => 'image',
                    'label' => 'Product Catalog Image',
                    'accept' => 'image/jpg,image/jpeg,image/png',
                    'previewUrl' => $product_catalog->image_url,
                    'wrapperClass' => 'form-group',
                ])
            </div>

            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <div class="form-group tc-image-upload" data-tc-image-upload>
                    <label class="form-label" for="pdf">Product Catalog PDF</label>
                    <input type="hidden" name="remove_pdf" value="0" data-tc-image-remove-flag>
                    @if ($product_catalog->pdf_url)
                        <div class="tc-image-upload__preview mb-2" data-tc-image-preview>
                            <a href="{{ route('tenant_product_catalog_pdf', $product_catalog->id) }}" class="btn btn-sm btn-outline-primary">View PDF</a>
                            <button type="button" class="btn btn-outline-danger btn-sm tc-image-upload__remove ms-2" data-tc-image-remove>Remove PDF</button>
                        </div>
                    @endif
                    <input type="file" class="form-control" id="pdf" name="pdf" accept="application/pdf">
                </div>
            </div>

            <div class="text-center col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <input type="submit" class="btn btn-info" value="Update Catalog" style="margin: 15px;">
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
