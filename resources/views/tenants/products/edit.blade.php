@extends('layouts.tenant.master')
@section('title', 'Product Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Update<span>Product </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Product</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="b-r-0 card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('tenant_product_update', $product->id) }}">
                            @csrf
                            <div class="row">
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <strong>product label:</strong>
                                        <input value="{{ $product->label }}" type="text" name="product_label"
                                            class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <strong>Sku:</strong>
                                        <input value="{{ $product->sku }}" type="text" name="sku"
                                            class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <strong>Description:</strong>
                                        <input value="{{ $product->description }}" type="text" name="description"
                                            class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <strong>Weight:</strong>
                                        <input value="{{ $product->weight }}" type="text" name="weight"
                                            class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <strong>Cost:</strong>
                                        <input value="{{ $product->cost }}" type="text" name="cost"
                                            class="form-control" required autofocus>
                                    </div>
                                </div>
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <strong>Image:</strong>
                                        <input type="file" class="form-control"value="{{ $product->image }}"
                                            name="image" required>
                                    </div>
                                </div>
                                {{-- <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <strong>Quantity:</strong>
                                    <input value="W9 D24 H34 1/2" type="text" name="name"  class="form-control"
                                        required autofocus>
                                </div>
                            </div> --}}
                                {{-- <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <strong>Details:</strong>
                                    <input value="test" type="text" name="name"  class="form-control"
                                        required autofocus>
                                </div>
                            </div> --}}
                                {{-- <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <strong>Menufacture date:</strong>
                                    <input value="test" type="text" name="name"
                                        class="form-control" required autofocus>
                                </div>
                            </div> --}}
                                <div class="text-center col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i
                                            class="fa-solid fa-floppy-disk"></i> Update Product</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
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
