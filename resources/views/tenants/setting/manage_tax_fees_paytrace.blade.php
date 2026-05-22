@extends('layouts.tenant.settings')
@section('title', 'Paytrace')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_setting_tax_fees') }}">Tax &amp; Fees</a></li>
    <li class="breadcrumb-item active">Paytrace</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.tax-fees-nav')

<p class="text-muted small mb-3">Paytrace API credentials for card processing at checkout.</p>

<form class="tc-settings-form" action="{{ route('tenant_setting_tax_fees_paytrace_store') }}" method="post">
    @csrf
    <div class="row g-3">
        @foreach (\App\Services\TaxValuesService::paytraceKeys() as $key => $meta)
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="{{ $key }}">{{ $meta['label'] }}</label>
                    <input type="{{ $key === 'paytrace_password' ? 'password' : 'text' }}" class="form-control"
                        name="{{ $key }}" id="{{ $key }}" autocomplete="off"
                        value="{{ old($key, $values[$key] ?? '') }}">
                </div>
            </div>
        @endforeach
    </div>
    <div class="tc-settings-form-actions mt-3">
        <button type="submit" class="btn btn-primary">Save Paytrace credentials</button>
    </div>
</form>
@endsection
