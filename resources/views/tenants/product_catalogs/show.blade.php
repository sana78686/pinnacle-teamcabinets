@extends('layouts.tenant.products-form')
@section('title', 'Product Catalog Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('products_title')
    Catalog details
@endsection


@section('products_content')


    <div class="container-fluid">
        <div class="row">

            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4 ">
                <table class="table table-bordered ">
                    <thead class="table-secondary">
                        <th colspan="2">Product Catalog Information</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $product_catalog->id }}</td>
                        </tr>
                        <tr>
                            <th>Product Catalog name</th>
                            <td>
                                {{ $product_catalog->name}}
                            </td>
                        </tr>
                        <tr>
                            <th>Product Catalog PDF</th>
                            <td>
                                @if ($product_catalog->pdf_url)
                                    <a href="{{ route('tenant_product_catalog_pdf', $product_catalog->id) }}" class="btn btn-sm btn-outline-primary" target="_blank" rel="noopener">
                                        <i class="fa-solid fa-file-pdf"></i> View PDF
                                    </a>
                                @else
                                    <span class="text-muted">No PDF uploaded</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Image</th>
                            <td>
                                @if ($product_catalog->image_url)
                                    <img src="{{ $product_catalog->image_url }}" alt="{{ $product_catalog->name }}" style="max-width:200px;border-radius:6px;">
                                @else
                                    <span class="text-muted">No image uploaded</span>
                                @endif
                            </td>
                        </tr>
                        <!-- Add other fields as necessary -->
                    </tbody>
                </table>
            </div>
            {{-- <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <table class="table table-bordered ">
                    <thead class="table-secondary">
                        <th colspan="2">Other Information</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Country</th>
                            <td>N/A</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>N/A</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>N/A</td>
                        </tr>
                        <tr>
                            <th>County</th>
                            <td>N/A</td>
                        </tr>

                        <!-- Add other fields as necessary -->
                    </tbody>
                </table>
            </div> --}}
            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                <table class="table table-bordered ">
                    <thead class="table-secondary">
                        <th colspan="2">Product Catalog Information</th>
                    </thead>
            </div>
        </div>
    </div>
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
