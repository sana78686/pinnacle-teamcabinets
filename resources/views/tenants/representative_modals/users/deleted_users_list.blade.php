@extends('layouts.tenant.role.master')
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
@endsection

@section('breadcrumb-title')
    <h2>Deleted User(s) <span>List </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item">Restore</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    <div class="p-2 mt-0 card-header no-border">

        @include('partial.message')

        <div class="float-center form-group">
            <div class=" input-group col-4">
                <input type="text" id="myInput" name="" placeholder="Search Name, Email, Username here ..." class="form-control" aria-label="Search">
                <button class="btn btn-primary" type="button">Search</button>
            </div>
        </div>
        {{-- <h5>Best Selling Product</h5> --}}
        <a href="{{ route('tenant_user_child_create') }}" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new user in the system">
            <i class="icofont icofont-plus"></i> Create User
        </a>

        <a href="{{ route('tenant_user_child_index') }}" class="btn btn-success btn-sm" data-toggle="tooltip"
            title="Restore a previously deleted user">
            <i class="icofont icofont-listing-number"></i> Users List
        </a>
        <a href="{{ url()->current() }}" class="btn btn-light btn-sm" data-toggle="tooltip" title="Refresh this Page.">
            <i class="icofont icofont-refresh fa fa-spin"></i>&nbsp; Refresh
        </a>

        <div class=" pull-right">
            <!-- Import & Export Buttons -->
            <button class="btn btn-primary btn-sm" data-toggle="tooltip" title="Export user data to a file">
                <i class="text-white icofont icofont-upload-alt"></i> Export
            </button>

            <button class="btn btn-dark btn-sm" data-toggle="tooltip" title="Import user data from a file">
                <i class="text-white icofont icofont-download-alt"></i> Import
            </button>
        </div>
    </div>

    <div class="card tc-dash-card mb-3">
        <div class="card-body p-0">
        <div class="table-responsive table-sm tc-admin-datatable">
            <table class="table table-striped table-bordered table-sm mb-0" id="">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Type</th>
                        <th scope="col">Username</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
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
                    </tr>
                </thead>
                <tbody id="myTable">
                    @forelse ($users as $key => $user)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $v)
                                        <label class="badge bg-success">{{ $v ?? N / A }}</label>
                                    @endforeach
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
                                {{-- <a href="{{ route('tenant_user_restore', $user->id) }}"
                                data-toggle="tooltip"
                                title="View details of this user" >
                                Restore
                            </a> --}}

                                <!-- Restore button with SweetAlert -->
                                <a href="#" type="button" data-toggle="tooltip" title="View details of this user"
                                    onclick="restoreUser({{ $user->id }})">
                                    Restore
                                </a>

                                <!-- Delete form (hidden, used for sending DELETE request) -->
                                <form id="restoreForm{{ $user->id }}" method="POST"
                                    action="{{ route('tenant_user_restore', $user->id) }}" style="display: none;">
                                    @csrf
                                    @method('get')
                                </form>
                            </td>


                        </tr>

                    @empty
                        <tr>
                            <td colspan="8" class="text-center">--- No Data Found ---</td>
                        </tr>
                    @endforelse

                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Type</th>
                        <th scope="col">Username</th>
                        <th scope="col">Full Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Actions</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="card-body border-top py-2">
        @include('partials.tenant-pagination', ['paginator' => $users])
        </div>
        </div>
        </div>

@endsection

@section('script')

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

        function restoreUser(userId) {
            // SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to to restore this user!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // If confirmed, submit the delete form
                    document.getElementById('restoreForm' + userId).submit();
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Attach change event to all dropdowns with the class 'status-dropdown'
            document.querySelectorAll('.status-dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('change', function() {
                    const userId = this.getAttribute('data-user-id');
                    const newStatus = this.value;

                    // Show SweetAlert confirmation
                    Swal.fire({
                        // title: 'Are you sure?',
                        text: `You are about to change the user's status to ${newStatus}.`,
                        // icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, change it!',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Make an AJAX request to update the status
                            fetch(`/users/${userId}/status`, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        status: newStatus
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire(
                                            'Updated!',
                                            `The user's status has been updated to ${newStatus}.`,
                                            'success'
                                        );
                                    } else {
                                        Swal.fire(
                                            'Error!',
                                            'There was a problem updating the status.',
                                            'error'
                                        );
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    Swal.fire(
                                        'Error!',
                                        'There was a problem updating the status.',
                                        'error'
                                    );
                                });
                        } else {
                            // Revert dropdown selection if canceled
                            this.value = this.dataset.previousValue;
                        }
                    });

                    // Store the current value as previous value in case user cancels
                    this.dataset.previousValue = newStatus;
                });
            });
        });
    </script>
    <script>
        document.querySelectorAll('.btn-info').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.href;
                alert('here');
                // Make an AJAX request to fetch user details
                fetch(url)
                    .then(response => response.text())
                    .then(html => {
                        // Load the response HTML into the modal content
                        document.getElementById('userDetailsContent').innerHTML = html;
                    })
                    .catch(error => {
                        console.error('Error fetching user details:', error);
                        document.getElementById('userDetailsContent').innerHTML =
                            '<p>Error loading details.</p>';
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
                            confirmButtonText: 'OK'
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
@endsection
