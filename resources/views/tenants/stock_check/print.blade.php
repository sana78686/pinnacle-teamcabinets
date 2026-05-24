<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Check #{{ $stock_check_request->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 20px;
        }

        h1 {
            font-size: 20px;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background: #f5f5f5;
        }

        .meta {
            margin-bottom: 12px;
        }
    </style>
</head>

<body onload="window.print()">
    <h1>Stock Check Request #{{ $stock_check_request->id }}</h1>
    <div class="meta">
        <div><strong>Bill To:</strong> {{ $stock_check_request->billToName() }}</div>
        <div><strong>Job:</strong> {{ $stock_check_request->job_name }}</div>
        <div><strong>Created:</strong> {{ $stock_check_request->created_at?->format('Y-m-d H:i:s') }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Room</th>
                <th>Product</th>
                <th>Description</th>
                <th>Qty</th>
                <th>Unit Weight</th>
                <th>Total Weight</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lines as $line)
                <tr>
                    <td>{{ $line['room_name'] }}</td>
                    <td>{{ $line['sku'] }}</td>
                    <td>{{ $line['description'] }}</td>
                    <td>{{ $line['quantity'] }}</td>
                    <td>{{ number_format((float) ($line['weight'] ?? 0), 2) }} lbs</td>
                    <td>{{ number_format((float) ($line['total_weight'] ?? (($line['weight'] ?? 0) * ($line['quantity'] ?? 1))), 2) }} lbs</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5">Total Weight</th>
                <td>{{ number_format((float) $stock_check_request->sub_total_weight, 2) }} lbs</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>
