@extends('layouts.tenant.master')
@section('title', 'Product Catalog Menu')
@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
@endsection
@section('style')
@endsection
@section('breadcrumb-title')
    <h2>Create product  <span>Door Style </span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">products </li>
    <li class="breadcrumb-item"> Catalog</li>
    <li class="breadcrumb-item active">List</li>
@endsection
@section('content')
<form method="POST" action="{{ isset($doorColor) ? route('door-colors.update', $doorColor->id) : route('tenant_door_style_store') }}" enctype="multipart/form-data" class="mt-5">
    @csrf
    @if(isset($doorColor))
        <!-- @method('PUT') -->
    @endif

    <!-- Product Catalog Dropdown -->
    <div class="form-group">
        <label for="product_catalog_id">Product Catalog</label>
        <select name="product_catalog_id" id="product_catalog_id" class="form-control" required>
            <option value="">-- Select Catalog --</option>
            @foreach($productCatalogs as $catalog)
                <option value="{{ $catalog->id }}" {{ isset($doorColor) && $doorColor->product_catalog_id == $catalog->id ? 'selected' : '' }}>
                    {{ $catalog->name }}
                </option>
            @endforeach
        </select>


    <!-- Product Label -->

        <label for="product_label">Product Label</label>
        <input type="text" class="form-control" name="product_label" id="product_label"
            value="{{ old('product_label', $doorColor->product_label ?? '') }}" required>


    <!-- Image Upload -->

        <label for="image">Image</label>
        <input type="file" class="form-control" name="image" id="image">
        @if(isset($doorColor) && $doorColor->image)
            <p class="mt-2">Current: <img src="{{ asset('storage/' . $doorColor->image) }}" width="100" /></p>
        @endif
 </div>

    <!-- Status Checkbox -->
    <div class="form-group form-check">
    <input type="hidden" name="status" value="0"> <!-- default to false -->
<input type="checkbox" class="form-check-input" name="status" id="status" value="1"
    {{ old('status', $doorColor->status ?? true) ? 'checked' : '' }}>

        <label class="form-check-label" for="status">Active</label>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="btn btn-primary">
        {{ isset($doorColor) ? 'Update' : 'Create' }} Door Color
    </button>
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
