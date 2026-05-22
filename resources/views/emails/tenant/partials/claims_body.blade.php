@php
    $claims = $claims_data ?? [];
    $products = $claims['claims_product_val'] ?? [];
    $userModel = $claims['user'] ?? null;
@endphp
<p><strong>Job name:</strong> {{ $claims['job_name'] ?? '—' }}</p>
<p><strong>Order ID:</strong> {{ $claims['claims_order_id'] ?? '—' }}</p>
@if ($userModel)
    <p><strong>Customer:</strong> {{ $userModel->name ?? '' }} ({{ $userModel->email ?? '' }})</p>
@endif

<table cellpadding="6" cellspacing="0" border="1" style="border-collapse:collapse;width:100%;font-size:13px;">
    <thead>
        <tr style="background:#f1f5f9;">
            <th>Room</th>
            <th>SKU</th>
            <th>Description</th>
            <th>Weight</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $line)
            <tr>
                <td>{{ $line['room'] ?? '—' }}</td>
                <td>{{ $line['sku'] ?? '—' }}</td>
                <td>{{ $line['product_description'] ?? $line['product_name'] ?? '—' }}</td>
                <td>{{ $line['weight'] ?? 0 }} lbs</td>
                <td>${{ number_format((float) ($line['cost'] ?? 0), 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@if (! empty($claims['claims_order_message']))
    <p style="margin-top:12px;"><strong>Message:</strong> {{ $claims['claims_order_message'] }}</p>
@endif
