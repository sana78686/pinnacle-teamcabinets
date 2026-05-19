@extends('layouts.tenant.master')
@section('title', 'Edit Profile')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script
  src="https://code.jquery.com/jquery-3.7.1.min.js"
  integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
  crossorigin="anonymous"></script>
@section('css')
@endsection

@section('style')
@endsection

@section('breadcrumb-title')
    <h2>User<span>Profile</span></h2>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">Profile</li>
    <li class="breadcrumb-item active">Other Information</li>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="b-r-0 card">
                    <div class="card-body">
                        <form class="f1" method="post">
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
                                <div class="f1-step">
                                    <a href="{{ route('tenant_profile_step_2') }}">
                                        <div class="p-2 f1-step-icon"><i data-feather="lock"></i></div>
                                        <p>Reset Password</p>
                                    </a>
                                </div>
                                <div class="f1-step active">
                                    <a href="{{ route('tenant_profile_step_3') }}">
                                        <div class="p-2 f1-step-icon"><i data-feather="check-circle"></i></div>
                                        <p>Other Information</p>
                                    </a>
                                </div>
                            </div>
                            <fieldset>
                                <div class="row">
                                    <!-- Address Field -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="address"
                                                title="Enter the full address, including street name.">Address</label>
                                            <input class="form-control" id="address" name="address" type="text"
                                                placeholder="Street address" required>
                                        </div>

                                        <!-- City Field -->
                                        <div class="form-group">
                                            <label for="city" title="Enter the city name.">City</label>
                                                <select class="form-control js-example-basic-single"placeholder="City name" name="city"id="city" type="text" required>
                                                    <option value="AL">Alabama</option>
                                                    ...
                                                  <option value="WY">Wyoming</option>
                                                </select>

                                        </div>
                                    </div>

                                    <!-- State and Zip Code Fields -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state" title="Enter the state or province.">State</label>
                                            <input class="form-control" id="state" name="state" type="text"
                                                placeholder="State name" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="zip-code" title="Enter the postal or zip code.">Zip Code</label>
                                            <input class="form-control" id="zip-code" name="zip_code" type="text"
                                                placeholder="Postal code" required>
                                        </div>
                                    </div>

                                    <!-- Country and Description Fields -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="country" title="Enter the country name.">Country</label>
                                            <input class="form-control" id="country" name="country" type="text"
                                                placeholder="Country name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="description"
                                                title="Provide additional details or description if needed.">Description</label>
                                            <textarea class="form-control" id="description" name="description" placeholder="Additional details" required></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="f1-buttons">
                                    <button class="btn btn-primary btn-next" type="button">Update Information</button>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    // In your Javascript (external .js resource or <script> tag)
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
@section('script')
    <script src="{{ route('/') }}/assets/main/js/form-wizard/form-wizard-five.js"></script>
    <script src="{{ route('/') }}/assets/main/js/form-wizard/form-wizard-three.js"></script>
    <script src="{{ route('/') }}/assets/main/js/form-wizard/jquery.backstretch.min.js"></script>
@endsection
