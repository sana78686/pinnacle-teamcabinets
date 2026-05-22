@extends('layouts.light.master')
@section('title', 'Shipping Quotes Menu')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Shipping Quotes<span>List </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Shipping Quotes</li>
    <li class="breadcrumb-item active">List</li>
@endsection

@section('content')


<div class="p-2 mt-0 card-header no-border">
    <a   href="{{ route('tenant_deleted_shipping_quotes_list') }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Restore a previously deleted Shipping Quotes">
        <i class="icofont icofont-spinner-alt-3"></i> Restore Shipping Quotes
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



<div class="pt-0 card-body">
    @include('tenants.partials.workspace-records-table', [
        'records' => $records,
        'rowLabel' => 'Shipping quote',
        'showRoute' => 'tenant_shipping_quotes_show',
        'editRoute' => 'tenant_shipping_quotes_edit',
        'destroyRoute' => 'tenant_shipping_quotes_destroy',
    ])
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
@endsection


{{-- sweet alert link start --}}

{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

{{-- sweet alert link end --}}
