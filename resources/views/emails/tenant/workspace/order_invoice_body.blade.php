@php
    $rooms = json_decode($cartData['room_data'] ?? '{}', true) ?: [];
    $t = $totals ?? [];
@endphp
<p><strong>Job:</strong> {{ $cartData['job_name'] ?? $order->job_name }}</p>
@if (! empty($order->comment))
    <p><strong>Comment:</strong> {{ $order->comment }}</p>
@endif
<table border="1" cellpadding="6" cellspacing="0" width="100%" style="border-collapse:collapse;font-size:13px;">
    <thead>
        <tr style="background:#f0f0f0;">
            <th>Room / Product</th>
            <th>Qty</th>
            <th>Unit</th>
            <th>Line total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($rooms as $roomName => $room)
            <tr><td colspan="4"><strong>{{ $roomName }}</strong></td></tr>
            @php $n = count($room['product_sku'] ?? []); @endphp
            @for ($i = 0; $i < $n; $i++)
                <tr>
                    <td>{{ $room['product_name'][$i] ?? $room['product_sku'][$i] }}</td>
                    <td>{{ $room['product_quantity'][$i] ?? 1 }}</td>
                    <td>${{ number_format((float) ($room['product_cost'][$i] ?? 0), 2) }}</td>
                    <td>${{ number_format((float) ($room['product_cost'][$i] ?? 0) * (int) ($room['product_quantity'][$i] ?? 1), 2) }}</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
<p>
    <strong>Subtotal:</strong> ${{ number_format((float) ($order->sub_total_cost ?? 0), 2) }}<br>
    <strong>Fuel ({{ $t['fuel_percent'] ?? 0 }}%):</strong> ${{ number_format((float) ($t['fuel_amount'] ?? 0), 2) }}<br>
    @if ((float) ($order->sub_total_assemble_cost ?? 0) > 0)
        <strong>Assembly:</strong> ${{ number_format((float) $order->sub_total_assemble_cost, 2) }}<br>
    @endif
    <strong>Sales tax ({{ $t['sales_tax_percent'] ?? 0 }}%):</strong> ${{ number_format((float) ($t['sales_tax_amount'] ?? 0), 2) }}<br>
    @if ((float) ($t['credit_card_charges'] ?? 0) > 0)
        <strong>Card fee:</strong> ${{ number_format((float) $t['credit_card_charges'], 2) }}<br>
    @endif
    @if ((float) ($t['ach_charges'] ?? 0) > 0)
        <strong>ACH fee:</strong> ${{ number_format((float) $t['ach_charges'], 2) }}<br>
    @endif
    <strong>Order total:</strong> ${{ number_format((float) ($order->grand_total_cost ?? $t['grand_total'] ?? 0), 2) }}
</p>
