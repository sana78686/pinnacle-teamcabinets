@extends('layouts.tenant.products-list')
@section('title', 'Product Category Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

@endsection

@section('style')


@endsection

@section('products_title')
    Category list
@endsection


@section('products_content')
    <div class="p-2 mt-0 card-header no-border">
        {{-- <h5>Best Selling Product</h5> --}}
        <a href="{{ route('tenant_product_section_create') }}" id="createCatalogLink" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new Product Section in the system">
            <i class="icofont icofont-plus"></i> Create Product Category
        </a>






        <div class="modal fade" id="catalogModal" tabindex="-1" role="dialog" aria-labelledby="catalogModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="catalogModalLabel">Create Product Catalog</h5>
                    </div>
                    <div class="modal-body">
                        <!-- Create product category Form -->
                        <form action="{{ route('tenant_product_section_store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <div class="form-group">
                                        <strong>Product Category * &nbsp;<span class="txt-danger">*</span></strong>
                                        <input class="form-control" name="cabinets_name" type="text"
                                            placeholder="Cabinet Sections / Category" required autofocus>
                                    </div>
                                </div>
                                <div class="text-center col-xs-12 col-sm-12 col-md-12">
                                    <button type="submit" class="mt-2 mb-3 btn btn-success btn-sm"><i
                                            class="fa-solid fa-floppy-disk"></i>
                                        Create Category</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ route('tenant_deleted_product_section_list') }}" class="btn btn-success btn-sm" data-toggle="tooltip"
            title="Restore a previously deleted  Product Section">
            <i class="icofont icofont-spinner-alt-3"></i> Restore Product Category
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
            <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
        </a>
        <div class=" pull-right">
            <!-- Import & Export Buttons -->
            <a href="{{ route('product_section.export') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                title="Export product section data to a file">
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
                            <h5 class="modal-title" id="importModalLabel">Import Product Category Data</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('product_section_import') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="userFile">Select a file to import</label>
                                    <input type="file" class="form-control-file" id="userFile" name="productsectionFile"
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
            <table class="table p-0 m-0 display table-striped table-bordered table-sm" id="">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Category</th>
                        {{-- <th scope="col">product Assemble Coste</th> --}}
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($product_section as $product_section)
                        <tr>
                            <td>{{ $product_section->id }}</td>
                            <td>{{ $product_section->cabinets_name }}</td>
                            {{-- <td>{{ $product_section->assemble_price }}</td> --}}
                            {{-- <td>{{ $product_section->assemble_price }}</td> --}}
                            <td>
                                <a class="" href="{{ route('tenant_product_section_show', $product_section->id) }}"
                                    data-toggle="tooltip" title="View details of this user">
                                    Show |
                                </a>
                                <a class="" href="{{ route('tenant_product_section_edit', $product_section->id) }}"
                                    data-toggle="tooltip" title="Edit this user's information">
                                    Edit |
                                </a>
                                <a href="{{ route('tenant_products_section_destroy', $product_section->id) }}"
                                    type="button" data-toggle="tooltip" title="Delete this user"
                                    onclick="confirmation(event,this.href)">
                                    {{-- <i class="icofont icofont-ui-delete"></i> --}}
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Category</th>
                        <th scope="col">Action</th>

                    </tr>
                </tfoot>
            </table>
        </div>
        @include('partials.tenant-pagination', ['paginator' => $product_section])
    </div>


@endsection





@section('products_script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.getElementById('createCatalogLink').addEventListener('click', function() {
            // Show the modal
            $('#catalogModal').modal('show');
        });
    </script>

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    {{-- <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {
            var role_path = "{{ route('tenant_role_autocomplete') }}";
            var country_path = "{{ route('tenant_country_autocomplete') }}";
            var state_path = "{{ route('tenant_state_autocomplete') }}";
            var city_path = "{{ route('tenant_city_autocomplete') }}";
            var county_path = "{{ route('tenant_county_autocomplete') }}";
            $('#search_role').select2({
                placeholder: 'Select User Type',
                allowClear: true,
                ajax: {
                    url: role_path,
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term // Send the search term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#search_country').select2({
                placeholder: '--- Select Country ---',
                allowClear: true,
                ajax: {
                    url: country_path,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });

            $('#search_state').select2({
                placeholder: '--- Select State ---',
                allowClear: true,
                ajax: {
                    url: state_path,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $('#search_city').select2({
                placeholder: '--- Select City ---',
                allowClear: true,
                ajax: {
                    url: city_path,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
            $('#search_county').select2({
                placeholder: '--- Select County ---',
                allowClear: true,
                ajax: {
                    url: county_path,
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                }
            });
        });
    </script>
@endsection
