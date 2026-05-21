@extends('layouts.tenant.master')

@section('title', 'Print Order')

@section('content')
<div class="container-fluid ow-print-page">
    <div class="tc-card p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Order #{{ $order->id }}</h1>
            <button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
        </div>
        <p><strong>Job name:</strong> {{ $order->job_name }}</p>
        <p><strong>Total:</strong> ${{ number_format((float) $order->grand_total_cost, 2) }}</p>
        <p><strong>Weight:</strong> {{ $order->sub_total_weight }}</p>
        @if ($order->comment)
            <p><strong>Comment:</strong> {{ $order->comment }}</p>
        @endif
        @foreach ($order->rooms ?? [] as $room)
            <h5 class="mt-3">{{ $room['room_name'] ?? 'Room' }}</h5>
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($room['products'] ?? [] as $line)
                        <tr>
                            <td>#{{ $line['product_id'] ?? '' }}</td>
                            <td>{{ $line['quantity'] ?? 1 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
</div>
@endsection

@section('style')
<style>@media print { .tc-chrome, .btn { display: none !important; } }</style>
@endsection
