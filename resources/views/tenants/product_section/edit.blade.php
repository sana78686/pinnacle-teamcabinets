@extends('layouts.tenant.products-form')
@section('title', 'Product Category Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"/> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
@endsection

@section('style')


@endsection

@section('products_title')
    Edit category
@endsection


@section('products_content')

<form action="{{ route('tenant_product_section_update',$product_section->id) }}">
    <div class="row">
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <strong>Product Category * &nbsp;<span class="txt-danger">*</span></strong>
                <input class="form-control"  id="" type="text" value="{{ $product_section->cabinets_name }}"  name="cabinets_name" required
                    autofocus>
            </div>
        </div>
        {{-- <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <div class="form-group">
                <strong>product Assemble Cost &nbsp;<span class="txt-danger">*</span></strong>
                <input type="text" name="assemble_price" value="{{ $product_section->assemble_price }}" class="form-control" required autofocus>
            </div>
        </div> --}}
        <div class="text-center col-xs-12 col-sm-12 col-md-12">
            <button type="submit" class="mt-2 mb-3 btn btn-primary btn-sm"><i class="fa-solid fa-floppy-disk"></i>
                Update Product Category</button>
        </div>
    </div>
</form>


@endsection

@section('products_script')

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
