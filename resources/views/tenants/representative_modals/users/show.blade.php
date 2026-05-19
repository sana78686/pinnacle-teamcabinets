@extends('layouts.light.master')
@section('title', 'User Menu')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>User <span>Details <small>({{ $user->name }}) </small></span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">User</li>
    <li class="breadcrumb-item active">Detail</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">

            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-6 ">
                <table class="table table-bordered ">
                    <thead class="table-secondary">
                        <th colspan="2">Personal Information</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>Type</th>
                            <td>
                                @if (!empty($user->getRoleNames()))
                                    @foreach ($user->getRoleNames() as $role)
                                        <span class="badge bg-success">{{ $role }}</span>
                                    @endforeach
                                @else
                                    <span class="badge bg-warning">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Username</th>
                            <td>{{ $user->username ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Full Name</th>
                            <td>{{ $user->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>
                                <span class="email-text" id="email-{{ $user->id }}">{{ $user->email ?? 'N/A' }}</span>
                                <i class="fa fa-copy" id="copy-email-{{ $user->id }}" style="cursor: pointer;"></i>
                            </td>

                        </tr>
                        <tr>
                            <th>Cell Phone</th>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Company Name</th>
                            <td>{{ $user->company_name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ ucfirst($user->status) }}</td>
                        </tr>
                        <!-- Add other fields as necessary -->
                    </tbody>
                </table>
            </div>
            <div class="p-2 col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <table class="table table-bordered ">
                    <thead class="table-secondary">
                        <th colspan="2">Other Information</th>
                    </thead>
                    <tbody>
                        <tr>
                            <th>Country</th>
                            <td>{{ $user->country->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>State</th>
                            <td>{{ $user->state->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>City</th>
                            <td>{{ $user->city->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>County</th>
                            <td>{{ $user->county->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Zip Code</th>
                            <td>{{ $user->zip_code ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $user->address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Tax Exemption </th>
                            <td>
                                <i data-feather="{{ $user->is_taxable_user == 1 ? 'check-circle' : 'x-circle' }}"></i>
                                {{-- <i data-feather="x-circle"></i> --}}

                            </td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                        </tr>
                        <!-- Add other fields as necessary -->
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection

@section('script')
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
