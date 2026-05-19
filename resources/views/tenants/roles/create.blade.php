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

                <!-- Permissions Section -->
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="mt-2 form-group">
                        <h5>Permissions:</h5>
                        <br />

                        <!-- Loop through each group of permissions (modules) -->
                        @foreach ($permissions as $module => $permissionsGroup)
                            <div class="mb-4 module-group">
                                <!-- Module Title with Select All checkbox -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6>{{ ucfirst($module) }}</h6>

                                    <!-- Select All checkbox for the current module -->
                                    <label>
                                        <input type="checkbox" class="select-all-checkbox"
                                            data-module="{{ $module }}">
                                        Select All
                                    </label>
                                </div>
                                <hr>

                                <div class="row">
                                    <!-- Loop through the permissions within this module -->
                                    @foreach ($permissionsGroup as $permission)
                                        <div class="col-xs-6 col-sm-4 col-md-3">
                                            <label>
                                                <input type="checkbox" name="permission[{{ $permission->id }}]"
                                                    value="{{ $permission->id }}" class="name permission-checkbox"
                                                    data-module="{{ $module }}" data-toggle="tooltip"
                                                    data-placement="top"
                                                    title="Allow this role to have the permission: {{ $permission->name }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
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
    <script>
        $(document).ready(function() {
                    // Initialize Bootstrap tooltips
                    $('[data-toggle="tooltip"]').tooltip();

                        // When the 'Select All' checkbox is clicked for a module
                        $('.select-all-checkbox').on('change', function() {
                            var module = $(this).data('module'); // Get the module name
                            var isChecked = $(this).prop('checked'); // Check if the 'Select All' checkbox is checked

                            // Check or uncheck all checkboxes in the module based on the 'Select All' checkbox
                            $('input[name^="permission"][data-module="' + module + '"]').prop('checked', isChecked);
                        });

                        // Optional: If any checkbox is unchecked, uncheck the 'Select All' checkbox
                        $('.permission-checkbox').on('change', function() {
                            var module = $(this).data('module');
                            var allChecked = $('input[name^="permission"][data-module="' + module + '"]').length ===
                                $('input[name^="permission"][data-module="' + module + '"]:checked').length;

                            // If all checkboxes for a module are checked, check the 'Select All' checkbox
                            $('input.select-all-checkbox[data-module="' + module + '"]').prop('checked', allChecked);
                        });
                    });
    </script>
@endsection
