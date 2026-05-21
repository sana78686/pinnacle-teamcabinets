@extends('layouts.light.master')
@section('title', 'User Menu')

@section('css')
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

    <!-- Add jQuery (required for Bootstrap's JavaScript components) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- Add Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

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
    <h2>Affliates <span>List </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Affliates</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
<div class="p-2 bg-white">

    <div class="p-2 mt-0 card-header no-border">


        @include('partial.message')

        <div class="float-center form-group">
            <div class=" input-group col-4">
                <input type="text" id="myInput" name="" placeholder="Search Name, Email, Username here ..."
                    class="form-control" aria-label="Search">
                <button class="btn btn-primary" type="button">Search</button>
            </div>
        </div>




        <a href="{{ route('tenant_user_child_create') }}" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new user in the system">
            <i class="icofont icofont-plus"></i> Create Affliate
        </a>
        <a href="{{ route('tenant_deleted_users_child_list') }}" class="btn btn-success btn-sm" data-toggle="tooltip"
            title="Restore a previously deleted user">
            <i class="icofont icofont-spinner-alt-3"></i> Restore Affliate
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
            <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
        </a>
        <div class=" pull-right">
            <!-- Import & Export Buttons -->
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
                            </form>

                            <!-- Show success or error message -->
                            @if (session('success'))
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
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="table-responsive table-sm">


        <table class="table p-0 m-0 display table-striped table-bordered table-sm" id="userTable">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Type</th>
                    <th scope="col">Username</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">

                        <input type="text" name="Username" id="search_username" class="form-control form-control-sm"
                            placeholder="Search Username" autocomplete="off" value="{{ request('Username') }}">
                    </th>
                    <th scope="col">
                        <input type="text" name="name" id="search_name" class="form-control form-control-sm"
                            placeholder="Search name" autocomplete="off" value="{{ request('name') }}">
                    </th>
                    <th scope="col">
                        <input type="text" name="email" id="search_email" class="form-control form-control-sm"
                            placeholder="Search email" autocomplete="off" value="{{ request('email') }}">
                    </th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody id="myTable">
                @foreach ($users as $key => $user)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>
                            @if (!empty($user->getRoleNames()))
                                @forelse ($user->getRoleNames() as $v)
                                    <label class="badge bg-success f-14">{{ $v ?? N / A }}</label>

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
                        <td>
                            {{ $user->status ?? 'N/A' }}
                        </td>
                        <td>
                            <a href="{{ route('tenant_child_user_show', $user->id) }}" data-toggle="tooltip"
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
                    <th scope="col">#</th>
                    <th scope="col">Type</th>
                    <th scope="col">Username</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                </tr>
            </tfoot>
        </table>
        @include('partials.tenant-pagination', ['paginator' => $users])





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
        // Status change script
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.status-dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('change', function() {
                    const userId = this.getAttribute('data-user-id');
                    const newStatus = this.value;
                    const previousValue = this.dataset.previousValue || this.value;

                    Swal.fire({
                        text: `You are about to change the user's status to ${newStatus}.`,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, change it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const csrfToken = document.querySelector(
                                'meta[name="csrf-token"]') ? document.querySelector(
                                'meta[name="csrf-token"]').getAttribute('content') : '';

                            if (!csrfToken) {
                                console.error('CSRF token not found!');
                                return; // Exit if the CSRF token is missing
                            }

                            // Get the route URL dynamically
                            const updateStatusUrl =
                                '{{ route('tenant_users_update_status', ':id') }}'.replace(
                                    ':id', userId);

                            fetch(updateStatusUrl, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': csrfToken
                                    },
                                    body: JSON.stringify({
                                        status: newStatus
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Updated!',
                                            `The user's status has been updated to ${newStatus}.`,
                                            'success');
                                    } else {
                                        Swal.fire('Error!',
                                            'There was a problem updating the status.',
                                            'error');
                                        dropdown.value =
                                            previousValue; // Revert if error occurs
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire('Error!',
                                        'There was a problem updating the status.',
                                        'error');
                                    dropdown.value = previousValue; // Revert on error
                                });
                        } else {
                            dropdown.value = previousValue; // Revert if canceled
                        }
                    });

                    this.dataset.previousValue = newStatus; // Store previous value
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
@endsection
