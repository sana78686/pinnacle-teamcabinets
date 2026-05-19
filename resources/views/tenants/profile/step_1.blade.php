@extends('layouts.tenant.master')
@section('title', 'Edit Profile')
@section('css')
@endsection
@section('style')
@endsection
@section('breadcrumb-title')
    <h2>User<span>Profile</span></h2>
@endsection
@section('breadcrumb-items')
    <li class="breadcrumb-item">Profile</li>
    <li class="breadcrumb-item active">Set-up Company</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="p-0 b-r-0 card">
                    <div class="card-body">
                        <form class="f1" method="POST" action="{{ route('tenant_store_profile_step_1') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="f1-steps">
                                <div class="f1-progress">
                                    <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3"></div>
                                </div>
                                <div class="f1-step active">
                                    <a href="{{ route('tenant_profile_step_1') }}">
                                        <div class="p-1 f1-step-icon"><i data-feather="users"></i></div>
                                        <p>Set-up Company</p>
                                    </a>
                                </div>
                                <div class="f1-step">
                                    <a href="{{ route('tenant_profile_step_2') }}">
                                        <div class="p-2 f1-step-icon"><i data-feather="lock"></i></div>
                                        <p>Reset Password</p>
                                    </a>
                                </div>
                                <div class="f1-step">
                                    <a href="{{ route('tenant_profile_step_3') }}">
                                        <div class="p-2 f1-step-icon"><i data-feather="info"></i></div>
                                        <p>Other Information</p>
                                    </a>
                                </div>
                            </div>
                            <fieldset>
                                <div class="row">
                                    <!-- Domain Name Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="logo"
                                                title="Provide your website domain name (e.g., example.com).">Company
                                                Logo</label>
                                            <input class="form-control" id="logo" name="logo" type="file"
                                                autofocus>
                                        </div>

                                        <!-- Username Field -->
                                        <div class="form-group">
                                            <label for="username"
                                                title="Choose a unique username for your account.">Username</label>
                                            <input class="form-control" id="username" name="username" type="text"
                                                value="{{ $user->username }}"
                                                placeholder="Create your username (e.g., johndoe123)" required autofocus>
                                        </div>
                                    </div>
                                    <!-- Full Name Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="full-name"
                                                title="Enter your full name as it appears on official documents.">Full
                                                Name</label>
                                            <input class="form-control" id="full-name" name="full_name" type="text"
                                                value="{{ $user->name }}"
                                                placeholder="Enter your full name (e.g., John Doe)" required autofocus>
                                        </div>
                                        <!-- Company Name Field -->
                                        <div class="form-group">
                                            <label for="company-name"
                                                title="Enter the official name of your company.">Company Name</label>
                                            <input class="form-control" id="company-name" name="company_name" type="text"
                                                placeholder="Enter your company name (e.g., Acme Corporation)" autofocus
                                                value="{{ $user->company_name }}">
                                        </div>
                                    </div>
                                    <!-- Contact Number Field -->
                                    <div class="col-md-4">
                                        <!-- Email Address Field -->
                                        <div class="form-group">
                                            <label for="email-address"
                                                title="Enter your active email address for correspondence.">Email
                                                Address</label>
                                            <input class="form-control" id="email-address" name="email_address"
                                                type="email" value="{{ $user->email }}"
                                                placeholder="Enter your email address (e.g., name@example.com)" required
                                                autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label for="contact-number"
                                                title="Provide a valid phone number for communication.">Contact
                                                Number</label>
                                            <input class="form-control" id="contact-number" name="contact_number"
                                                type="tel" placeholder="Enter your contact number (e.g., +1234567890)"
                                                autofocus value="{{ $user->phone }}">
                                        </div>

                                    </div>
                                </div>
                                <div class="f1-buttons">
                                    <button class="btn btn-primary" type="submit">Update Profile</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ route('/') }}/assets/main/js/form-wizard/form-wizard-five.js"></script>
    <script src="{{ route('/') }}/assets/main/js/form-wizard/form-wizard-three.js"></script>
    <script src="{{ route('/') }}/assets/main/js/form-wizard/jquery.backstretch.min.js"></script>
@endsection
