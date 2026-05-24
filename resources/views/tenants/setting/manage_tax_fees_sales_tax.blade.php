@extends('layouts.tenant.settings')
@section('title', 'Sales Tax Management')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Sales Tax Management</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.tax-fees-nav')

<h3 class="h5 mb-3">Sales Tax Management</h3>
<p class="text-muted small mb-3">
    Florida county sales tax rates. At checkout, the rate is matched by ship-to county name.
</p>

@if ($counties->isEmpty() && ! request('search'))
    <div class="alert alert-warning">No county records found. Run tenant migrations, then reload this page to seed defaults.</div>
@else
    @include('partials.tc-list-toolbar', [
        'listUrl' => route('tenant_setting_tax_fees_sales_tax'),
        'perPage' => $perPage,
        'search' => $search,
        'perPageOptions' => [10, 25, 50, 100],
    ])

    <div class="table-responsive tc-admin-datatable">
        <table class="table table-striped table-bordered table-sm mb-0">
            <thead>
                <tr>
                    <th scope="col" style="width: 70px;">ID</th>
                    <th scope="col">County</th>
                    <th scope="col" style="width: 120px;">State</th>
                    <th scope="col" style="width: 100px;">Tax(%)</th>
                    <th scope="col" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($counties as $county)
                    <tr>
                        <td>{{ $county->id }}</td>
                        <td>{{ $county->counties }}</td>
                        <td>{{ $stateName }}</td>
                        <td>{{ number_format((float) $county->tax, 2, '.', '') }}</td>
                        <td>
                            <a href="{{ route('tenant_setting_tax_fees_sales_tax_edit', $county->id) }}" class="tc-admin-datatable__edit">
                                <i class="fa fa-edit" aria-hidden="true"></i> Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">No counties match your search.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @include('partials.tenant-pagination', ['paginator' => $counties])
@endif
@endsection
