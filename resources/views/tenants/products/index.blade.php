@extends('layouts.tenant.products-list')
@section('title', 'Product Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('products_title')
    Product list
@endsection


@section('products_content')
    <div class="p-2 mt-0 card-header no-border">
        {{-- <h5>Best Selling Product</h5> --}}
        <a href="{{ route('tenant_product_create') }}" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new Product in the system">
            <i class="icofont icofont-plus"></i> Create Product
        </a>
        <a href="javascript:;" class="btn btn-success btn-sm" data-toggle="tooltip"
            title="Restore a previously deleted Product">
            <i class="icofont icofont-spinner-alt-3"></i> Restore Product
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
            <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
        </a>
        <div class=" pull-right">

            <a href="javascript:;" class="btn btn-primary btn-sm" data-toggle="tooltip"
                title="Export product data to a file">
                <i class="text-white icofont icofont-upload-alt"></i> Export
            </a>

            <a href="javascript:;" class="btn btn-dark btn-sm " data-toggle="modal" data-target="#importModal"
                title="Import product data from a file">
                <i class="text-white icofont icofont-download-alt"></i> Import
            </a>

            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Import product Data</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="userFile">Select a file to import</label>
                                    <input type="file" class="form-control-file" id="userFile" name="productFile"
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
    <form method="GET" action="{{ route('tenant_product_search') }}">
        <div class="pt-0 card-body">
            <div class="table-responsive table-sm">
                <table class="table p-0 m-0 display table-striped table-bordered table-sm" id="">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Label</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Weight</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Detail</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product as $product)
                            <tr>
                                <th scope="row">{{ $product->id }}</th>
                                <td>{{ $product->label }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->weight }}</td>
                                <td>{{ $product->cost }}</td>
                                <td>{{ $product->description }}</td>
                                <td>{{ $product->image }}</td>
                                <td>
                                    <a href="{{ route('tenant_product_show', $product->id) }}" data-toggle="tooltip"
                                        title="View details of this product">
                                        Show | 
                                    </a>
                                    <a href="{{ route('tenant_product_edit', $product->id) }}" data-toggle="tooltip"
                                        title="Edit this product's information">
                                        Edit |
                                    </a>
                                    <a href="{{ route('tenant_product_destroy', $product->id) }}" data-toggle="tooltip"
                                        title="Delete this product">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Label</th>
                            <th scope="col">SKU</th>
                            <th scope="col">Weight</th>
                            <th scope="col">Cost</th>
                            <th scope="col">Detail</th>
                            <th scope="col">Image</th>
                            <th scope="col">Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        @include('partials.tenant-pagination', ['paginator' => $product])
    </form>
@endsection
@section('products_script')
    <script>
        function confirmation(ev) {
            ev.preventDefault();
            var urlToRedirect = ev.currentTarget.getAttribute('href'); // Get href value of the link
            swal({
                title: "Are you sure to delete this?",
                text: "This action will be permanent and cannot be undone.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    window.location.href = urlToRedirect;
                } else {
                    swal("Your data is safe!", {
                        icon: "info",
                    });
                }
            });
        }
    </script>


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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 <script>
    // Function to handle keyup event for search input fields
    function handleKeyup(inputId, field) {
        document.getElementById(inputId).addEventListener('keyup', function() {
            const query = this.value.trim();

            if (query.length > 1) { // Start searching after 2 characters
                fetch(`{{ route('tenant_product_search') }}?query=${query}&field=${field}`)
                    .then(response => response.json())
                    .then(data => {
                        // Clear the table content
                        const tableBody = document.querySelector('table tbody');
                        tableBody.innerHTML = '';

                        // Populate the table with filtered data
                        if (data.length) {
                            data.forEach(item => {
                                const row = document.createElement('tr');
                                row.innerHTML = `
                                        <td>${item.id}</td>
                                        <td>${item.product}</td>
                                        <td>${item.product_section}</td>
                                        <td>${item.product_label}</td>
                                        <td>
                                            <a href="/product-catalog/${item.id}/show">Show</a> |
                                            <a href="/product-catalog/${item.id}/edit">Edit</a> |
                                            <a href="javascript:void(0);" onclick="deleteCatalog(${item.id})">Delete</a>
                                        </td>
                                    `;
                                tableBody.appendChild(row);
                            });
                        } else {
                            tableBody.innerHTML = '<tr><td colspan="5">No results found</td></tr>';
                        }
                    })
                    .catch(error => console.error('Error fetching filtered data:', error));
            }
        });
    }

    // Call the handleKeyup function for all fields
    handleKeyup('product', 'product');
    handleKeyup('product_section', 'product_section');
    handleKeyup('product_label', 'product_label');
</script>
