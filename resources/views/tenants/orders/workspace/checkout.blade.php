@extends(tenant_panel_layout())

@section('title', 'Checkout')

@section('breadcrumb-title')
    <h2>Checkout</h2>
@endsection

@section('breadcrumb-items')
    @php
        $stockCheckId = session('stock_check_checkout_id');
        $shippingQuoteId = session('shipping_quote_checkout_id');
    @endphp
    @if ($stockCheckId)
        <li class="breadcrumb-item"><a href="{{ route('tenant_stock_check_index') }}">Stock Check</a></li>
        @unless ($backToCartDisabled ?? false)
            <li class="breadcrumb-item"><a href="{{ $backToCartUrl }}">Request</a></li>
        @endunless
    @elseif ($shippingQuoteId)
        <li class="breadcrumb-item"><a href="{{ route('tenant_shipping_quotes_index') }}">Shipping Quotes</a></li>
        @unless ($backToCartDisabled ?? false)
            <li class="breadcrumb-item"><a href="{{ $backToCartUrl }}">Quote</a></li>
        @endunless
    @else
        <li class="breadcrumb-item"><a href="{{ route('tenant_order_workspace') }}">Create Order</a></li>
    @endif
    <li class="breadcrumb-item active">Checkout</li>
@endsection

@section('style')
<link rel="stylesheet" href="{{ tenant_static_asset('css/checkout-page.css') }}?v=8">
@endsection

@section('content')
@php
    $rooms = json_decode($cartData['room_data'] ?? '{}', true) ?: [];
    $fees = $feeConfig ?? [];
    $totals = $checkoutTotals ?? [];
    $savings = $paymentSavings ?? [];
    $hasAssemble = $assembleYes ?? false;
    $colSpan = $hasAssemble ? 8 : 7;
    $hasPresetShipping = $hasPresetShipping ?? false;
    $shipState = old('ship_state', $cartData['ship_to_state'] ?? '');
    $shipCounty = old('ship_county', $cartData['ship_to_county'] ?? '');
    $isFlShip = in_array(strtolower($shipState), ['florida', 'fl'], true);
@endphp

<div class="container-fluid tc-checkout-page">
    <div class="tc-checkout ow-checkout-main">

    @if ($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif

    <form method="post" action="{{ route('tenant_order_workspace_checkout_submit') }}" id="ow-checkout-form" novalidate>
        @csrf
        <input type="hidden" name="room_data" value="{{ $cartData['room_data'] ?? '' }}">
        <input type="hidden" name="job_name" value="{{ $cartData['job_name'] ?? '' }}">
        <input type="hidden" name="order_comment" value="{{ $cartData['order_comment'] ?? '' }}">
        <input type="hidden" name="total_fuel_charges_for_order" id="ow-fuel-total-input" value="{{ $totals['fuel_amount'] ?? 0 }}">
        <input type="hidden" name="updated_sales_tax" id="ow-sales-tax-input" value="{{ $salesTaxPercent }}">
        <input type="hidden" name="custom_all_cart_total" id="ow-grand-total-input" value="{{ $totals['grand_total'] ?? 0 }}">
        @if ($hasPresetShipping)
            <input type="hidden" name="is_shipping_quote" value="{{ $cartData['is_shipping_quote'] ?? 1 }}">
            <input type="hidden" name="order_shipping_cost" value="{{ $shippingCost }}">
        @endif

        <div class="row">
            {{-- Left: Cart + addresses (CI col-lg-6) --}}
            <div class="col-lg-7 tc-checkout__main-col">
                <div class="tc-checkout__cart-card">
                    <div class="tc-checkout__cart-head">
                        <h2>Cart</h2>
                    </div>
                    <div class="tc-checkout__cart-body">
                        <div class="tc-checkout__job"><strong>Job Name</strong> : {{ $cartData['job_name'] }}</div>

                        <p class="tc-checkout-table-scroll-hint mb-0">Swipe or scroll horizontally to see all cart columns.</p>
                        <div class="tc-checkout-table-wrap">
                            <table class="table table-bordered table-sm tc-checkout-table mb-0">
                                <thead>
                                    <tr>
                                        <th class="tc-checkout-col-checks">Double Check Work</th>
                                        <th class="tc-checkout-col-name">Cabinet Name</th>
                                        <th class="tc-checkout-col-desc">Cabinet Description</th>
                                        <th class="text-end tc-checkout-col-num">Weight</th>
                                        <th class="text-end tc-checkout-col-num">Unit Price</th>
                                        <th class="text-end tc-checkout-col-num">Total Price</th>
                                        <th class="text-end tc-checkout-col-qty">Quantity</th>
                                        @if ($hasAssemble)<th class="text-end tc-checkout-col-num">Assemble Cost</th>@endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rooms as $roomName => $room)
                                        <tr class="table-light"><th colspan="{{ $colSpan }}">{{ $roomName }}</th></tr>
                                        @php $n = count($room['product_sku'] ?? []); @endphp
                                        @for ($i = 0; $i < $n; $i++)
                                            <tr>
                                                <td data-label="Double Check">
                                                    <span class="tc-checkout-checks">
                                                        <span class="tc-checkout-check tc-checkout-check--yellow{{ ($room['checkbox_val1'][$i] ?? '0') == '1' ? ' is-on' : '' }}"></span>
                                                        <span class="tc-checkout-check tc-checkout-check--green{{ ($room['checkbox_val2'][$i] ?? '0') == '1' ? ' is-on' : '' }}"></span>
                                                    </span>
                                                </td>
                                                <td class="tc-checkout-col-name" data-label="Cabinet Name">{{ $room['product_sku'][$i] ?? '' }}</td>
                                                <td class="tc-checkout-col-desc" data-label="Description">{{ $room['product_cabinets_description'][$i] ?? '' }}</td>
                                                <td class="text-end" data-label="Weight">{{ $room['product_weight'][$i] ?? 0 }} lbs</td>
                                                <td class="text-end" data-label="Unit Price">${{ number_format((float) ($room['product_cost'][$i] ?? 0), 2) }}</td>
                                                @php
                                                    $lineTotal = (float) ($room['product_tot_price'][$i] ?? 0);
                                                    if ($lineTotal <= 0) {
                                                        $lineTotal = (float) ($room['product_cost'][$i] ?? 0) * (int) ($room['product_quantity'][$i] ?? 1);
                                                    }
                                                @endphp
                                                <td class="text-end" data-label="Total Price">${{ number_format($lineTotal, 2) }}</td>
                                                <td class="text-end" data-label="Qty">{{ $room['product_quantity'][$i] ?? 1 }}</td>
                                                @if ($hasAssemble)
                                                    <td class="text-end" data-label="Assemble">
                                                        @if ((float) ($room['product_assemble_cost'][$i] ?? 0) > 0)
                                                            ${{ number_format((float) $room['product_assemble_cost'][$i], 2) }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                @endif
                                            </tr>
                                        @endfor
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3">Sub Total</th>
                                        <td class="text-end">{{ number_format($weight, 2) }} lbs</td>
                                        <td></td>
                                        <td class="text-end">${{ number_format($subTotal, 2) }}</td>
                                        <td></td>
                                        @if ($hasAssemble)
                                            <td class="text-end" id="ow-assemble-subtotal">${{ number_format($assembleTotal, 2) }}</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <th colspan="5">Fuel Charges (<span id="ow-fuel-percent">{{ $fees['fuel_percent'] ?? 0 }}</span>%)</th>
                                        <td class="text-end" id="ow-fuel-amt">${{ number_format($totals['fuel_amount'] ?? 0, 2) }}</td>
                                        <td></td>
                                        @if ($hasAssemble)<td></td>@endif
                                    </tr>
                                    @if ($hasAssemble)
                                        <tr>
                                            <th colspan="5">Cabinetry Assembly Cost</th>
                                            <td class="text-end" id="ow-assemble-total">${{ number_format($assembleTotal, 2) }}</td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endif
                                    @if ($hasPresetShipping && ! empty($shippingBreakdown))
                                        <tr>
                                            <th colspan="5">Shipping Charges</th>
                                            <td></td>
                                            <td></td>
                                            @if ($hasAssemble)<td></td>@endif
                                        </tr>
                                        @foreach ($shippingBreakdown as $label => $amount)
                                            @if ((float) $amount > 0)
                                                <tr>
                                                    <th colspan="5">{{ $label }}</th>
                                                    <td class="text-end">${{ number_format((float) $amount, 2) }}</td>
                                                    <td></td>
                                                    @if ($hasAssemble)<td></td>@endif
                                                </tr>
                                            @endif
                                        @endforeach
                                    @elseif ($hasPresetShipping && ($shippingCost ?? 0) > 0)
                                        <tr>
                                            <th colspan="5">Shipping Charges</th>
                                            <td class="text-end">${{ number_format($shippingCost, 2) }}</td>
                                            <td></td>
                                            @if ($hasAssemble)<td></td>@endif
                                        </tr>
                                    @else
                                        <tr>
                                            <th colspan="3">Shipping Charges</th>
                                            <td colspan="{{ $colSpan - 3 }}" class="tc-checkout-shipping-cell">
                                                <label class="tc-checkout-shipping-opt"><input type="radio" name="self_ship" value="I will pick up my order"> Pick up my order</label>
                                                <label class="tc-checkout-shipping-opt"><input type="radio" name="self_ship" value="Provide me with shipping amount via email/phone" checked> Email/phone shipping quote</label>
                                                <p class="tc-checkout-shipping-note mb-0">NOTE: Shipping charges are independent from this order.</p>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th colspan="3">
                                            Sales Tax (<span id="ow-tax-percent">{{ $salesTaxPercent }}%</span>)
                                            <p class="tc-checkout-tax-note mb-0">NOTE: 'Sales Tax' will be calculated as per your Ship To 'County'.</p>
                                        </th>
                                        <td></td>
                                        <td></td>
                                        <td class="text-end" id="ow-sales-tax">${{ number_format($totals['sales_tax_amount'] ?? 0, 2) }}</td>
                                        <td></td>
                                        @if ($hasAssemble)<td></td>@endif
                                    </tr>
                                    <tr id="ow-payment-fee-row">
                                        <th colspan="5"><span id="ow-payment-fee-label">Credit Card Charges ({{ $fees['credit_card_percent'] ?? 0 }}%)</span></th>
                                        <td></td>
                                        <td></td>
                                        <td class="text-end" id="ow-payment-fee-amt">${{ number_format($totals['credit_card_charges'] ?? 0, 2) }}</td>
                                        <td></td>
                                        @if ($hasAssemble)<td></td>@endif
                                    </tr>
                                    <tr class="table-active">
                                        <th colspan="3">Grand Total</th>
                                        <td class="text-end">{{ number_format($weight, 2) }} lbs</td>
                                        <td></td>
                                        <td class="text-end" id="ow-grand-total">${{ number_format($totals['grand_total'] ?? 0, 2) }}</td>
                                        <td></td>
                                        @if ($hasAssemble)<td></td>@endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        @if (! empty($cartData['order_comment']))
                            <div class="tc-checkout__comment"><strong>Comment :</strong> {{ $cartData['order_comment'] }}</div>
                        @endif
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="tc-checkout-address">
                            <h3>Bill To</h3>
                            @include('tenants.orders.workspace.partials.checkout-address-fields', ['prefix' => 'bill', 'data' => $cartData])
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="tc-checkout-address">
                            <h3>Ship To</h3>
                            @include('tenants.orders.workspace.partials.checkout-address-fields', [
                                'prefix' => 'ship',
                                'data' => $cartData,
                                'isShip' => true,
                                'states' => $states,
                                'floridaCounties' => $floridaCounties,
                                'shipState' => $shipState,
                                'shipCounty' => $shipCounty,
                                'isFlShip' => $isFlShip,
                            ])
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Payment methods (CI stacked boxes) --}}
            <div class="col-lg-5 tc-checkout__pay-col">
                @include('tenants.orders.workspace.partials.checkout-payment-credit', ['savings' => $savings, 'cartData' => $cartData])
                @include('tenants.orders.workspace.partials.checkout-payment-debit', ['savings' => $savings])
                @include('tenants.orders.workspace.partials.checkout-payment-ach', ['savings' => $savings])
                @include('tenants.orders.workspace.partials.checkout-payment-cash', ['savings' => $savings])
            </div>
        </div>
    </form>
    </div>
</div>

<div class="tc-checkout__loading" id="ow-checkout-loading" aria-hidden="true">
    <span>Please wait — processing your order…</span>
</div>
@endsection

@section('script')
<script>
    window.owCheckout = {
        subTotal: {{ json_encode($subTotal) }},
        assembleTotal: {{ json_encode($assembleTotal) }},
        shippingCost: {{ json_encode($shippingCost ?? 0) }},
        fuelPercent: {{ json_encode($fees['fuel_percent'] ?? 0) }},
        salesTaxPercent: {{ json_encode($salesTaxPercent) }},
        creditCardPercent: {{ json_encode($fees['credit_card_percent'] ?? 0) }},
        debitCardFlat: {{ json_encode($fees['debit_card_flat'] ?? 0) }},
        achCharge: {{ json_encode($fees['ach_charge'] ?? 0) }},
        salesTaxUrl: @json(route('tenant_order_workspace_checkout_sales_tax')),
        floridaCounties: @json($floridaCounties ?? []),
        shipCounty: @json($shipCounty),
    };
</script>
<script src="{{ tenant_static_asset('js/checkout-page.js') }}?v=5"></script>
@endsection
