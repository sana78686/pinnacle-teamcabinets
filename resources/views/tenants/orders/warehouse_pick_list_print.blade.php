<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Pick List — Order #{{ $order->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        td, th { border: 1px solid #999; padding: 4px 8px; text-align: left; }
        h2, h4 { margin: 8px 0; }
        @media print { .no-print { display: none !important; } }
    </style>
</head>
<body onload="window.print()">
    <h2>Warehouse Pick List — Order #{{ $order->id }}</h2>
    <p>
        Customer: {{ $order->user?->name ?? $order->user_email ?? '—' }}
        | Date: {{ $order->created_at?->format('m/d/Y') }}
        | Job: {{ $order->job_name }}
    </p>

    @foreach ($pickRooms as $room)
        <h4>Room: {{ $room['room_name'] }}</h4>
        <table>
            <thead>
                <tr>
                    <th>SKU</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>Color / Style</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($room['lines'] as $line)
                    <tr>
                        <td>{{ $line['sku'] }}</td>
                        <td>{{ $line['description'] }}</td>
                        <td>{{ $line['qty'] }}</td>
                        <td>{{ $line['color'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    @if (! $order->is_picked)
        <form method="post" action="{{ route('tenant_order_warehouse_pick_print', $order->id) }}" class="no-print">
            @csrf
            <button type="submit">Confirm Picked</button>
        </form>
    @else
        <p class="no-print"><strong>Picked:</strong> {{ $order->picked_at?->format('m/d/Y g:i A') }}</p>
    @endif
</body>
</html>
