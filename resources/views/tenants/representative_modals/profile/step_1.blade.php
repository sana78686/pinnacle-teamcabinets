@extends('layouts.light.master')
@section('title', 'Edit Profile')

@section('css')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ route('/') }}/assets/main/css/select2.css">
<script src="{{ route('/') }}/assets/main/js/select2/select2.full.min.js"></script>
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>User<span>Profile</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">Profile</li>
@endsection


@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="p-0 b-r-0">
                    <div class="p-3 card-body">
                        <form class="f1" method="POST" action="{{ route('tenant_store_profile_step_1') }}" enctype="multipart/form-data">
                            @csrf
                            <fieldset>
                                <div class="row">
                                    <!-- Domain Name Field -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong for="logo"
                                                title="Provide your website domain name (e.g., example.com).">Logo</strong>
                                            <input class="form-control" id="logo" name="logo" type="file"
                                                required autofocus>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <!-- Username Field -->
                                        <div class="form-group">
                                            <strong for="username"
                                                title="Choose a unique username for your account.">Username</strong>
                                            <input class="form-control" id="username" name="username" type="text"
                                                value="{{ old('username', $user->username) }}"
                                                placeholder="Create your username (e.g., johndoe123)" required autofocus>
                                        </div>
                                    </div>
                                    <!-- Full Name Field -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong for="full-name"
                                                title="Enter your full name as it appears on official documents.">Full
                                                Name</strong>
                                            <input class="form-control" id="full-name" name="full_name" type="text"
                                                value="{{ old('full_name', $user->name) }}"
                                                placeholder="Enter your full name (e.g., John Doe)" required autofocus>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <!-- Company Name Field -->
                                        <div class="form-group">
                                            <strong for="company-name"
                                                title="Enter the official name of your company.">Company Name</strong>
                                            <input class="form-control" id="company-name" name="company_name" type="text"
                                                placeholder="Enter your company name (e.g., Acme Corporation)" required
                                                value="{{ old('company_name', $user->company_name) }}" autofocus>
                                        </div>
                                    </div>


                                    <!-- Contact Number Field -->
                                    <div class="col-md-6">
                                        <!-- Email Address Field -->
                                        <div class="form-group">
                                            <strong for="email-address"
                                                title="Enter your active email address for correspondence.">Email
                                                Address</strong>
                                            <input class="form-control" id="email-address" name="email_address"
                                                type="email" value="{{ old('email', $user->email) }}"
                                                placeholder="Enter your email address (e.g., name@example.com)" required
                                                autofocus>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong for="contact-number"
                                                title="Provide a valid phone number for communication.">Contact
                                                Number</strong>
                                            <input class="form-control" id="contact-number" name="contact_number"
                                                type="tel" placeholder="Enter your contact number (e.g., +1234567890)"
                                                required autofocus value="{{ old('contact_number', $user->phone) }}">
                                        </div>

                                    </div>

                                    <!-- Country and Description Fields -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong for="country" title="Enter the country name.">Country</strong>
                                            <select class="js-example-basic-single col-sm-12 form-control b-r-0"
                                                id="country_id" name="country_id" required data-toggle="tooltip"
                                                title="Select the Country">
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ $country->id == $user->country_id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- State and Zip Code Fields -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong for="state" title="Enter the state or province.">State</strong>
                                            <select class="js-example-basic-single col-sm-12 form-control b-r-0"
                                                id="state_id" name="state_id" required data-toggle="tooltip"
                                                title="Select the state">
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}"
                                                        {{ $state->id == $user->state_id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <!-- City Field -->
                                        <div class="form-group">
                                            <strong for="city" title="Enter the city name.">City</strong>
                                            <input class="form-control" id="city_name" name="city_name" type="text"
                                            placeholder="Enter City." required
                                            value="{{ old('city_name', $user->city_name) }}">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong for="zip-code" title="Enter the postal or zip code.">Zip Code</strong>
                                            <input class="form-control" id="zip-code" name="zip_code" type="text"
                                                placeholder="Postal code"
                                                value="{{ old('zip_code', $user->zip_code) }}">
                                        </div>
                                    </div>

                                    {{-- <div class="col-md-6">
                                        <div class="form-group">
                                            <strong for="description"
                                                title="Provide additional details or description if needed.">Description</strong>
                                            <textarea class="form-control" id="description" name="description" placeholder="Additional details"  value="{{ old('description', $user->description) }}" ></textarea>
                                        </div>
                                    </div> --}}

                                    <!-- Address Field -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <strong for="address"
                                                title="Enter the full address, including street name.">Address</strong>
                                            <textarea class="form-control" id="address" name="address" placeholder="Street address" >{{ old('address', $user->address) }}</textarea>
                                        </div>

                                    </div>
                                </div>

                    </div>
                    <div class="f1-buttons">
                        <button class="btn btn-primary btn-next" type="submit">Update Profile</button>
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
