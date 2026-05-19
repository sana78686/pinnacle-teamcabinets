@extends('layouts.mega.master')

@section('title', 'Roles')

@section('content')
@php
    $rolesCreateUrl = auth()->user()->can('role-create') ? route('roles.create') : null;
@endphp
<x-admin-list title="Roles Management" :create-url="$rolesCreateUrl" create-label="Create New Role">
    <div class="admin-table-wrap">
        <table class="table admin-table table-hover">
            <thead>
                <tr>
                    <th width="100">No</th>
                    <th>Name</th>
                    <th width="280">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($roles as $key => $role)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            <a class="btn btn-info btn-sm" href="{{ route('roles.show', $role->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                            @can('role-edit')
                                <a class="btn btn-primary btn-sm" href="{{ route('roles.edit', $role->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            @endcan
                            @can('role-delete')
                                <form method="POST" action="{{ route('roles.destroy', $role->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this role?')"><i class="fa-solid fa-trash"></i> Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr class="admin-table-empty">
                        <td colspan="3">No roles found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($roles->hasPages())
        <div class="mt-3">
            {!! $roles->links('pagination::bootstrap-5') !!}
        </div>
    @endif
</x-admin-list>
@endsection
