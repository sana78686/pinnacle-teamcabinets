@extends('layouts.tenant.master')
@section('title', 'Claim Details')

@section('breadcrumb-title')
    <h2>Claim <span>Details</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_claim_index') }}">Claims</a></li>
    <li class="breadcrumb-item active">View</li>
@endsection

@section('content')
    @include('partial.message')

    @php $claimService = app(\App\Services\ClaimWorkspaceService::class); @endphp

    <div class="mb-3">
        <a href="{{ route('tenant_claim_index') }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
        <a href="{{ route('tenant_order_show', $claim->claims_order_id) }}" class="btn btn-outline-primary btn-sm">View order #{{ $claim->claims_order_id }}</a>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-6">
            <div class="tc-card p-3">
                <h6 class="fw-semibold">Claim information</h6>
                <p class="mb-1"><strong>Claim ID:</strong> {{ $claim->id }}</p>
                <p class="mb-1"><strong>Order ID:</strong> {{ $claim->claims_order_id }}</p>
                <p class="mb-1"><strong>Job name:</strong> {{ $order?->job_name ?? '—' }}</p>
                <p class="mb-1"><strong>Submitted by:</strong> {{ $claim->claimant?->name ?? '—' }}</p>
                @if ($isAdmin ?? false)
                    <p class="mb-1"><strong>Representative:</strong> {{ $repName }}</p>
                @endif
                <p class="mb-0"><strong>Date:</strong> {{ $claim->created_at?->format('M j, Y g:i A') }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="tc-card p-3">
                <h6 class="fw-semibold">Message</h6>
                <p class="mb-0">{{ $claim->claims_order_message }}</p>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-sm">
            <thead class="table-secondary">
                <tr>
                    <th>Room</th>
                    <th>SKU</th>
                    <th>Description</th>
                    <th>Weight</th>
                    <th>Price</th>
                    <th>Photos</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($claim->claims_product_val ?? [] as $line)
                    <tr>
                        <td>{{ $line['room'] ?? '—' }}</td>
                        <td>{{ $line['sku'] ?? '—' }}</td>
                        <td>{{ $line['product_description'] ?? $line['product_name'] ?? '—' }}</td>
                        <td>{{ $line['weight'] ?? 0 }} lbs</td>
                        <td>${{ number_format((float) ($line['cost'] ?? 0), 2) }}</td>
                        <td>
                            @php
                                $imgs = array_filter(explode(',', (string) ($line['image'] ?? '')));
                            @endphp
                            @forelse ($imgs as $img)
                                @php $url = $claimService->claimImageUrl(trim($img)); @endphp
                                @if ($url)
                                    <a href="{{ $url }}" target="_blank" rel="noopener" class="d-inline-block me-1">
                                        <img src="{{ $url }}" alt="" style="max-height:48px;border-radius:4px;">
                                    </a>
                                @endif
                            @empty
                                —
                            @endforelse
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
