@extends('layouts.tenant.master')
@section('title', 'User Menu')

@section('css')
@endsection

@section('style')
    <style>
        .column-toggle-dropdown {
            position: relative;
            display: inline-block;
        }

        .column-toggle-list {
            display: none;
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            padding: 10px;
            z-index: 100;
            width: 200px;
        }

        .column-toggle-list label {
            display: block;
            padding: 5px;
            cursor: pointer;
        }

        .column-toggle-dropdown button {
            padding: 6px 12px;
            cursor: pointer;
            border: 1px solid #ddd;
            background: #f8f9fa;
        }
    </style>
@endsection

@section('breadcrumb-title')
    <h2>User <span>List </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    @include('partials.tenant-users-door-factor-note')
    <div class="p-2 mt-0 card-header no-border">
        @include('partial.message')
        <a href="{{ route('tenant_user_create') }}" class="btn btn-sm tc-pn-btn tc-pn-btn--navy" data-toggle="tooltip"
            title="Create a new user in the system">
            <i class="icofont icofont-plus"></i> Create User
        </a>
        <a href="{{ route('tenant_deleted_users_list') }}" class="btn btn-sm tc-users-action-btn tc-users-action-btn--green" data-toggle="tooltip"
            title="Restore a previously deleted user">
            <i class="icofont icofont-spinner-alt-3"></i> Restore User
        </a>
        <a href="{{ url()->current() }}" class="btn btn-sm tc-pn-btn tc-pn-btn--outline" data-toggle="tooltip" title="Refresh this Page.">
            <i class="icofont icofont-refresh"></i> Refresh
        </a>
        <div class="pull-right">

            <a href="{{ route('users.export') }}" class="btn btn-sm tc-pn-btn tc-pn-btn--navy" data-toggle="tooltip"
                title="Export user data to a file">
                <i class="icofont icofont-upload-alt"></i> Export
            </a>

            <a href="#" class="btn btn-sm tc-users-action-btn tc-users-action-btn--amber btn-import" data-toggle="tooltip"
                title="Import user data from a file">
                <i class="icofont icofont-download-alt"></i> Import
            </a>
            <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="importModalLabel">Import User Data</h5>
                        </div>
                        <div class="modal-body">
                            <!-- Form to upload the file -->
                            <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf <!-- Add CSRF token for security -->
                                <div class="form-group">
                                    <label for="userFile">Select a file to import</label>
                                    <input type="file" class="form-control-file" id="userFile" name="userFile" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Import</button>
                                <a href="{{ route('download.csv') }}" class="btn btn-dark btn-sm btn-import">Download Sample
                                    CSV</a>

                            </form>
                            <!-- Show success or error message -->
                            {{-- @if (session('success'))
                                <div class="mt-3 alert alert-success">
                                    {{ session('success') }}
                                </div>

                                <!-- Display imported data -->
                                <h5 class="mt-3">Successfully Imported Users</h5>
                                <ul>
                                    @foreach (session('imported_data', []) as $user)
                                        <li>{{ $user['name'] }} ({{ $user['email'] }})</li>
                                    @endforeach
                                </ul>
                            @endif
                            @if (session('error'))
                                <div class="mt-3 alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <!-- Show failed imports -->
                            @if (session('failed_data'))
                                <h5 class="mt-3">Failed Imports (Duplicate Emails)</h5>
                                <ul>
                                    @foreach (session('failed_data', []) as $failure)
                                        <li>Row {{ $failure['row'] }}: {{ implode(', ', $failure['errors']) }}</li>
                                    @endforeach
                                </ul>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <div class="card tc-dash-card mb-3" data-tc-users-list
        data-list-url="{{ route('tenant_user_index') }}"
        data-autocomplete-url="{{ route('tenant_user_autocomplete') }}">
        <div class="card-body border-bottom py-3">
            @include('tenants.users.partials.list-toolbar', [
                'perPage' => $perPage,
                'search' => $search,
                'paginator' => $users,
            ])
        </div>
        <div class="card-body p-0">
        <div class="table-responsive tc-admin-datatable">
            <table id="userTable" class="table table-striped table-bordered table-sm mb-0">
                <thead>
                    <tr>
                        <th scope="col">Type</th>
                        <th scope="col">Username</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                        <th scope="col">Verification</th>
                        <th scope="col">Door factors</th>
                        <th scope="col">Created On</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="myTable" data-tc-users-tbody>
                    @include('tenants.users.partials.list-rows', ['users' => $users, 'search' => $search])
                </tbody>
            </table>
        </div>
        </div>
        <div class="card-body border-top py-2" data-tc-users-pagination>
            @include('partials.tenant-pagination', ['paginator' => $users])
        </div>
    </div>

    @include('tenants.users.partials.approval-setup-modal')
@endsection
@section('script')
    {{-- sweet alert  start --}}
    <script>
        function deleteUser(userId) {
            // SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the delete form
                    document.getElementById('deleteForm' + userId).submit();
                }
            });
        }
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: @json(session('success')),
                confirmButtonText: 'OK'
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: @json(session('error')),
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    {{-- sweet alert  end --}}
    @php
        $tcUsersStatusUrl = route('tenant_users_update_status', ['id' => '__ID__']);
        $tcUsersVerifyUrl = route('tenant_users_update_verification', ['id' => '__ID__']);
        $tcApprovalFormUrl = str_replace('999999', '__ID__', route('tenant_user_approval_setup_form', 999999));
        $tcApprovalSaveUrl = str_replace('999999', '__ID__', route('tenant_user_approval_setup_store', 999999));
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-button');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You can revert this within 60 days!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Submit the form if confirmed
                        }
                    });
                });
            });
        });
    </script>
   <script>
window.syncUserStatusSelectSkin = function (select) {
    if (!select) {
        return;
    }
    var status = select.value;
    var skin = 'neutral';
    if (status === 'approved' || status === 'active') {
        skin = 'green';
    } else if (status === 'un-approved' || status === 'pending') {
        skin = 'amber';
    } else if (status === 'block' || status === 'deactive') {
        skin = 'red';
    }
    select.className = 'tc-user-status-select tc-user-status-select--' + skin;
    select.classList.add('tc-user-status-select');
};

window.bindUserListRowActions = function (root) {
    var scope = root || document;

    scope.querySelectorAll('[data-tc-user-status-select]').forEach(function (select) {
        if (select.dataset.bound === '1') {
            return;
        }
        select.dataset.bound = '1';
        syncUserStatusSelectSkin(select);

        select.addEventListener('change', function () {
            const userId = this.dataset.userId;
            const previousStatus = this.dataset.currentStatus;
            const newStatus = this.value;
            const selectEl = this;

            if (newStatus === previousStatus) {
                return;
            }

            const label = selectEl.options[selectEl.selectedIndex].text;

            Swal.fire({
                text: 'Change status to ' + label + '?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!',
            }).then((result) => {
                if (!result.isConfirmed) {
                    selectEl.value = previousStatus;
                    syncUserStatusSelectSkin(selectEl);
                    return;
                }

                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const updateStatusUrl = @json($tcUsersStatusUrl).replace('__ID__', userId);

                fetch(updateStatusUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        selectEl.dataset.currentStatus = newStatus;
                        syncUserStatusSelectSkin(selectEl);
                        Swal.fire('Updated!', 'User status changed to ' + label + '.', 'success').then(function () {
                            if (data.show_approval_setup && window.TenantUserApprovalSetup) {
                                window.TenantUserApprovalSetup.open(String(data.user_id || userId));
                            }
                        });
                    } else {
                        selectEl.value = previousStatus;
                        syncUserStatusSelectSkin(selectEl);
                        Swal.fire('Error!', data.message || 'Failed to update status.', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    selectEl.value = previousStatus;
                    syncUserStatusSelectSkin(selectEl);
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                });
            });
        });
    });

    scope.querySelectorAll('.admin-verify-toggle').forEach(function (button) {
        if (button.dataset.bound === '1') {
            return;
        }
        button.dataset.bound = '1';
        button.addEventListener('click', function () {
            const userId = this.dataset.userId;
            const currentStatus = this.dataset.currentStatus;

            if (currentStatus === 'verified') {
                Swal.fire({
                    icon: 'info',
                    title: 'Already Verified',
                    text: 'This user is already verified by admin and cannot be changed.',
                    confirmButtonColor: '#3085d6',
                });
                return;
            }

            Swal.fire({
                text: `Verify this user's account?`,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, verify!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const updateUrl = @json($tcUsersVerifyUrl).replace('__ID__', userId);

                    fetch(updateUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({ is_verified_by_admin: true })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const cell = button.closest('td');
                            if (cell) {
                                cell.innerHTML =
                                    '<span class="tc-verify-pill tc-verify-pill--verified" title="Verified by admin">' +
                                    '<span class="tc-verify-pill__dot" aria-hidden="true"></span>' +
                                    '<span class="tc-verify-pill__label">Verified</span></span>';
                            }

                            Swal.fire('Updated!', 'User has been verified successfully.', 'success').then(function () {
                                if (data.show_approval_setup && window.TenantUserApprovalSetup) {
                                    window.TenantUserApprovalSetup.open(String(data.user_id || userId));
                                }
                            });
                        } else {
                            Swal.fire('Error!', 'Failed to update user verification.', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    });
                }
            });
        });
    });

    scope.querySelectorAll('.fa-copy').forEach(function (copyIcon) {
        if (copyIcon.dataset.bound === '1') {
            return;
        }
        copyIcon.dataset.bound = '1';
        copyIcon.addEventListener('click', function () {
            const userId = this.id.split('-')[2];
            const emailText = document.getElementById('email-' + userId).textContent;
            navigator.clipboard.writeText(emailText).then(function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Email: ' + emailText,
                    showConfirmButton: false,
                    timer: 3000,
                });
            }).catch(function (err) {
                console.error('Error copying text: ', err);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops!',
                    text: 'Failed to copy the email.',
                    confirmButtonText: 'Try Again'
                });
            });
        });
    });
};

document.addEventListener('DOMContentLoaded', function () {
    bindUserListRowActions(document);
});
</script>
    <script>
        $(document).ready(function() {
            $(".btn-import").click(function() {
                $('#importModal').modal('show');
            });
        });
    </script>
    @include('layouts.tenant.partials.panel-asset-fn')
    <script>
        window.TC_USER_APPROVAL_SETUP = {
            formUrl: @json($tcApprovalFormUrl),
            saveUrl: @json($tcApprovalSaveUrl),
            csrf: @json(csrf_token()),
            pointFactorDefaults: @json($point_factor_defaults ?? []),
            roleDefaultUrl: @json(route('tenant_user_role_default')),
        };
    </script>
    <script src="{{ $panelAsset('js/tenant-user-approval-setup.js') }}?v=2"></script>
    <script src="{{ $panelAsset('js/tenant-users-list.js') }}?v=1"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.feather) {
                feather.replace();
            }
        });
    </script>
@endsection
