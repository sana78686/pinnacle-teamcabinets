@extends('layouts.tenant.master')
@section('title', 'Deleted Claims')

@section('breadcrumb-title')
    <h2>Restore <span>Claims</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_claim_index') }}">Claims</a></li>
    <li class="breadcrumb-item active">Deleted</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="mb-2">
        <a href="{{ route('tenant_claim_index') }}" class="btn btn-light btn-sm">Back to claims</a>
    </div>

        <div class="table-responsive table-sm">
        <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                    <th>Id</th>
                    <th>Order Id</th>
                    <th>Message</th>
                    <th>User</th>
                    <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($claims as $claim)
                    <tr>
                        <td>{{ $claim->id }}</td>
                        <td>{{ $claim->claims_order_id }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($claim->claims_order_message, 60) }}</td>
                        <td>{{ $claim->claimant?->name ?? '—' }}</td>
                        <td>
                            <a href="{{ route('tenant_claim_restore', $claim->id) }}" class="btn btn-success btn-sm"
                                onclick="return confirm('Restore this claim?');">Restore</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No deleted claims.</td></tr>
                @endforelse
                </tbody>
            </table>
    </div>
    {{ $claims->links() }}
@endsection
