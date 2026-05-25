@extends('layouts.tenant.standalone')

@section('title', 'Print Order')

@section('content')
@php
    $bill = $billUser ?? $order->user;
    $ship = $shipUser ?? $order->user;
    $billAddress = $formattedAddress ?? ($bill ? app(\App\Services\OrderWorkspaceService::class)->formatUserAddress($bill) : '');
    $shipAddress = $billAddress;
    $allTotal = 0.0;
    $allActual = 0.0;
    $allWeight = 0.0;
@endphp
<div class="container-fluid ow-print-page py-3" id="ow-print-page">
    @php
        $lh = $letterhead ?? [];
        $lhName = $lh['company_name'] ?? (tenant('company_name') ?? tenant('name') ?? '');
        $lhLogo = $lh['logo_url'] ?? tenant_brand_logo_url();
        $lhAddress = $lh['address_line'] ?? '';
        $lhPhone = $lh['phone'] ?? '';
        $lhEmail = $lh['email'] ?? '';
        $lhWebUrl = $lh['website_url'] ?? route('cms.page');
        $lhWebLabel = $lh['website_label'] ?? parse_url($lhWebUrl, PHP_URL_HOST);
    @endphp
    <div class="row mb-3">
        <div class="col-md-4">
            <h3 class="h5 font-weight-bold mb-1">{{ $lhName }}</h3>
            @if ($lhAddress !== '')
                <p class="mb-0 small">{{ $lhAddress }}</p>
            @endif
            @if ($lhPhone !== '')
                <p class="mb-0 small">{{ $lhPhone }}</p>
            @endif
        </div>
        <div class="col-md-4 text-center">
            <img src="{{ $lhLogo }}" alt="{{ $lhName }}" style="max-height:100px; max-width:100%;">
        </div>
        <div class="col-md-4 text-md-right">
            @if ($lhEmail !== '')
                <p class="mb-0 small"><a href="mailto:{{ $lhEmail }}">{{ $lhEmail }}</a></p>
            @endif
            <p class="mb-0 small"><a href="{{ $lhWebUrl }}" target="_blank" rel="noopener">{{ $lhWebLabel }}</a></p>
        </div>
    </div>

    <h3 class="h5 font-weight-bold mb-3">QUOTE</h3>

    <div class="row mb-3">
        <div class="col-md-4">
            <h4 class="h6 font-weight-bold">Bill To</h4>
            <p class="mb-0 small"><strong>Name:</strong> {{ $bill?->name ?? '—' }}</p>
            <p class="mb-0 small"><strong>Address:</strong> {{ $billAddress ?: '—' }}</p>
            <p class="mb-0 small"><strong>Email:</strong> {{ $bill?->email ?? '—' }}</p>
            <p class="mb-0 small"><strong>Phone:</strong> {{ $bill?->phone ?? $bill?->cell_phone ?? '—' }}</p>
        </div>
        <div class="col-md-4">
            <h4 class="h6 font-weight-bold">Ship To</h4>
            <p class="mb-0 small"><strong>Name:</strong> {{ $ship?->name ?? '—' }}</p>
            <p class="mb-0 small"><strong>Address:</strong> {{ $shipAddress ?: '—' }}</p>
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
