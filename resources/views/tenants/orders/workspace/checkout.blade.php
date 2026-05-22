@extends('layouts.tenant.master')

@section('title', 'Checkout')

@section('content')
@php
    $rooms = json_decode($cartData['room_data'] ?? '{}', true) ?: [];
    $fees = $feeConfig ?? [];
    $totals = $checkoutTotals ?? [];
@endphp
<div class="container-fluid">
    <div class="tc-card p-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div>
                <h1 class="h4 mb-1">Checkout</h1>
                <p class="text-muted mb-0">Review your order, shipping, tax, and payment (CI <code>cart_checkout_product</code>).</p>
            </div>
            <a href="{{ route('tenant_order_workspace') }}" class="btn btn-light btn-sm">Back to catalogs</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="post" action="{{ route('tenant_order_workspace_checkout_submit') }}" id="ow-checkout-form">
            @csrf
            <input type="hidden" name="total_fuel_charges_for_order" id="ow-fuel-total-input" value="{{ $totals['fuel_amount'] ?? 0 }}">
            <input type="hidden" name="updated_sales_tax" id="ow-sales-tax-input" value="{{ $salesTaxPercent }}">
            <input type="hidden" name="custom_all_cart_total" id="ow-grand-total-input" value="{{ $totals['grand_total'] ?? 0 }}">

            <div class="row">
                <div class="col-lg-7">
                    <h5 class="mb-2">Job: {{ $cartData['job_name'] }}</h5>
                    @if (! empty($payload['comment']))
                        <p class="text-muted small">Comment: {{ $payload['comment'] }}</p>
                    @endif

                    <div class="table-responsive mb-3">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>Check</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Wt</th>
                                    <th>Unit</th>
                                    <th>Total</th>
                                    <th>Qty</th>
                                    @if ($assembleYes)<th>Assemble</th>@endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($rooms as $roomName => $room)
                                    <tr class="table-secondary"><th colspan="{{ $assembleYes ? 8 : 7 }}">{{ $roomName }}</th></tr>
                                    @php $n = count($room['product_sku'] ?? []); @endphp
                                    @for ($i = 0; $i < $n; $i++)
                                        <tr>
                                            <td>
                                                <input type="checkbox" disabled {{ ($room['checkbox_val1'][$i] ?? '0') == '1' ? 'checked' : '' }}>
                                                <input type="checkbox" disabled {{ ($room['checkbox_val2'][$i] ?? '0') == '1' ? 'checked' : '' }}>
                                            </td>
                                            <td>{{ $room['product_name'][$i] ?? $room['product_sku'][$i] }}</td>
                                            <td>{{ $room['product_cabinets_description'][$i] ?? '' }}</td>
                                            <td>{{ $room['product_weight'][$i] ?? 0 }} lbs</td>
                                            <td>${{ number_format((float) ($room['product_cost'][$i] ?? 0), 2) }}</td>
                                            <td>${{ number_format((float) (($room['product_cost'][$i] ?? 0) * ($room['product_quantity'][$i] ?? 1)), 2) }}</td>
                                            <td>{{ $room['product_quantity'][$i] ?? 1 }}</td>
                                            @if ($assembleYes)
                                                <td>${{ number_format((float) ($room['product_assemble_cost'][$i] ?? 0), 2) }}</td>
                                            @endif
                                        </tr>
                                    @endfor
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Subtotal</th>
                                    <th>{{ number_format($weight, 2) }} lbs</th>
                                    <th></th>
                                    <th>${{ number_format($subTotal, 2) }}</th>
                                    <th colspan="{{ $assembleYes ? 2 : 1 }}"></th>
                                </tr>
                                <tr>
                                    <th colspan="5">Fuel surcharge ({{ $fees['fuel_percent'] ?? 0 }}%)</th>
                                    <th id="ow-fuel-amt">${{ number_format($totals['fuel_amount'] ?? 0, 2) }}</th>
                                    <th colspan="{{ $assembleYes ? 2 : 1 }}"></th>
                                </tr>
                                @if ($assembleYes)
                                    <tr>
                                        <th colspan="5">Cabinetry assembly</th>
                                        <th>${{ number_format($assembleTotal, 2) }}</th>
                                        <th colspan="2"></th>
                                    </tr>
                                @endif
                                <tr>
                                    <th colspan="5">Shipping</th>
                                    <td colspan="2">
                                        <label class="d-block"><input type="radio" name="self_ship" value="pickup" checked> I will pick up my order</label>
                                        <label class="d-block"><input type="radio" name="self_ship" value="quote"> Provide shipping amount via email/phone</label>
                                        <p class="text-danger small mb-0">NOTE: Shipping charges are independent from this order unless quoted.</p>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="5">Sales tax ({{ $salesTaxPercent }}%)</th>
                                    <th id="ow-sales-tax">${{ number_format($totals['sales_tax_amount'] ?? 0, 2) }}</th>
                                    <th colspan="{{ $assembleYes ? 2 : 1 }}"></th>
                                </tr>
                                <tr id="ow-card-fee-row" style="display:{{ ($totals['credit_card_charges'] ?? 0) > 0 ? '' : 'none' }}">
                                    <th colspan="5">Payment processing fee</th>
                                    <th id="ow-card-fee-amt">${{ number_format($totals['credit_card_charges'] ?? 0, 2) }}</th>
                                    <th colspan="{{ $assembleYes ? 2 : 1 }}"></th>
                                </tr>
                                <tr id="ow-ach-fee-row" style="display:{{ ($totals['ach_charges'] ?? 0) > 0 ? '' : 'none' }}">
                                    <th colspan="5">ACH fee</th>
                                    <th id="ow-ach-fee-amt">${{ number_format($totals['ach_charges'] ?? 0, 2) }}</th>
                                    <th colspan="{{ $assembleYes ? 2 : 1 }}"></th>
                                </tr>
                                <tr class="font-weight-bold">
                                    <th colspan="5">Estimated total</th>
                                    <th id="ow-grand-total">${{ number_format($totals['grand_total'] ?? 0, 2) }}</th>
                                    <th colspan="{{ $assembleYes ? 2 : 1 }}"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="tc-card p-3 mb-3" style="background:#f8fafc;">
                        <h5 class="h6">Bill to</h5>
                        <div class="form-group mb-2">
                            <label class="small">Name</label>
                            <input type="text" name="bill_to_name" class="form-control form-control-sm" value="{{ old('bill_to_name', $cartData['bill_to_name']) }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small">Address</label>
                            <input type="text" name="bill_to_address" class="form-control form-control-sm" value="{{ old('bill_to_address', $cartData['bill_to_address']) }}">
                        </div>
                        <div class="row">
                            <div class="col-6 form-group mb-2">
                                <label class="small">City</label>
                                <input type="text" name="bill_to_city" class="form-control form-control-sm" value="{{ old('bill_to_city', $cartData['bill_to_city']) }}">
                            </div>
                            <div class="col-6 form-group mb-2">
                                <label class="small">County</label>
                                <input type="text" name="bill_to_county" class="form-control form-control-sm" value="{{ old('bill_to_county', $cartData['bill_to_county']) }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 form-group mb-2">
                                <label class="small">State</label>
                                <input type="text" name="bill_to_state" class="form-control form-control-sm" value="{{ old('bill_to_state', $cartData['bill_to_state']) }}">
                            </div>
                            <div class="col-6 form-group mb-2">
                                <label class="small">Zip</label>
                                <input type="text" name="bill_to_zip" class="form-control form-control-sm" value="{{ old('bill_to_zip', $cartData['bill_to_zipcode']) }}">
                            </div>
                        </div>
                        <div class="form-group mb-2">
                            <label class="small">Email</label>
                            <input type="email" name="bill_to_email" class="form-control form-control-sm" value="{{ old('bill_to_email', $cartData['bill_to_email']) }}" required>
                        </div>
                        <div class="form-group mb-0">
                            <label class="small">Phone</label>
                            <input type="text" name="bill_to_phone" class="form-control form-control-sm" value="{{ old('bill_to_phone', $cartData['bill_to_phone']) }}">
                        </div>
                    </div>

                    <div class="tc-card p-3 mb-3" style="background:#f8fafc;">
                        <h5 class="h6">Ship to</h5>
                        <label class="small d-block mb-2"><input type="checkbox" id="ow-same-as-bill" checked> Same as bill to</label>
                        <div id="ow-ship-fields" style="display:none">
                            <div class="form-group mb-2">
                                <input type="text" name="ship_to_name" class="form-control form-control-sm" placeholder="Name" value="{{ old('ship_to_name', $cartData['ship_to_name']) }}">
                            </div>
                            <div class="form-group mb-2">
                                <input type="text" name="ship_to_address" class="form-control form-control-sm" placeholder="Address" value="{{ old('ship_to_address', $cartData['ship_to_address']) }}">
                            </div>
                            <div class="row">
                                <div class="col-6"><input type="text" name="ship_city" class="form-control form-control-sm mb-2" placeholder="City" value="{{ old('ship_city', $cartData['ship_to_city']) }}"></div>
                                <div class="col-6"><input type="text" name="ship_county" class="form-control form-control-sm mb-2" placeholder="County" value="{{ old('ship_county', $cartData['ship_to_county']) }}"></div>
                            </div>
                            <div class="row">
                                <div class="col-6"><input type="text" name="ship_state" class="form-control form-control-sm mb-2" placeholder="State" value="{{ old('ship_state', $cartData['ship_to_state']) }}"></div>
                                <div class="col-6"><input type="text" name="ship_zip" class="form-control form-control-sm mb-2" placeholder="Zip" value="{{ old('ship_zip', $cartData['ship_to_zipcode']) }}"></div>
                            </div>
                        </div>
                    </div>

                    <div class="tc-card p-3">
                        <h5 class="h6 mb-3">Payment method</h5>
                        <label class="d-block"><input type="radio" name="payment_method" value="Check" checked required> Check</label>
                        <label class="d-block"><input type="radio" name="payment_method" value="Purchase Order" required> Purchase Order</label>
                        <label class="d-block"><input type="radio" name="payment_method" value="Credit Card" required> Credit Card</label>
                        <label class="d-block"><input type="radio" name="payment_method" value="Debit Card" required> Debit Card</label>
                        <label class="d-block"><input type="radio" name="payment_method" value="ACH" required> ACH</label>

                        <div id="ow-panel-card" class="ow-pay-panel mt-3" style="display:none">
                            <input type="text" name="card_number" class="form-control form-control-sm mb-2" placeholder="Card number">
                            <input type="text" name="expiry_date" class="form-control form-control-sm mb-2" placeholder="MM/YY">
                            <input type="text" name="cvv_number" class="form-control form-control-sm mb-2" placeholder="CVV">
                            <input type="text" name="checkout_fname" class="form-control form-control-sm mb-2" placeholder="Name on card">
                            <input type="text" name="checkout_address" class="form-control form-control-sm mb-2" placeholder="Billing address">
                            <div class="row">
                                <div class="col-4"><input type="text" name="checkout_city" class="form-control form-control-sm" placeholder="City"></div>
                                <div class="col-4"><input type="text" name="checkout_state" class="form-control form-control-sm" placeholder="State"></div>
                                <div class="col-4"><input type="text" name="checkout_zipcode" class="form-control form-control-sm" placeholder="Zip"></div>
                            </div>
                        </div>
                        <div id="ow-panel-ach" class="ow-pay-panel mt-3" style="display:none">
                            <input type="text" name="account_number" class="form-control form-control-sm mb-2" placeholder="Account number">
                            <input type="text" name="route_number" class="form-control form-control-sm mb-2" placeholder="Routing number">
                            <input type="text" name="ach_checkout_fname" class="form-control form-control-sm mb-2" placeholder="Account holder name">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mt-3">Place order</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    window.owCheckout = {
        subTotal: {{ json_encode($subTotal) }},
        assembleTotal: {{ json_encode($assembleTotal) }},
        fuelPercent: {{ json_encode($fees['fuel_percent'] ?? 0) }},
        salesTaxPercent: {{ json_encode($salesTaxPercent) }},
        creditCardPercent: {{ json_encode($fees['credit_card_percent'] ?? 0) }},
        debitCardPercent: {{ json_encode($fees['debit_card_percent'] ?? 0) }},
        achCharge: {{ json_encode($fees['ach_charge'] ?? 0) }},
    };
    document.getElementById('ow-same-as-bill')?.addEventListener('change', function () {
        document.getElementById('ow-ship-fields').style.display = this.checked ? 'none' : 'block';
    });
</script>
<script src="{{ asset('js/checkout-page.js') }}?v=1"></script>
@endsection
