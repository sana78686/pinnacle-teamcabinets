@extends('layouts.mega.master')

@section('title', 'View User')

@section('content')
<x-admin-form-shell title="User Details" :back-url="route('users.index')" back-label="Back to users">
    <div class="row">
        <div class="col-md-6 mb-3">
            <strong>Name</strong>
            <p class="mb-0">{{ $user->name }}</p>
        </div>
        <div class="col-md-6 mb-3">
            <strong>Email</strong>
            <p class="mb-0">{{ $user->email }}</p>
        </div>
        <div class="col-12 mb-3">
            <strong>Roles</strong>
            <p class="mb-0">
                @forelse ($user->getRoleNames() as $role)
                    <span class="badge bg-success">{{ $role }}</span>
                @empty
                    <span class="text-muted">No roles assigned</span>
                @endforelse
            </p>
        </div>
        <div class="col-12">
            @can('user-edit')
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
            @endcan
        </div>
    </div>
</x-admin-form-shell>
@endsection
