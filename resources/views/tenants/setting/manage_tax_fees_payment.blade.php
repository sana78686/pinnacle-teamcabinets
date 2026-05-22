@extends('layouts.tenant.settings')
@section('title', 'Payment & Fuel Fees')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_setting_tax_fees') }}">Tax &amp; Fees</a></li>
    <li class="breadcrumb-item active">Payment &amp; fuel</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.tax-fees-nav')

<p class="text-muted small mb-3">Used at checkout for fuel surcharge and payment method fees (legacy CI <code>tax_values</code> keys).</p>

<form class="tc-settings-form" action="{{ route('tenant_setting_tax_fees_payment_store') }}" method="post">
    @csrf
    <div class="row g-3">
        @foreach (\App\Services\TaxValuesService::paymentFeeKeys() as $key => $meta)
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
        <button type="submit" class="btn btn-primary">Save payment &amp; fuel fees</button>
    </div>
</form>
@endsection
