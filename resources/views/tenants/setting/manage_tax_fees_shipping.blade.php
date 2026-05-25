@extends('layouts.tenant.settings')
@section('title', 'Shipping Quote Charges')

@section('breadcrumb-items')
    <li class="breadcrumb-item">Settings</li>
    <li class="breadcrumb-item"><a href="{{ route('tenant_setting_tax_fees') }}">Tax &amp; Fees</a></li>
    <li class="breadcrumb-item active">Shipping charges</li>
@endsection

@section('setting_content')
@include('layouts.tenant.partials.tax-fees-nav')

<p class="text-muted small mb-3">
    Applied when customers request shipping quotes, stock checks, or checkout shipping. Weight-based surcharges (+$75 light / +$150 heavy by default)
    are added to checkout when cart weight is at or below the light threshold, or above it. Commercial delivery, liftgate, and unload
    charges apply to shipping-quote forms (unload is $0 for residential unload-by-hand).
</p>

<form class="tc-settings-form" action="{{ route('tenant_setting_tax_fees_shipping_store') }}" method="post">
    @csrf
    <div class="row g-3">
        @foreach (\App\Services\TaxValuesService::shippingFeeKeys() as $key => $meta)
            @php $isWeightThreshold = str_contains($key, 'threshold'); @endphp
            <div class="col-md-6">
                <div class="tc-field">
                    <label for="{{ $key }}">{{ $meta['label'] }} <span class="text-danger">*</span></label>
                    @if ($isWeightThreshold)
                        <input type="number" step="0.01" min="0" class="form-control" name="{{ $key }}" id="{{ $key }}"
                            value="{{ old($key, $values[$key] ?? $meta['default']) }}" required>
                    @else
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" class="form-control" name="{{ $key }}" id="{{ $key }}"
                                value="{{ old($key, $values[$key] ?? $meta['default']) }}" required>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
    <div class="tc-settings-form-actions mt-3">
        <button type="submit" class="btn btn-primary">Save shipping charges</button>
    </div>
</form>
@endsection
