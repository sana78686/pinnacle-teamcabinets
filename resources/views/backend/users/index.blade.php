@extends('layouts.mega.master')

@section('title', 'Users')

@section('content')
@php $usersCreateUrl = auth()->user()->can('user-create') ? route('users.create') : null; @endphp
<x-admin-list title="User Management" :create-url="$usersCreateUrl" create-label="Create New User">
    <div class="admin-table-wrap">
        <table class="table admin-table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th width="280">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $key => $user)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if (!empty($user->getRoleNames()))
                                @foreach ($user->getRoleNames() as $v)
                                    <span class="badge bg-success">{{ $v }}</span>
                                @endforeach
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @can('user-list')
                                <a class="btn btn-info btn-sm" href="{{ route('users.show', $user->id) }}"><i class="fa-solid fa-list"></i> Show</a>
                            @endcan
                            @can('user-edit')
                                <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            @endcan
                            @can('user-delete')
                                <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Delete this user?')"><i class="fa-solid fa-trash"></i> Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr class="admin-table-empty">
                        <td colspan="5">No users found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($users->hasPages())
        <div class="mt-3">
            {!! $users->links('pagination::bootstrap-5') !!}
        </div>
    @endif
</x-admin-list>
@endsection
