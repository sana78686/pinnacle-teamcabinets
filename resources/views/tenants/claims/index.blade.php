@extends('layouts.tenant.master')
@section('title', 'Claims')

@section('breadcrumb-title')
    <h2>Claims <span>List</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Claims</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="p-2 mt-0 card-header no-border d-flex flex-wrap gap-2 align-items-center">
        <a href="{{ route('tenant_claim_create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Create Claim
        </a>
        @if ($isAdmin ?? false)
            <a href="{{ route('tenant_deleted_claim_list') }}" class="btn btn-success btn-sm">Restore Claims</a>
        @endif
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm"><i class="fa fa-refresh"></i> Refresh</a>
    </div>

    @include('partials.tc-list-toolbar', [
        'listUrl' => route('tenant_claim_index'),
        'perPage' => $perPage,
        'search' => $search,
    ])

    <div class="table-responsive table-sm tc-admin-datatable">
        <table class="table table-striped table-bordered table-sm mb-0">
            <thead>
                <tr>
                    <th>Id</th>
                    @if ($isAdmin ?? false)
                        <th>Representative</th>
                    @endif
                    <th>Order Id</th>
                    <th>Claims Message</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($claims as $claim)
                    <tr class="{{ tenant_admin_unviewed_row_class($claim) }}">
                        <td>{{ $claim->id }}</td>
                        @if ($isAdmin ?? false)
                            <td>{{ app(\App\Services\ClaimWorkspaceService::class)->representativeNameFor($claim) }}</td>
                        @endif
                        <td>{{ $claim->claims_order_id }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($claim->claims_order_message, 80) }}</td>
                        <td>{{ $claim->claimant?->name ?? '—' }}</td>
                        <td>{{ $claim->created_at?->format('M j, Y') ?? '—' }}</td>
                        <td class="text-nowrap">
                            <a href="{{ route('tenant_claim_show', $claim->id) }}">View</a>
                            @if ($isAdmin ?? false)
                                | <form method="post" action="{{ route('tenant_claim_destroy', $claim->id) }}" class="d-inline"
                                    onsubmit="return confirm('Delete this claim?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link btn-sm p-0 text-danger">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ ($isAdmin ?? false) ? 7 : 6 }}" class="text-center text-muted">No claims yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-2">{{ $claims->links() }}</div>
@endsection
