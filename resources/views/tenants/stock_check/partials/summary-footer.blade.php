@php
    $hasAssemble = $assembleYes ?? false;
    $totalLabel = $totalLabel ?? 'Total';
    $showShippingBreakdown = $showShippingBreakdown ?? false;
    $showSimpleShipping = $showSimpleShipping ?? false;
    $grandDisplay = $grandTotalDisplay ?? $grand_total ?? 0;
@endphp
<tr>
    <th colspan="3">Sub Total</th>
    <td>{{ number_format($sub_total_weight ?? 0, 2) }} lbs</td>
    <td></td>
    <td>${{ number_format($sub_total_price ?? 0, 2) }}</td>
    <td></td>
    @if ($hasAssemble)
        <td>${{ number_format($sub_total_assemble ?? 0, 2) }}</td>
    @endif
    <td></td>
</tr>
<tr>
    <th colspan="5">Fuel Charges ({{ number_format($fuelPercent ?? 0, 0) }}%)</th>
    <td>${{ number_format($fuel_charges ?? 0, 2) }}</td>
    <td></td>
    @if ($hasAssemble)<td></td>@endif
    <td></td>
</tr>
@if ($hasAssemble)
    <tr>
        <th colspan="5">Cabinetry Assembly Cost</th>
        <td>${{ number_format($sub_total_assemble ?? 0, 2) }}</td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
@endif
@if ($showShippingBreakdown)
    <tr>
        <th colspan="5">Shipping Charges</th>
        <td></td>
        <td></td>
        @if ($hasAssemble)<td></td>@endif
        <td></td>
    </tr>
    <tr>
        <th colspan="5">Pallets Cost (Total Pallets = <span id="sc-summary-pallets-count">{{ $total_pallets ?? 1 }}</span>)</th>
        <td>$<span id="sc-summary-pallets-cost">{{ number_format($pallets_cost ?? 0, 2) }}</span></td>
        <td></td>
        @if ($hasAssemble)<td></td>@endif
        <td></td>
    </tr>
    <tr>
        <th colspan="5">Delivery Cost ({{ $deliveryLabel ?? 'Residential' }})</th>
        <td>$<span id="sc-summary-delivery">{{ number_format($delivery_cost ?? 0, 2) }}</span></td>
        <td></td>
        @if ($hasAssemble)<td></td>@endif
        <td></td>
    </tr>
    <tr>
        <th colspan="5">Liftgate Cost</th>
        <td>$<span id="sc-summary-liftgate">{{ number_format($liftgate_cost ?? 0, 2) }}</span></td>
        <td></td>
        @if ($hasAssemble)<td></td>@endif
        <td></td>
    </tr>
    <tr>
        <th colspan="5">Unload Cost ({{ $unloadLabel ?? 'By Hand' }})</th>
        <td>$<span id="sc-summary-unload">{{ number_format($unload_cost ?? 0, 2) }}</span></td>
        <td></td>
        @if ($hasAssemble)<td></td>@endif
        <td></td>
    </tr>
    <tr>
        <th colspan="5">Miscellaneous Charges</th>
        <td>$<span id="sc-summary-misc">{{ number_format($miscellaneous_cost ?? 0, 2) }}</span></td>
        <td></td>
        @if ($hasAssemble)<td></td>@endif
        <td></td>
    </tr>
@elseif ($showSimpleShipping)
    <tr>
        <th colspan="5">Shipping Charges</th>
        <td>${{ number_format($shipping_cost ?? 0, 2) }}</td>
        <td></td>
        @if ($hasAssemble)<td></td>@endif
        <td></td>
    </tr>
@endif
<tr>
    <th colspan="2">{{ $totalLabel }} (<span class="note_charges">Excluding Sales Tax And Payment Charges</span>)</th>
    <td></td>
    <td>{{ number_format($sub_total_weight ?? 0, 0) }} lbs</td>
    <td></td>
    <td>$<span id="sc-display-order-total">{{ number_format($grandDisplay, 2) }}</span></td>
    <td></td>
    @if ($hasAssemble)<td></td>@endif
    <td></td>
</tr>
