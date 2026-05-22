@extends('layouts.tenant.master')
@section('title', 'Create Claim')

@section('breadcrumb-title')
    <h2>Create <span>Claim</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_claim_index') }}">Claims</a></li>
    <li class="breadcrumb-item active">Create</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="tc-card p-4">
        <p class="text-muted">Select a paid/completed order, then open it and use the <strong>Claim</strong> button to choose products and attach photos (CI workflow).</p>

        @if ($orders->isEmpty())
            <div class="alert alert-info mb-0">No eligible orders found. Place and pay for an order first.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Order #</th>
                            <th>Job name</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->job_name }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ $order->created_at?->format('M j, Y') }}</td>
                                <td>
                                    <a href="{{ route('tenant_order_show', $order->id) }}" class="btn btn-primary btn-sm">Open &amp; claim</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
