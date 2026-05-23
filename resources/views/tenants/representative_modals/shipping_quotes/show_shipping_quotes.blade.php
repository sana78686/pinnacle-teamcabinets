@extends('layouts.tenant.role.master')
@section('title', 'Shipping Quotes Menu')

@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Shipping Quotes<span>Details </span></h2>
@endsection

@section('breadcrumb-items')
<li class="breadcrumb-item active">Shipping Quotes</li>
    <li class="breadcrumb-item">View</li>
@endsection

@section('content')


<div class="container-fluid">
    <div class="row">

        <!-- Personal Information -->
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="2">Shipping Quotes Information</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Shipping Quote Name</th>
                        <td>quote</td>
                    </tr>
                    <tr>
                        <th>Bill Name</th>
                        <td>bill</td>
                    </tr>
                    <tr>
                        <th>Ship Name</th>
                        <td>ship</td>
                    </tr>
                    <tr>
                        <th>Job Name</th>
                        <td>job</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>date</td>
                    </tr>

                </tbody>
            </table>
        </div>

        <!-- Product Catalog Information -->
        <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-4">
            <table class="table table-bordered">
                <thead class="table-secondary">
                    <tr>
                        <th colspan="2">Shipping Quotes Information</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

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
@endsection


{{-- sweet alert link start --}}

{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

{{-- sweet alert link end --}}
