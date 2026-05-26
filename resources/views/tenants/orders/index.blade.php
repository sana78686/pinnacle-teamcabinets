@extends('layouts.tenant.master')
@section('title', 'Orders')

@section('breadcrumb-title')
    <h2>Orders <span>List</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Orders</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="p-2 mt-0 card-header no-border">
        <a href="{{ route('tenant_deleted_order_list') }}" class="btn btn-success btn-sm" data-toggle="tooltip"
            title="View deleted orders">
            <i class="icofont icofont-trash"></i> Deleted Orders
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this page">
            <i class="icofont icofont-refresh"></i> Refresh
        </a>
        <div class="pull-right">
            @if (! empty($exportCsvUrl))
                <a href="{{ $exportCsvUrl }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                    title="Download all orders as CSV">
                    <i class="icofont icofont-download-alt"></i> Download All Orders CSV
                </a>
            @endif
        </div>
    </div>

    @include('partials.tc-list-toolbar', [
        'listUrl' => route('tenant_order_list'),
        'perPage' => $perPage,
        'search' => $search,
        'paginator' => $records,
        'searchPlaceholder' => 'Filter…',
        'userTypeFilters' => $userTypeFilters ?? null,
        'userType' => $userType ?? '',
    ])

    @include('tenants.orders.partials.orders-list-table', [
        'records' => $records,
        'sourceBadges' => $sourceBadges,
    ])
@endsection

@section('script')
    <script src="{{ $panelAsset('js/tenant-list-filter.js') }}?v=2"></script>
    @if (auth()->user()?->isAdmin())
        <script>
            document.querySelectorAll('[data-order-status-select]').forEach(function(select) {
                select.addEventListener('change', function() {
                    const status = this.value;
                    fetch('{{ route('tenant_order_update_status') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            status: status
                        }),
                    }).then(function(r) {
                        return r.json();
                    }).then(function(data) {
                        if (data === 1 || data?.ok) {
                            window.location.reload();
                        } else {
                            alert(data?.message || 'Could not update order status.');
                        }
                    }).catch(function() {
                        alert('Could not update order status.');
                    });
                });
            });
        </script>
    @endif
@endsection
