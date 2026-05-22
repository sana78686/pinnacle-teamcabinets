@extends('layouts.tenant.master')
@section('title', 'Shipping Quotes Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatables.css">
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/datatable-extension.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>Shipping Quotes <span>List </span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Shipping Quotes</li>
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

        {{-- <h5>Best Selling Product</h5> --}}
        <a href="{{ route('tenant_shipping_quotes_index') }}" class="btn btn-success btn-sm" data-toggle="tooltip" title="Back to shipping quotes list">
            <i class="icofont icofont-listing-number"></i> Shipping Quotes List
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
        <div class="table-responsive table-sm">
            <table class="table p-0 m-0 display table-striped table-bordered table-sm" id="">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Shipping Quotes Name</th>
                        <th scope="col">Bill Name</th>
                        <th scope="col">Ship Name</th>
                        <th scope="col">Job Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>

                        <td scope="col">1</td>
                        <td scope="col">quote</td>
                        <td scope="col">Bill</td>
                        <td scope="col">Ship </td>
                        <td scope="col">Job </td>
                        <td scope="col">Date</td>

                        <td>
                            <a href="{{ route('tenant_quotes_restore',1) }}"
                                data-toggle="tooltip"
                                title="Restore details of this Stock Check" >
                                Restore
                            </a>
                        </td>
                    </tr>
                    {{-- @empty
                    <tr>
                        <td colspan="8" class="text-center">--- No Data Found ---</td>
                    </tr>
                    @endforelse
     --}}
                    </tr>

                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Quote Name</th>
                        <th scope="col">Bill Name</th>
                        <th scope="col">Ship Name</th>
                        <th scope="col">Job Name</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>


@endsection

@section('script')

    <script src="{{ route('/') }}/assets/main/js/datatable/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/dataTables.buttons.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/jszip.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/buttons.colVis.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/pdfmake.min.js"></script>
    <script src="{{ route('/') }}/assets/main/js/datatable/datatable-extension/vfs_fonts.js"></script>

    <script src="{{ route('/') }}/assets/main/js/datatable/datatables/datatable.custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    {{-- sweet alert  start --}}
    {{--
    <script>
        function confirmation(ev, url) {
            ev.preventDefault();

            swal({
                title: "Are You Sure To Delete This?",
                text: "This action will  be the permanent and cannot be undone. ",
                icon: "warning",
                buttons: true,
                dangerMode: true,

            }).then((willDelete) => {

                if (willDelete) {
                    window.location.href = url;
                } else {
                    swal("Your datais save!", {
                        icon: "info",
                    });
                }
            });
        }
    </script>
    @if (session('success'))
        <script>
            swal({
                title: "success!",
                text: "{{ session('success') }}",
                icon: "success",
                button: "ok",
            });
        </script>
    @endif



    @if (session('error'))
        <script>
            swal({
                title: "Error!",
                text: "{{ session('error') }}",
                icon: "error",
                button: "ok",
            });
        </script>
    @endif --}}

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


{{-- sweet alert link start --}}

{{--
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
    integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script> --}}

{{-- sweet alert link end --}}
