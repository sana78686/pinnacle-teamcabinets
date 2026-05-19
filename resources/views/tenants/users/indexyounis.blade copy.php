@extends('layouts.tenant.master')
@section('title', 'User Menu')

@section('css')

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
    <h2>User <span>List </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Users</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')
    <div class="p-2 mt-0 card-header no-border">
        @if (session('success'))
            <div class=" txt-danger" role="alert">
                <h4 class="alert-heading">Note!</h4>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @include('partial.flashMessage')
        <a href="{{ route('tenant_user_create') }}" class="text-white btn btn-info btn-sm" data-toggle="tooltip"
            title="Create a new user in the system">
            <i class="icofont icofont-plus"></i> Create User
        </a>
        <a href="{{ route('tenant_deleted_users_list') }}" class="btn btn-success btn-sm" data-toggle="tooltip"
            title="Restore a previously deleted user">
            <i class="icofont icofont-spinner-alt-3"></i> Restore User
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
            <a href="" class="btn btn-dark btn-sm" data-toggle="tooltip" title="Import user data from a file">
                <i class="text-white icofont icofont-download-alt"></i> Import
            </a>
            <div class="column-toggle-dropdown">
                <button onclick="toggleColumnDropdown()">🛠 Manage Columns</button>
                <div id="column-toggle-menu" class="column-toggle-list"></div>
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
                    <th scope="col">Company Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created On</th>
                    <th scope="col">Actions</th>
                </tr>
                <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col">

                        <input type="text" name="Username" id="Username" class="form-control form-control-sm"
                            placeholder="Search Username" autocomplete="off" value="{{ request('Username') }}">
                    </th>
                    <th scope="col">
                        <input type="text" name="name" id="name" class="form-control form-control-sm"
                            placeholder="Search name" autocomplete="off" value="{{ request('name') }}">
                    </th>
                    <th scope="col">
                        <input type="text" name="email" id="email" class="form-control form-control-sm"
                            placeholder="Search email" autocomplete="off" value="{{ request('email') }}">
                    </th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
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
                        <td>{{ $user->company_name ?? 'N/A' }}</td>
                        <td>
                            <select class="form-select status-dropdown" data-user-id="{{ $user->id }}">
                                <option value="approved" {{ $user->status === 'approved' ? 'selected' : '' }}>Approved
                                </option>
                                <option value="un-approved" {{ $user->status === 'un-approved' ? 'selected' : '' }}>
                                    Unapproved
                                </option>
                                <option value="block" {{ $user->status === 'block' ? 'selected' : '' }}>Block</option>
                            </select>
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
                    <th scope="col">#</th>
                    <th scope="col">Type</th>
                    <th scope="col">Username</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created On</th>
                    <th scope="col">Actions</th>
                </tr>
            </tfoot>
        </table>
        <div class="pt-2 pagination-primary">
            {{ $users->links('pagination::bootstrap-5') }}

        </div>


        {{-- <nav aria-label="...">
                <ul class="pagination pagination-primary">
                    @if ($users->onFirstPage())
                        <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">Previous</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a></li>
                    @endif

                    @if ($users->currentPage() > 1)
                        <li class="page-item"><a class="page-link" href="{{ $users->url(1) }}">1</a></li> <!-- First page -->
                    @endif

                    @if ($users->currentPage() > 2)
                        <li class="page-item disabled"><a class="page-link" href="#">...</a></li> <!-- Ellipsis before current page -->
                    @endif

                    <li class="page-item active">
                        <a class="page-link" href="#">{{ $users->currentPage() }}</a> <!-- Current page -->
                    </li>

                    @if ($users->currentPage() < $users->lastPage() - 1)
                        <li class="page-item disabled"><a class="page-link" href="#">...</a></li> <!-- Ellipsis after current page -->
                    @endif

                    @if ($users->currentPage() < $users->lastPage())
                        <li class="page-item"><a class="page-link" href="{{ $users->url($users->lastPage()) }}">{{ $users->lastPage() }}</a></li> <!-- Last page -->
                    @endif

                    @if ($users->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a></li>
                    @else
                        <li class="page-item disabled"><a class="page-link" href="#">Next</a></li>
                    @endif
                </ul>
            </nav> --}}


    </div>
    </div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        var table = $('#userTable').DataTable();

        // Initialize Column Visibility Menu
        var columnMenu = $('#column-toggle-menu');
        table.columns().every(function (index) {
            var column = this;
            var isVisible = column.visible();

            // Create checkbox for each column
            columnMenu.append(`
                <label>
                    <input type="checkbox" class="toggle-column" data-column="${index}" ${isVisible ? 'checked' : ''}>
                    ${$(column.header()).text()}
                </label>
            `);
        });

        // Handle Checkbox Click
        $('.toggle-column').on('change', function () {
            var columnIndex = $(this).data('column');
            var isVisible = $(this).prop('checked');
            table.column(columnIndex).visible(isVisible);
        });
    });

    // Function to toggle dropdown visibility
    function toggleColumnDropdown() {
        var menu = $('#column-toggle-menu');
        menu.toggle();
    }

    // Close menu when clicking outside
    $(document).click(function (event) {
        if (!$(event.target).closest('.column-toggle-dropdown').length) {
            $('#column-toggle-menu').hide();
        }
    });
</script>





    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let table = document.querySelector("table");
            let headers = Array.from(table.querySelectorAll("thead th"));

            headers.forEach((header, index) => {
                header.draggable = true;

                header.addEventListener("dragstart", function(e) {
                    e.dataTransfer.setData("text/plain", index);
                });

                header.addEventListener("dragover", function(e) {
                    e.preventDefault();
                });

                header.addEventListener("drop", function(e) {
                    e.preventDefault();
                    let fromIndex = e.dataTransfer.getData("text/plain");
                    let toIndex = index;

                    swapColumns(fromIndex, toIndex);
                });
            });

            function swapColumns(fromIndex, toIndex) {
                let rows = table.querySelectorAll("tr");
                rows.forEach(row => {
                    let cells = Array.from(row.children);
                    row.insertBefore(cells[fromIndex], cells[toIndex]);
                });

                saveColumnOrder();
            }

            function saveColumnOrder() {
                let columnNames = [];
                headers.forEach(header => {
                    columnNames.push(header.innerText.trim());
                });

                fetch("{{ route('save_user_column_order') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            module: "users",
                            columns: columnNames
                        })
                    }).then(response => response.json())
                    .then(data => console.log(data.message));
            }
        });
    </script>



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
@endsection


{{-- sweet alert link start --}}

{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

{{-- sweet alert link end --}}
