@extends('layouts.tenant.master')
@section('title', 'Role Menu')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2> Create<span>Role </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Role</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')

    <div class="m-2 card-body">

        <form method="POST" action="{{ route('tenant_role_store') }}">
            @csrf
            <div class="row">
                <!-- Role Name Field -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                        <input type="text" name="name" placeholder="Enter Role Name" class="form-control"
                            data-toggle="tooltip" data-placement="top"
                            title="Provide a unique name for the role (e.g., Admin, Editor)">
                    </div>
                </div>

                <div class="col-12">
                    @include('tenants.roles.partials.permission-checkboxes', [
                        'permissions' => $permissions,
                        'rolePermissions' => [],
                    ])
                </div>

                <!-- Submit Button -->
                <div class="text-center col-xs-12 col-sm-12 col-md-12">
                    <button type="submit" class="mb-3 btn btn-primary btn-sm">
                        <i class="fa-solid fa-floppy-disk"></i> Create Role
                    </button>
                </div>
            </div>
        </form>





    </div>



@endsection

@section('script')
    @include('tenants.roles.partials.permission-checkboxes-script')
@endsection
