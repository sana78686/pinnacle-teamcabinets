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

<button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#doorColorModal">
    Add Door Color
</button>
<a href="{{ route('tenant_door_style_create') }}" class="btn btn-sm btn-light ms-2">Open full form</a>

<!-- Modal -->
<div class="modal fade" id="doorColorModal" tabindex="-1" aria-labelledby="doorColorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="doorColorForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="doorColorModalLabel">Create door style</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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

                    @include('layouts.tenant.partials.image-upload-field', [
                        'name' => 'image',
                        'label' => 'Image',
                        'wrapperClass' => 'form-group',
                    ])

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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save</button>
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
                            <img src="{{ tenant_media_url($doorColor->image) }}" alt="Image" width="50">
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('doorColorForm');
    const modalEl = document.getElementById('doorColorModal');
    if (!form) {
        return;
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        const errorsBox = document.getElementById('formErrors');
        errorsBox.classList.add('d-none');
        errorsBox.innerHTML = '';

        fetch("{{ route('tenant_door_style_store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
        })
            .then(function (response) {
                if (response.ok) {
                    return response.json().catch(function () {
                        return { ok: true };
                    });
                }
                return response.json().then(function (data) {
                    throw { status: response.status, data: data };
                });
            })
            .then(function () {
                if (modalEl && window.bootstrap) {
                    const instance = bootstrap.Modal.getInstance(modalEl) || bootstrap.Modal.getOrCreateInstance(modalEl);
                    instance.hide();
                }
                form.reset();
                window.location.reload();
            })
            .catch(function (err) {
                if (err.status === 422 && err.data && err.data.errors) {
                    let html = '<ul class="mb-0">';
                    Object.keys(err.data.errors).forEach(function (key) {
                        html += '<li>' + err.data.errors[key][0] + '</li>';
                    });
                    html += '</ul>';
                    errorsBox.innerHTML = html;
                    errorsBox.classList.remove('d-none');
                } else {
                    alert('Could not save door style. Try the full Add door style page.');
                }
            });
    });
});
</script>
@endsection

