@php
    $d = $email_data ?? [];
    $roomsRaw = json_decode($d['room_data'] ?? '[]', true);
    if (! is_array($roomsRaw)) {
        $roomsRaw = [];
    }
    $isCiShape = ! isset($roomsRaw[0]['room_name']);
@endphp
<table cellpadding="6" cellspacing="0" width="100%" style="font-family:Arial,sans-serif;font-size:13px;border-collapse:collapse;">
    <tr>
        <td colspan="2"><strong>Job:</strong> {{ $d['job_name'] ?? '' }}</td>
        <td><strong>Reference #:</strong> {{ $d['ship_quote_id'] ?? '' }}</td>
    </tr>
    <tr>
        <td><strong>Bill to:</strong> {{ $d['bill_to_name'] ?? '' }}<br>{{ $d['bill_to_email'] ?? '' }}</td>
        <td colspan="2"><strong>Ship to:</strong> {{ $d['ship_to_name'] ?? '' }}<br>{{ $d['ship_to_address'] ?? '' }}, {{ $d['ship_to_city'] ?? '' }}</td>
    </tr>
</table>
<table cellpadding="6" cellspacing="0" width="100%" style="margin-top:12px;font-family:Arial,sans-serif;font-size:12px;border:1px solid #ddd;">
    <thead style="background:#f5f5f5;">
        <tr>
            <th>Room / SKU</th>
            <th>Description</th>
            <th align="right">Qty</th>
            <th align="right">Line</th>
        </tr>
    </thead>
    <tbody>
        @if ($isCiShape)
            @foreach ($roomsRaw as $roomName => $room)
                <tr><td colspan="4" style="background:#eef2f7;font-weight:bold;">{{ $roomName }}</td></tr>
                @php $count = count($room['product_sku'] ?? []); @endphp
                @for ($i = 0; $i < $count; $i++)
                    <tr>
                        <td>{{ $room['product_sku'][$i] ?? '' }}</td>
                        <td>{{ $room['product_cabinets_description'][$i] ?? '' }}</td>
                        <td align="right">{{ $room['product_quantity'][$i] ?? 1 }}</td>
                        <td align="right">${{ number_format((float) (($room['product_cost'][$i] ?? 0) * ($room['product_quantity'][$i] ?? 1)), 2) }}</td>
                    </tr>
                @endfor
            @endforeach
        @else
            @foreach ($roomsRaw as $room)
                <tr><td colspan="4" style="background:#eef2f7;font-weight:bold;">{{ $room['room_name'] ?? 'Room' }}</td></tr>
                @foreach ($room['products'] ?? [] as $line)
                    @php
                        $product = \App\Models\Product::find($line['product_id'] ?? 0);
                        $unit = (float) ($line['cost'] ?? 0);
                        if ($unit <= 0 && $product) {
                            $unit = (float) preg_replace('/[^\d.]/', '', (string) $product->cost);
                        }
                        $qty = (int) ($line['quantity'] ?? 1);
                    @endphp
                    <tr>
                        <td>{{ $line['sku'] ?? $product?->sku ?? ('#'.$line['product_id']) }}</td>
                        <td>{{ $line['label'] ?? $product?->label ?? '' }}</td>
                        <td align="right">{{ $qty }}</td>
                        <td align="right">${{ number_format($unit * $qty, 2) }}</td>
                    </tr>
                @endforeach
            @endforeach
        @endif
    </tbody>
</table>
<table cellpadding="6" cellspacing="0" width="100%" style="margin-top:12px;font-family:Arial,sans-serif;font-size:13px;">
    <tr><td align="right"><strong>Cart subtotal</strong></td><td align="right" width="120">${{ number_format((float) ($d['all_cart_total'] ?? 0), 2) }}</td></tr>
    @if (($d['delivery_cost'] ?? 0) > 0)
        <tr><td align="right">Delivery ({{ ($d['delivery_type'] ?? 0) == 1 ? 'Commercial' : 'Residential' }})</td><td align="right">${{ number_format((float) $d['delivery_cost'], 2) }}</td></tr>
    @endif
    @if (($d['liftgate_cost'] ?? 0) > 0)
        <tr><td align="right">Liftgate</td><td align="right">${{ number_format((float) $d['liftgate_cost'], 2) }}</td></tr>
    @endif
    @if (($d['unload_cost'] ?? 0) > 0)
        <tr><td align="right">Unload</td><td align="right">${{ number_format((float) $d['unload_cost'], 2) }}</td></tr>
    @endif
    @if (($d['shipping_cost'] ?? 0) > 0)
        <tr><td align="right"><strong>Estimated shipping</strong></td><td align="right"><strong>${{ number_format((float) $d['shipping_cost'], 2) }}</strong></td></tr>
    @endif
</table>
