@extends('layouts.light.master')
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
                <div class="b-r-0 card">
                    @include('partial.message')
                    <form class="f1" method="post" action="{{ route('tenant_store_profile_step_2') }}">
                            <div class="card-body">
                            @csrf
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="old-password">Old Password</label>
                                            <input class="form-control" id="old-password" name="old_password"
                                                type="password" placeholder="Enter your current password" required>
                                            @error('old_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="new-password">New Password</label>
                                            <input class="form-control" id="new-password" name="new_password"
                                                type="password" placeholder="Enter a new password (at least 8 characters)" required>
                                            @error('new_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirm-password">Confirm Password</label>
                                            <input class="form-control" id="confirm-password" name="confirm_password"
                                                type="password" placeholder="Re-enter your new password" required>
                                            @error('confirm_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="f1-buttons">
                                    <button class="btn btn-primary" type="submit">Update Password</button>
                                </div>
                            </fieldset>
                        </form>

                        {{-- <form class="f1" method="post">
                            <fieldset>
                                <div class="row">
                                    <!-- Old Password Field -->
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="old-password"
                                                title="Enter the password you are currently using.">Old Password</label>
                                            <input class="form-control" id="old-password" name="old_password"
                                                type="password" placeholder="Enter your current password" required>
                                        </div>
                                    </div>

                                    <!-- New Password Field -->
                                    <div class="col-md-12">
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="confirm-password"
                                                title="Re-enter the new password to confirm it.">Confirm Password</label>
                                            <input class="form-control" id="confirm-password" name="confirm_password"
                                                type="password" placeholder="Re-enter your new password" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="f1-buttons">
                                    <button class="btn btn-primary btn-next" type="button">Update Password</button>
                                </div>
                            </fieldset>
                        </form> --}}
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
