@extends('layouts.tenant.master')
@section('title', 'User Menu')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.2.2/css/dataTables.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>

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
    <div class="p-2 mt-0 card-header no-border">
        @include('partial.message')
        <a href="{{ route('tenant_user_create') }}" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new user in the system">
            <i class="icofont icofont-plus"></i> Create User
        </a>
        <a href="{{ route('tenant_deleted_users_list', $user->id) }}" class="btn btn-success btn-sm" data-toggle="tooltip"
            title="Restore a previously deleted user">
            <i class="icofont icofont-spinner-alt-3"></i> Restore User
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
            <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
        </a>
        <div class=" pull-right">

            <a href="{{ route('users.export') }}" class="btn btn-primary btn-sm" data-toggle="tooltip"
                title="Export user data to a file">
                <i class="text-white icofont icofont-upload-alt"></i> Export
            </a>


            <a href="#" class="btn btn-dark btn-sm btn-import" data-toggle="tooltip"
                title="Import user data from a file">
                <i class="text-white icofont icofont-download-alt"></i> Import
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
        </iv>
        <div class="table-responsive table-xs">
            <table id="userTable" class="table p-0 m-0 table-striped table-bordered table-sm" style="width:100%">
                <thead>
                    <tr>
                        {{-- <th scope="col">#</th> --}}
                        <th scope="col">Type</th>
                        <th scope="col">Username</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
                        {{-- <th scope="col">Company Name</th> --}}
                        <th scope="col">Status</th>
                        <th scope="col">Verification </th>
                        <th scope="col">Created On</th>
                        <th scope="col">Actions</th>
                    </tr>
                    <tr>
                        <th>
                            {{-- <input type="text" placeholder="Search Type"> --}}
                        </th>
                        <th><input type="text" placeholder="Search Username"></th>
                        <th><input type="text" placeholder="Search Full Name"></th>
                        <th><input type="text" placeholder="Search Email"></th>
                        <th>
                            {{-- <input type="text" placeholder="Search Company"> --}}
                        </th>
                        <th>
                            {{-- <input type="text" placeholder="Search Status"> --}}
                        </th>
                        <th>
                            {{-- <input type="text" placeholder="Search Created On"> --}}
                        </th>
                        <th></th> <!-- No search for actions -->
                    </tr>
                </thead>
                <tbody id="myTable">
                    @foreach ($users as $key => $user)
                        <tr>
                            {{-- <td>{{ ++$key }}</td> --}}
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @forelse ($user->getRoleNames() as $v)
                                        <label class="badge bg-light f-14">{{ $v ?? N / A }}</label>
                                    @empty
                                        <label class="badge bg-warning">N/A</label>
                                    @endforelse
                                @else
                                    <label class="badge bg-warning">N/A</label>
                                @endif
                            </td>
                            <td>{{ $user->username ?? 'N/A' }}</td>
                            <td>{{ $user->name ?? 'N/A' }}</td>
                            <td>
                                <span class="email-text" id="email-{{ $user->id }}">{{ $user->email ?? 'N/A' }}</span>
                                <i class="fa fa-copy txt-large" id="copy-email-{{ $user->id }}"
                                    style="cursor: pointer;"></i>
                            </td>
                            {{-- <td>{{ $user->company_name ?? 'N/A' }}</td> --}}
                           <td>
    {{-- User Account Status (Active/Deactivated) --}}
    <button
        class="btn btn-sm user-status-toggle {{ $user->status === 'active' ? 'btn-outline-primary' : 'btn-outline-danger' }}"
        data-user-id="{{ $user->id }}"
        data-current-status="{{ $user->status }}"
    >
        {{ $user->status === 'active' ? 'Active' : 'Deactivated' }}
    </button>
</td>

<td>
    {{-- Admin Verification (Verified / Need Verification) --}}
    <button
        class="btn btn-sm admin-verify-toggle {{ $user->is_verified_by_admin ? 'btn-outline-primary' : 'btn-outline-danger' }}"
        data-user-id="{{ $user->id }}"
        data-current-status="{{ $user->is_verified_by_admin ? 'verified' : 'unverified' }}"
        {{ $user->is_verified_by_admin ? 'disabled' : '' }}
    >
        {{ $user->is_verified_by_admin ? 'Verified' : 'Need Verification' }}
    </button>
</td>


                            <td>{{ $user->created_at->format('d-m-Y') ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('tenant_user_show', $user->id) }}" data-toggle="tooltip"
                                    title="View details of this user">
                                    Show |
                                </a>
                                <a class="" href="{{ route('tenant_user_edit', $user->id) }}" data-toggle="tooltip"
                                    title="Edit this user's information">
                                    Edit |
                                </a>
                                <!-- Delete button with SweetAlert -->
                                <a href="#" type="button" data-toggle="tooltip" title="Delete this user"
                                    onclick="deleteUser({{ $user->id }})">
                                    Delete
                                </a>
                                <!-- Delete form (hidden, used for sending DELETE request) -->
                                <form id="deleteForm{{ $user->id }}" method="POST"
                                    action="{{ route('tenant_user_destroy', $user->id) }}" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        {{-- <th scope="col">#</th> --}}
                        <th scope="col">Type</th>
                        <th scope="col">Username</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
                        {{-- <th scope="col">Company Name</th> --}}
                        <th scope="col">Status</th>
                        <th scope="col">Varification</th>
                        <th scope="col">Created On</th>
                        <th scope="col">Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
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
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @elseif(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    {{-- sweet alert  end --}}
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
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.user-status-toggle').forEach(function (button) {
        button.addEventListener('click', function () {
            const userId = this.dataset.userId;
            const currentStatus = this.dataset.currentStatus;
            const newStatus = currentStatus === 'active' ? 'deactive' : 'active';

            Swal.fire({
                text: `Change status to ${newStatus}?`,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    const updateStatusUrl = '{{ route('tenant_users_update_status', ':id') }}'.replace(':id', userId);

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
                            button.dataset.currentStatus = newStatus;
                            button.textContent = newStatus === 'active' ? 'Active' : 'Deactivated';
                            button.classList.toggle('btn-outline-primary', newStatus === 'active');
                            button.classList.toggle('btn-outline-primary', newStatus === 'deactive');
                            Swal.fire('Updated!', `User status changed to ${newStatus}.`, 'success');
                        } else {
                            Swal.fire('Error!', 'Failed to update status.', 'error');
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
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.admin-verify-toggle').forEach(function (button) {
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
                    const updateUrl = '{{ route('tenant_users_update_verification', ':id') }}'.replace(':id', userId);

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
                            button.dataset.currentStatus = 'verified';
                            button.textContent = 'Verified';
                            // button.classList.remove('btn-danger');
                            // button.classList.add('btn-success');
                            button.disabled = true;

                            Swal.fire('Updated!', 'User has been verified successfully.', 'success');
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
});
</script>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Loop through all copy icons for users
            document.querySelectorAll('.fa-copy').forEach(copyIcon => {
                copyIcon.addEventListener('click', function() {
                    const userId = this.id.split('-')[
                        2]; // Extract the user ID from the copy icon ID
                    const emailText = document.getElementById('email-' + userId)
                        .textContent; // Get the email using the user ID
                    // Use the Clipboard API to copy the email text
                    navigator.clipboard.writeText(emailText).then(function() {
                        // If the text is copied, show SweetAlert with the copied email
                        Swal.fire({
                            icon: 'success',
                            title: 'Copied!',
                            text: 'Email: ' +
                                emailText, // Show the copied email in the SweetAlert message
                            showConfirmButton: false,
                            timer: 3000,
                        });
                    }).catch(function(err) {
                        // If an error occurs while copying, show an error message
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
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".btn-import").click(function() {
                $('#importModal').modal('show');
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            $("#myInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
            $("#search_username").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
            $("#search_name").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
            $("#search_email").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#myTable tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
    <script>
        // new DataTable('#userTable', {
        //     initComplete: function() {
        //         this.api()
        //             .columns()
        //             .every(function() {
        //                 let column = this;
        //                 let title = column.header().textContent;

        //                 // Create input element
        //                 let input = document.createElement('input');
        //                 input.placeholder = title;
        //                 column.header().replaceChildren(input);

        //                 // Event listener for user input
        //                 input.addEventListener('keyup', () => {
        //                     if (column.search() !== this.value) {
        //                         column.search(input.value).draw();
        //                     }
        //                 });
        //             });
        //     }
        // });
        new DataTable('#userTable', {
            initComplete: function() {
                this.api()
                    .columns()
                    .every(function(index) {
                        let column = this;
                        let input = $('thead tr:eq(1) th').eq(index).find('input');
                        if (input.length) {
                            input.on('keyup change', function() {
                                if (column.search() !== this.value) {
                                    column.search(this.value).draw();
                                }
                            });
                        }
                    });
            }
        });
    </script>
@endsection
