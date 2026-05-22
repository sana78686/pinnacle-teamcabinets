@extends('layouts.tenant.master')
@section('title', 'Roles')

@section('breadcrumb-title')
    <h2>Role <span>List</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Role</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="card tc-dash-card mb-3">
        <div class="card-header d-flex flex-wrap align-items-center gap-2 py-2">
            <a href="{{ route('tenant_role_create') }}" class="btn btn-sm tc-pn-btn tc-pn-btn--navy">
                <i data-feather="plus" class="tc-btn-icon" aria-hidden="true"></i> Create role
            </a>
            <a href="{{ route('role.export') }}" class="btn btn-sm btn-light">Export</a>
            <button type="button" class="btn btn-sm btn-light" data-bs-toggle="modal" data-bs-target="#importRoleModal">Import</button>
        </div>

        <div class="card-body border-bottom py-3">
            @include('partials.tc-list-toolbar', [
                'listUrl' => route('tenant_role_index'),
                'perPage' => $perPage,
                'search' => $search,
                'searchPlaceholder' => 'Search roles by name…',
                'paginator' => $roles,
            ])
        </div>

        <div class="card-body p-0">
            <div class="table-responsive tc-admin-datatable">
                <table class="table table-striped table-bordered table-sm mb-0">
                    <thead>
                        <tr>
                            <th style="width:4rem">No</th>
                            <th>Name</th>
                            <th style="width:12rem">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            @php $isProtected = in_array($role->name, $protectedRoles ?? [], true); @endphp
                            <tr>
                                <td>{{ $roles->firstItem() + $loop->index }}</td>
                                <td>
                                    {{ $role->name }}
                                    @if ($isProtected)
                                        <span class="badge bg-secondary ms-1">System</span>
                                    @endif
                                </td>
                                <td class="text-nowrap">
                                    <a href="{{ route('tenant_role_show', $role->id) }}" class="tc-admin-datatable__edit">View</a>
                                    <span class="text-muted mx-1">|</span>
                                    <a href="{{ route('tenant_role_edit', $role->id) }}" class="tc-admin-datatable__edit">Edit</a>
                                    @unless ($isProtected)
                                        <span class="text-muted mx-1">|</span>
                                        <form method="post" action="{{ route('tenant_role_destroy', $role->id) }}" class="d-inline"
                                            onsubmit="return confirm('Delete this role?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link btn-sm p-0 text-danger align-baseline">Delete</button>
                                        </form>
                                    @endunless
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    @if ($search !== '')
                                        No roles match your search.
                                    @else
                                        No roles found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if ($roles->total() > 0)
            <div class="card-footer py-2">
                @include('partials.tenant-pagination', ['paginator' => $roles])
            </div>
        @endif
    </div>

    <div class="modal fade" id="importRoleModal" tabindex="-1" aria-labelledby="importRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importRoleModalLabel">Import roles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('role.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="roleFile" class="form-label">Select file</label>
                            <input type="file" class="form-control" id="roleFile" name="roleFile" required>
                        </div>
                        <button type="submit" class="btn btn-sm tc-pn-btn tc-pn-btn--navy">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ $panelAsset('js/tenant-list-filter.js') }}?v=1"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.feather) feather.replace();
        });
    </script>
@endsection
