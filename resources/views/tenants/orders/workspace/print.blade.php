@extends('layouts.tenant.standalone')

@section('title', 'Print Order')

@section('content')
@php
    $bill = $billUser ?? $order->user;
    $ship = $shipUser ?? $order->user;
    $formatAddress = function ($user) {
        if (! $user) {
            return '';
        }
        $parts = array_filter([
            $user->address,
            $user->city_name ?? $user->city?->name,
            $user->state?->name ?? $user->state_name,
            $user->zip_code,
            $user->country_name ?? $user->country,
        ]);

        return implode(', ', $parts);
    };
    $allTotal = 0.0;
    $allActual = 0.0;
    $allWeight = 0.0;
@endphp
<div class="container-fluid ow-print-page py-3" id="ow-print-page">
    <div class="row mb-3">
        <div class="col-md-4">
            <h3 class="h5 font-weight-bold mb-1">TEAM DISTRIBUTORS</h3>
            <p class="mb-0 small">152 Baywood Ave</p>
            <p class="mb-0 small">Longwood, FL 32750</p>
            <p class="mb-0 small">+1 8337822697</p>
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ asset('assets/front_site_assets/images/logo_email.jpg') }}" alt="Team Cabinets" style="max-height:100px;">
        </div>
        <div class="col-md-4 text-md-right">
            <p class="mb-0 small">team@teamcabinets.com</p>
            <p class="mb-0 small">www.teamcabinets.com</p>
        </div>
    </div>

    <h3 class="h5 font-weight-bold mb-3">QUOTE</h3>

    <div class="row mb-3">
        <div class="col-md-4">
            <h4 class="h6 font-weight-bold">Bill To</h4>
            <p class="mb-0 small"><strong>Name:</strong> {{ $bill?->name ?? '—' }}</p>
            <p class="mb-0 small"><strong>Address:</strong> {{ $formatAddress($bill) ?: '—' }}</p>
            <p class="mb-0 small"><strong>Email:</strong> {{ $bill?->email ?? '—' }}</p>
            <p class="mb-0 small"><strong>Phone:</strong> {{ $bill?->phone ?? $bill?->cell_phone ?? '—' }}</p>
        </div>
        <div class="col-md-4">
            <h4 class="h6 font-weight-bold">Ship To</h4>
            <p class="mb-0 small"><strong>Name:</strong> {{ $ship?->name ?? '—' }}</p>
            <p class="mb-0 small"><strong>Address:</strong> {{ $formatAddress($ship) ?: '—' }}</p>
            <p class="mb-0 small"><strong>Email:</strong> {{ $ship?->email ?? '—' }}</p>
            <p class="mb-0 small"><strong>Phone:</strong> {{ $ship?->phone ?? $ship?->cell_phone ?? '—' }}</p>
        </div>
        <div class="col-md-4">
            <p class="mb-0 small"><strong>Quote Name:</strong> —</p>
            <p class="mb-0 small"><strong>Date:</strong> {{ now()->format('m-d-Y') }}</p>
            <p class="mb-0 small"><strong>Job Name:</strong> {{ $order->job_name }}</p>
        </div>
    </div>

    <table class="table table-bordered table-sm ow-print-table">
        <thead class="thead-light">
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th class="text-right">Weight</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->rooms ?? [] as $room)
                @foreach ($room['products'] ?? [] as $line)
                    @php
                        $qty = max(1, (int) ($line['quantity'] ?? 1));
                        $unit = (float) ($line['cost'] ?? 0);
                        $actual = (float) ($line['cost1'] ?? $unit);
                        $weight = (float) ($line['weight'] ?? 0);
                        $sku = $line['sku'] ?? '';
                        $label = $line['label'] ?? '';
                        $desc = $line['description'] ?? ($sku.' - '.$label);
                        $color = $line['product_color'] ?? $order->product_img_name ?? '';
                        $allTotal += $unit * $qty;
                        $allActual += $actual * $qty;
                        $allWeight += $weight * $qty;
                    @endphp
                    <tr>
                        <td>{{ $sku }}@if($color) - {{ $color }}@endif</td>
                        <td>{{ $desc }}</td>
                        <td class="text-right">{{ number_format($weight, 2) }} lbs</td>
                        <td class="text-right">{{ $qty }}</td>
                        <td class="text-right">${{ number_format($unit, 2) }}</td>
                        <td class="text-right">${{ number_format($unit * $qty, 2) }}</td>
                    </tr>
                @endforeach
            @endforeach
            @php $discount = max(0, $allActual - $allTotal); @endphp
            @if ($discount > 0.009)
                <tr>
                    <td>Discount Amount</td>
                    <td>Dealer Discount</td>
                    <td class="text-right">{{ number_format($allWeight, 2) }} lbs</td>
                    <td class="text-right">1</td>
                    <td class="text-right">-${{ number_format($discount, 2) }}</td>
                    <td class="text-right">-${{ number_format($discount, 2) }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="row mt-3">
        <div class="col-md-6">
            @if ($order->comment)
                <p class="mb-0 small"><strong>Comment:</strong> {{ $order->comment }}</p>
            @endif
        </div>
        <div class="col-md-6 text-md-right">
            <p class="mb-0"><strong>Total Weight:</strong> {{ number_format($allWeight, 2) }} lbs</p>
            <p class="mb-0"><strong>Total:</strong> ${{ number_format($allTotal, 2) }}</p>
        </div>
    </div>

    <div class="ow-print-actions mt-3 d-print-none">
        <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">Print</button>
        <button type="button" class="btn btn-light btn-sm" onclick="window.close()">Close</button>
    </div>
</div>
@endsection

@section('style')
<style>
@page { size: A4; margin: 12mm; }
@media print {
    .ow-print-actions { display: none !important; }
}
.ow-print-table th, .ow-print-table td { font-size: 12px; vertical-align: top; }
</style>
@endsection

@section('script')
<script>window.addEventListener('load', function () { window.print(); });</script>
@endsection
