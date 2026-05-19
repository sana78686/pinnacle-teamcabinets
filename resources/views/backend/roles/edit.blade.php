@extends('layouts.mega.master')

@section('title', 'Edit Role')

@section('content')
<x-admin-form-shell title="Edit Role" :back-url="route('roles.index')" back-label="Back to roles">
    <form method="POST" action="{{ route('roles.update', $role->id) }}">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-12 mb-3">
                <label class="form-label"><strong>Role name</strong> <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required>
            </div>
            <div class="col-12 mb-3">
                <label class="form-label"><strong>Permissions</strong> <span class="text-danger">*</span></label>
                <div class="row">
                    @foreach ($permission as $value)
                        <div class="col-md-4 col-lg-3 mb-2">
                            <label class="d-flex align-items-start gap-2">
                                <input type="checkbox" name="permission[]" value="{{ $value->id }}"
                                    @checked(collect(old('permission', array_keys($rolePermissions)))->contains($value->id))>
                                <span>{{ $value->name }}</span>
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Update role</button>
            </div>
        </div>
    </form>
</x-admin-form-shell>
@endsection
