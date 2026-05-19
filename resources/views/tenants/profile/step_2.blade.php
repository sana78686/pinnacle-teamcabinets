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
    <li class="breadcrumb-item active">Reset Password</li>
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
              @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                 @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="b-r-0 card">
                    <div class="card-body">
                        <form class="f1" method="post" action="{{ route('tenant_store_profile_step_2') }}" >
                            @csrf
                            <div class="f1-steps">
                                <div class="f1-progress">
                                    <div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3"></div>
                                </div>
                                <div class="f1-step ">
                                    <a href="{{ route('tenant_profile_step_1') }}">

                                        <div class="p-2 f1-step-icon"><i data-feather="users"></i></div>
                                        <p>Set-up Company</p>
                                    </a>
                                </div>
                                <div class="f1-step active">
                                    <a href="{{ route('tenant_profile_step_2') }}">
                                        <div class="p-1 f1-step-icon"><i data-feather="lock"></i></div>
                                        <p>Reset Password</p>
                                    </a>
                                </div>
                                <div class="f1-step ">
                                    <a href="{{ route('tenant_profile_step_3') }}">
                                        <div class="p-2 f1-step-icon"><i data-feather="info"></i></div>
                                        <p>Other Information</p>
                                    </a>
                                </div>
                            </div>
                            <fieldset>
                                <div class="row">
                                    <!-- Old Password Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="old-password"
                                                title="Enter the password you are currently using.">Old Password</label>
                                            <input class="form-control" id="old-password" name="old_password"
                                                type="password" placeholder="Enter your current password" required>
                                        </div>
                                    </div>
                                    <!-- New Password Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="new-password"
                                                title="Enter a new password. Make sure it is strong and secure.">New
                                                Password</label>
                                            <input class="form-control" id="new-password" name="new_password"
                                                type="password"
                                                placeholder="Enter a new password (e.g., At least 8 letters)" required>
                                        </div>
                                    </div>
                                    <!-- Confirm Password Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="confirm-password"
                                                title="Re-enter the new password to confirm it.">Confirm Password</label>
                                            <input class="form-control" id="confirm-password" name="confirm_password"
                                                type="password" placeholder="Re-enter your new password" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="f1-buttons">
                                    <button class="btn btn-primary btn-next" type="submit">Update Password</button>
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
