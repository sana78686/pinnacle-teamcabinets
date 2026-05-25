@extends('layouts.tenant.master')
@section('title', 'Warehouse Pick List')
@section('breadcrumb-title')
    <h2>Warehouse Pick List <span>#{{ $order->id }}</span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_order_list') }}">Orders</a></li>
    <li class="breadcrumb-item active">Pick List</li>
@endsection
@section('content')
    <div class="card tc-dash-card mb-3">
        <div class="card-body">
            <p class="mb-1"><strong>Customer:</strong> {{ $order->user?->name ?? $order->user_email ?? '—' }}</p>
            <p class="mb-1"><strong>Job:</strong> {{ $order->job_name }}</p>
            <p class="mb-3"><strong>Date:</strong> {{ $order->created_at?->format('m/d/Y') }}
                @if ($order->is_picked)
                    <span class="badge bg-success ms-2">Picked {{ $order->picked_at?->format('m/d/Y g:i A') }}</span>
                @endif
            </p>

            @forelse ($pickRooms as $room)
                <h5 class="mt-3">Room: {{ $room['room_name'] }}</h5>
                <div class="table-responsive table-sm">
                    <table class="table table-bordered table-sm mb-0">
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
                </div>
            @empty
                <p class="text-muted">No product lines found on this order.</p>
            @endforelse

            <div class="mt-4 d-flex flex-wrap gap-2">
                <form method="post" action="{{ route('tenant_order_warehouse_pick_print', $order->id) }}"
                    onsubmit="return confirm('Mark this order as picked and open print view?');">
                    @csrf
                    <button type="submit" class="btn btn-sm tc-pn-btn tc-pn-btn--navy">Print &amp; Mark Picked</button>
                </form>
                <a href="{{ route('tenant_order_show', $order->id) }}" class="btn btn-sm btn-light">View Order</a>
                <a href="{{ route('tenant_order_list') }}" class="btn btn-sm btn-outline-secondary">Back to Orders</a>
            </div>
        </div>
    </div>
@endsection
