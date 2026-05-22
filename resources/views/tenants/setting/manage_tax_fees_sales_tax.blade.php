@extends('layouts.tenant.settings')
@section('title', 'Sales Tax Counties')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_setting_tax_fees') }}">Tax &amp; Fees</a></li>
    <li class="breadcrumb-item active">Sales tax counties</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.tax-fees-nav')

<p class="text-muted small mb-3">
    Florida county sales tax rates (legacy CI <code>sales_tax_counties</code>). At checkout, the rate is matched by
    ship-to county name. If no match is found, the fallback % on the Payment &amp; fuel tab is used.
</p>

@if ($counties->isEmpty())
    <div class="alert alert-warning">No county records found. Run tenant migrations, then reload this page to seed defaults.</div>
@else
    <form class="tc-settings-form" action="{{ route('tenant_setting_tax_fees_sales_tax_store') }}" method="post">
        @csrf
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle">
                <thead>
                    <tr>
                        <th>County</th>
                        <th class="text-end" style="width: 140px;">Tax rate (%)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($counties as $county)
                        <tr>
                            <td>{{ $county->counties }}</td>
                            <td class="text-end">
                                <input type="number" step="0.01" min="0" max="100" class="form-control form-control-sm text-end"
                                    name="counties[{{ $county->id }}][tax]"
                                    value="{{ old('counties.'.$county->id.'.tax', $county->tax) }}" required>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="tc-settings-form-actions mt-3">
            <button type="submit" class="btn btn-primary">Save county tax rates</button>
        </div>
    </form>
@endif
@endsection
