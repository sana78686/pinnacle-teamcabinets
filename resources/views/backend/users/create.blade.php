@extends('layouts.mega.master')

@section('title', 'Create User')

@section('content')
<x-admin-form-shell title="Create User" :back-url="route('users.index')" back-label="Back to users">
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label"><strong>Name</strong> <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label"><strong>Email</strong> <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label"><strong>Password</strong> <span class="text-danger">*</span></label>
                <input type="password" name="password" class="form-control" required minlength="8">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label"><strong>Confirm password</strong> <span class="text-danger">*</span></label>
                <input type="password" name="confirm-password" class="form-control" required minlength="8">
            </div>
            <div class="col-12 mb-3">
                <label class="form-label"><strong>Roles</strong> <span class="text-danger">*</span></label>
                <select name="roles[]" class="form-control" multiple required size="6">
                    @foreach ($roles as $roleName => $label)
                        <option value="{{ $roleName }}" @selected(collect(old('roles', []))->contains($roleName))>{{ $label }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple roles.</small>
            </div>
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Create user</button>
            </div>
        </div>
    </form>
</x-admin-form-shell>
@endsection
