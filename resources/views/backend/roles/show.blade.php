@extends('layouts.mega.master')

@section('title', 'View Role')

@section('content')
<x-admin-form-shell title="Role Details" :back-url="route('roles.index')" back-label="Back to roles">
    <div class="row">
        <div class="col-12 mb-3">
            <strong>Name</strong>
            <p class="mb-0">{{ $role->name }}</p>
        </div>
        <div class="col-12 mb-3">
            <strong>Permissions</strong>
            <p class="mb-0">
                @forelse ($rolePermissions as $permission)
                    <span class="badge bg-info text-dark">{{ $permission->name }}</span>
                @empty
                    <span class="text-muted">No permissions assigned</span>
                @endforelse
            </p>
        </div>
        <div class="col-12">
            @can('role-edit')
                <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
            @endcan
        </div>
    </div>
</x-admin-form-shell>
@endsection
