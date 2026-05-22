@extends('layouts.tenant.products-list')
@section('title', 'Product Catalog Menu')
@section('css')

    {{-- <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css"> --}}
@endsection
@section('style')
<style>
    #name-suggestions {
        z-index: 1000;
        max-height: 200px;
        overflow-y: auto;
    }
    .list-group-item {
        cursor: pointer;
    }
</style>
@endsection
@section('products_title')
    Door style list
@endsection
@section('products_content')

 <!-- Button to open modal -->
<button class="btn btn-info btn-sm" data-toggle="modal" data-target="#doorColorModal">Add Door Color</button>

<!-- Modal -->
<div class="modal fade" id="doorColorModal" tabindex="-1" role="dialog" aria-labelledby="doorColorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="doorColorForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Door Color</h5>
                </div>
                <div class="modal-body">
                    <!-- Catalog Dropdown -->
                    <div class="form-group">
                        <label for="product_catalog_id">Product Catalog</label>
                        <select name="product_catalog_id" id="product_catalog_id" class="form-control" required>
                            <option value="">-- Select Catalog --</option>
                            @foreach($productCatalogs as $catalog)
                                <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Label -->
                    <div class="form-group">
                        <label for="product_label">Label</label>
                        <input type="text" name="product_label" id="product_label" class="form-control" required>
                    </div>

                    <!-- Image -->
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" name="image" id="image" class="form-control">
                    </div>

                    <!-- Status -->
                    <div class="form-group form-check">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" id="status" class="form-check-input" value="1" checked>
                        <label for="status" class="form-check-label">Active</label>
                    </div>

                    <!-- Error box -->
                    <div id="formErrors" class="alert alert-danger d-none"></div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="mt-4 table-responsive">
    <table class="table table-bordered table-striped table-hover table-sm">
        <thead>
            <tr>
                <th>#</th>
                <th>Catalog</th>
                <th>Label</th>
                <th>Image</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($doorColors as $index => $doorColor)
                <tr>
                    <td>{{ $doorColors->firstItem() + $loop->index }}</td>
                    <td>{{ $doorColor->productCatalog->name ?? 'N/A' }}</td>
                    <td>{{ $doorColor->product_label }}</td>
                    <td>
                        @if($doorColor->image)
                            <img src="{{ asset($doorColor->image) }}" alt="Image" width="50">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($doorColor->status)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        {{-- Add real links/routes if needed --}}
                        <a href="{{ route('tenant_door_style_edit', ['id' => $doorColor->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                        {{-- <a href="{{ route('tenant_door_style_destroy',  $doorColor->id) }}" class="btn btn-sm btn-danger">Delete</a> --}}
                        <form action="{{ route('tenant_door_style_destroy', $doorColor->id) }}" method="POST" style="display:inline;">
    @csrf
    <button type="submit" class="btn btn-danger btn-sm"
        onclick="return confirm('Are you sure you want to delete this item?')">
        Delete
    </button>
</form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No Door Colors Found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@include('partials.tenant-pagination', ['paginator' => $doorColors])

@endsection
@section('products_script')
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    {{-- <script src="{{ route('/') }}/assets/main/js/datatable/datatables/jquery.dataTables.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/jszip.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/pdfmake.min.js"></script>
<script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/vfs_fonts.js"></script> --}}
 <script>
    $('#doorColorForm').on('submit', function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    // Clear old errors
    $('#formErrors').addClass('d-none').html('');

    $.ajax({
        url: "{{ route('tenant_door_style_store') }}", // Make sure the route matches
        method: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            $('#doorColorModal').modal('hide');
            form.reset();

            // Optional: Show success alert or refresh the table
            alert('Door Color Created!');
            location.reload(); // or reload the list via AJAX
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorHtml = '<ul>';
                for (let key in errors) {
                    errorHtml += `<li>${errors[key][0]}</li>`;
                }
                errorHtml += '</ul>';
                $('#formErrors').removeClass('d-none').html(errorHtml);
            } else {
                alert('An unexpected error occurred.');
            }
        }
    });
});

    </script>
@endsection

