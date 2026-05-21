@extends('layouts.tenant.settings')
@section('title', 'Tax & Fees')

@section('breadcrumb-title')
    <h2>Tax &amp; <span>Fees</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item active">Tax &amp; Fees</li>
@endsection

@section('setting_content')
<p class="text-muted small mb-3">Fuel surcharge and payment fees used at checkout (legacy CI <code>tax_values</code> keys). Taxable users are set per account under <a href="{{ route('tenant_user_index') }}">Users</a>.</p>

<form class="tc-settings-form" action="{{ route('tenant_setting_tax_fees_store') }}" method="post">
    @csrf
    <div class="row g-3">
        @foreach (\App\Services\TaxValuesService::feeKeys() as $key => $meta)
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="{{ $key }}">{{ $meta['label'] }} <span class="text-danger">*</span></label>
                    <input type="number" step="0.01" min="0" class="form-control" name="{{ $key }}" id="{{ $key }}"
                        value="{{ old($key, $values[$key] ?? $meta['default']) }}" required>
                </div>
            </div>
        @endforeach
    </div>
    <div class="tc-settings-form-actions mt-3">
        <button type="submit" class="btn btn-primary">Save tax &amp; fees</button>
    </div>
</form>
@endsection
