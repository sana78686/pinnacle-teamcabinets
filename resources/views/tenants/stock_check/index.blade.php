@extends('layouts.tenant.master')
@section('title', 'Stock Check Requests')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Stock Check<span>Requests </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Stock Check</li>
    <li class="breadcrumb-item">List</li>
@endsection

@section('content')

<div class="p-2 mt-0 card-header no-border">
    <a href="{{ route('tenant_deleted_stock_check_list') }}" class="btn btn-success btn-sm" data-toggle="tooltip"
        title="Restore a previously deleted Stock Check">
        <i class="icofont icofont-spinner-alt-3"></i> Restore Stock Check
    </a>
    <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
        <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
    </a>
</div>

<div class="pt-0 card-body">
    @include('partials.tc-list-toolbar', [
        'listUrl' => route('tenant_stock_check_index'),
        'perPage' => $perPage ?? tenant_list_per_page(),
        'search' => $search ?? '',
    ])
<div class="table-responsive table-sm tc-admin-datatable">
        <table class="table p-0 m-0 display table-striped table-bordered table-sm">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Bill Name</th>
                    <th scope="col">Job Name</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Created Date</th>
                    <th scope="col">Completion Date</th>
                    <th scope="col">Is Approved</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stock_check_requests as $request)
                    <tr class="{{ tenant_admin_unviewed_row_class($request) }}">
                        <td>{{ $request->id }}</td>
                        <td>{{ $request->billToName() }}</td>
                        <td>{{ $request->job_name ?? '—' }}</td>
                        <td>{{ filled($request->user?->company_name) ? $request->user->company_name : 'N/A' }}</td>
                        <td>{{ $request->created_at?->format('Y-m-d H:i:s') ?? '—' }}</td>
                        <td>{{ $request->completion_date?->format('Y-m-d H:i:s') ?? '' }}</td>
                        <td>{{ $request->isApproved() ? 'Yes' : 'No' }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('tenant_stock_check_show', $request->id) }}">View</a> ||
                            <a href="{{ route('tenant_stock_check_edit', $request->id) }}">Edit</a> ||
                            <a href="{{ route('tenant_stock_check_print', $request->id) }}" target="_blank">Print</a> ||
                            <form action="{{ route('tenant_stock_check_destroy', $request->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Are you sure to delete stock check quote?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm p-0 align-baseline">Delete</button>
                            </form> ||
                            <a href="#" class="js-stock-warehouse-email" data-id="{{ $request->id }}">Send Email To
                                Warehouse</a> ||
                            <a href="{{ route('tenant_stock_check_show', ['id' => $request->id, 'view' => 'org']) }}">View Org
                                Data</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted">No stock check requests yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @include('partials.tenant-pagination', ['paginator' => $stock_check_requests])
</div>

@include('tenants.stock_check.partials.warehouse_email_modal')

@endsection

@section('script')
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: @json(session('success')),
                confirmButtonText: 'OK'
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: @json(session('error')),
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalEl = document.getElementById('stockCheckWarehouseModal');
            const emailInput = document.getElementById('stock_check_warehouse_email');
            const requestIdInput = document.getElementById('stock_check_request_id');
            const statusMsg = document.querySelector('#stockCheckWarehouseModal .statusMsg');
            const submitBtn = document.querySelector('#stockCheckWarehouseModal .submitBtn');
            const warehouseUrlTemplate = @json(route('tenant_stock_check_warehouse_email', ['id' => '__ID__']));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            function validateEmail(email) {
                return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
            }

            document.querySelectorAll('.js-stock-warehouse-email').forEach(function(link) {
                link.addEventListener('click', function(event) {
                    event.preventDefault();
                    requestIdInput.value = this.dataset.id || '';
                    emailInput.value = '';
                    statusMsg.innerHTML = '';
                    if (window.bootstrap?.Modal) {
                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    } else if (window.jQuery) {
                        window.jQuery(modalEl).modal('show');
                    }
                });
            });

            window.submitStockCheckWarehouseEmail = function() {
                const email = emailInput.value.trim();
                const id = requestIdInput.value;
                statusMsg.innerHTML = '';

                if (email === '') {
                    statusMsg.innerHTML = '<span class="text-danger">Please enter Warehouse Email.</span>';
                    emailInput.focus();
                    return;
                }

                if (!validateEmail(email)) {
                    statusMsg.innerHTML = '<span class="text-danger">Please enter a valid Email.</span>';
                    emailInput.focus();
                    return;
                }

                submitBtn.disabled = true;

                fetch(warehouseUrlTemplate.replace('__ID__', id), {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            email: email
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            requestIdInput.value = '';
                            statusMsg.innerHTML =
                                '<span class="text-success">Your email is successfully delivered.</span>';
                        } else {
                            statusMsg.innerHTML =
                                '<span class="text-danger">Some problem occurred, please try again.</span>';
                        }
                    })
                    .catch(function() {
                        statusMsg.innerHTML =
                            '<span class="text-danger">Some problem occurred, please try again.</span>';
                    })
                    .finally(function() {
                        submitBtn.disabled = false;
                        setTimeout(function() {
                            statusMsg.innerHTML = '';
                        }, 5000);
                        setTimeout(function() {
                            if (window.bootstrap?.Modal) {
                                bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                            } else if (window.jQuery) {
                                window.jQuery(modalEl).modal('hide');
                            }
                        }, 4500);
                    });
            };
        });
    </script>
@endsection
