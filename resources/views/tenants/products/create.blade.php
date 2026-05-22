@extends('layouts.tenant.products-form')
@section('title', 'Product Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('products_title')
    Create product
@endsection

@section('products_content')
    @include('partial.flashMessage')
    <div class="m-2 card-body">
        <form method="POST" action="{{ route('tenant_product_store') }}" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Select Catalog<span class="asterisk text-danger"> *</span></label>
                        <select autofocus class="form-control catalog_id" name="catalog_id" id="catalog_id" required>
                            <option value="">--Select--</option>
                            @foreach ($product_catalogs as $catalog)
                                <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                            @endforeach
                        </select>
                        <span class="err" style="color: red;"></span>
                    </div>
                </div>
                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Select Cabinet Category<span class="asterisk text-danger"> *</span></label>
                        <select autofocus class="form-control section_id" name="section_id" id="section_id" required>
                            <option value="">--Select--</option>
                            @foreach ($product_sections as $section)
                                <option value="{{ $section->id }}">{{ $section->cabinets_name }}</option>
                            @endforeach
                        </select>
                        <span class="err" style="color: red;"></span>
                    </div>
                </div>
                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Select Door Style<span class="asterisk text-danger"> *</span></label>
                        <select autofocus class="form-control door_color_id" name="door_color_id" id="door_color_id" required>
                            <option value="">--Select--</option>
                            @foreach ($door_colors as $color)
                                <option value="{{ $color->id }}">{{ $color->product_label }}</option>
                            @endforeach
                        </select>
                        <span class="err" style="color: red;"></span>
                    </div>
                </div>
                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Product Label<span class="asterisk text-danger"> *</span></label>
                        <input name="label" type="text" class="form-control" required autofocus>
                    </div>
                </div>

                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>SKU<span class="asterisk text-danger"> *</span></label>
                        <input name="sku" type="text" class="form-control" required autofocus>
                    </div>
                </div>

                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Weight<span class="asterisk text-danger"> *</span></label>
                        <input name="weight" type="text" step="0.01" class="form-control" required autofocus>
                    </div>
                </div>

                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Cost<span class="asterisk text-danger"> *</span></label>
                        <input name="cost" type="number" step="0.01" class="form-control" required autofocus>
                    </div>
                </div>

                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Assemble Cost<span class="asterisk text-danger"> *</span></label>
                        <input name="assemble_cost" type="number" step="0.01" class="form-control" required autofocus>
                    </div>
                </div>
                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Quantity<span class="asterisk text-danger"> *</span></label>
                        <input name="qty" type="number" step="0.01" class="form-control" required autofocus>
                    </div>
                </div>
                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Details</label>
                        <textarea name="description" class="form-control"></textarea>
                    </div>
                </div>
                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Manufacture Date</label>
                        <input name="manufcature_date" type="date" class="form-control" autofocus>
                    </div>
                </div>

                <div class="p-2 col-lg-4">
                    <div class="form-group">
                        <label>Schematic Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*">
                    </div>
                </div>

                <div class="text-center col-12">
                    <button class="btn btn-success" style="margin: 15px;">Create & Create More Products</button>
                    <button type="submit" class="btn btn-success" style="margin: 15px;">Create Product</button>
                </div>
            </div>
        </form>
    </div>








@endsection

@section('products_script')

    <script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/select2/select2-custom.js"></script>
@endsection
