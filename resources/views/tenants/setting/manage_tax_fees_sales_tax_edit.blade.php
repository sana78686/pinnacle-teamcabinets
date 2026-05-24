@extends('layouts.tenant.settings')
@section('title', 'Edit Sales Tax County')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_setting_tax_fees_sales_tax') }}">Sales Tax Management</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.tax-fees-nav')

<div class="tc-settings-form" style="max-width: 480px;">
    <h3 class="h6 mb-3">Edit county sales tax</h3>
    <form action="{{ route('tenant_setting_tax_fees_sales_tax_update', $county->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="tc-field mb-3">
            <label for="state">State <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="state" value="{{ $stateName }}" disabled readonly>
        </div>
        <div class="tc-field mb-3">
            <label for="county_display">County <span class="text-danger">*</span></label>
            <input type="text" class="form-control" id="county_display" value="{{ $county->counties }}" disabled readonly>
        </div>
        <div class="tc-field mb-3">
            <label for="sales_tax_amount">Sales tax amount (%) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" min="0" max="100" class="form-control" name="sales_tax_amount" id="sales_tax_amount"
                value="{{ old('sales_tax_amount', $county->tax) }}" required>
        </div>
        <div class="tc-settings-form-actions">
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="{{ route('tenant_setting_tax_fees_sales_tax') }}" class="btn btn-light">Cancel</a>
        </div>
    </form>
</div>
@endsection
