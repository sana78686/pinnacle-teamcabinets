@extends('layouts.tenant.master')
@section('title', 'Edit Role')

@section('breadcrumb-title')
    <h2>Edit <span>Role</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('tenant_role_index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Edit</li>
@endsection

@section('content')
    @include('partial.message')

    <div class="card tc-dash-card p-3 p-md-4">
        <form method="POST" action="{{ route('tenant_role_update', $role->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label" for="role_name">Role name</label>
                @if ($isProtected ?? false)
                    <input type="text" id="role_name" class="form-control" value="{{ $role->name }}" readonly>
                    <input type="hidden" name="name" value="{{ $role->name }}">
                    <small class="text-muted">System role names cannot be changed.</small>
                @else
                    <input type="text" name="name" id="role_name" class="form-control" value="{{ old('name', $role->name) }}" required>
                @endif
            </div>

            @include('tenants.roles.partials.permission-checkboxes', [
                'permissions' => $permissions,
                'rolePermissions' => $rolePermissions,
            ])

            <div class="d-flex flex-wrap gap-2 mt-4">
                <button type="submit" class="btn btn-sm tc-pn-btn tc-pn-btn--navy">Save permissions</button>
                <a href="{{ route('tenant_role_index') }}" class="btn btn-sm btn-light">Cancel</a>
            </div>
        </form>
    </div>
@endsection

@section('script')
    @include('tenants.roles.partials.permission-checkboxes-script')
@endsection
