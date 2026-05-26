@extends('layouts.tenant.master')
@section('title', 'Orders')

@section('breadcrumb-title')
    <h2>Orders</h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Orders</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="p-2 mt-0 card-header no-border d-flex flex-wrap align-items-center justify-content-end gap-2">
        <a href="{{ route('tenant_deleted_order_list') }}" class="btn btn-info btn-sm text-white">Deleted Orders</a>
        @if (! empty($exportCsvUrl))
            <a href="{{ $exportCsvUrl }}" class="btn btn-info btn-sm text-white">Download All Orders CSV</a>
        @endif
        <form method="get" action="{{ route('tenant_order_list') }}" class="mb-0">
            @foreach (request()->except(['page', 'user_type']) as $key => $val)
                @if (is_scalar($val) && $val !== '')
                    <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                @endif
            @endforeach
            <select name="user_type" class="form-select form-select-sm btn btn-info text-white tc-orders-user-filter"
                onchange="this.form.submit()" aria-label="Filter orders by user type">
                @foreach ($userTypeFilters as $value => $label)
                    <option value="{{ $value }}" @selected(($userType ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </form>
    </div>

    @include('tenants.orders.partials.orders-list-table', [
        'records' => $records,
        'sourceBadges' => $sourceBadges,
        'perPage' => $perPage,
        'search' => $search,
    ])
@endsection

@section('script')
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
