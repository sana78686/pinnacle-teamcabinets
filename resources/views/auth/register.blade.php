@extends('layouts.auth')
@section('styles')

<style>
    .responsive-image {
        height: 300px;
        /* Default height for larger screens */
        width: auto;
    }

    @media (max-width: 576px) {

        /* Adjust for mobile screens */
        .responsive-image {
            height: 150px;
            /* Height for mobile */
        }
    }

</style>

@endsection
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@section('styles')
<style>
    .responsive-image {
        height: 300px;
        width: auto;
    }

    @media (max-width: 576px) {
        .responsive-image {
            height: 150px;
        }
    }

    /* Progress Overlay
    #progress-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.7);
        color: white;
        font-size: 1.4rem;
        font-weight: 600;
        text-align: center;
        z-index: 9999;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    #progress-overlay .progress-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    } */

</style>
@endsection



<div class="container-fluid" style="width: 100%;">
    <div class="col-lg-12" style="width: 100%;">
        {{-- Logo Section --}}
        <div class="pt-5 text-center login100-pic js-tilt" data-tilt="">
            <img src="{{ asset('assets/logo/pinnacle-tenant.png') }}" alt="Tenant Logo" style="max-width: 180px;">
        </div>

    </div>

    <!-- Progress Overlay -->



    <div class="container-fluid bg-logo d-flex justify-content-center align-items-center">


         {{-- <div id="progress-overlay" >
        <div class="progress-content ">
            <div class="spinner-border " role="status"></div>
            <div>Team Cabinets is in progress...</div>
        </div>
    </div> --}}
        <div class="col-lg-10">
            <div class="p-4 ">
                {{-- Success message --}}
                @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                @if ($errors->has('error'))
                <div class="alert alert-danger">
                    {{ $errors->first('error') }}
                </div>
                @endif





                <h3 class="mb-4">Tenant Registration</h3>
                <div id="progress-message" class="alert alert-info mt-t" style="display:none;">
                Team Cabinets is in progress...
            </div>

<form method="POST" id="tenant-form" action="{{ route('pinnacle_tenant_register') }}">
    @csrf

    <div class="row">

        {{-- Company Name --}}
        <div class="col-12 col-md-4 mb-3">
            <label for="company_name">Company Name</label>
            <input
                name="company_name"
                id="company_name"
                type="text"
                class="form-control @error('company_name') is-invalid @enderror"
                value="{{ old('company_name') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Enter the full name of your company">
            @error('company_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Username --}}
        <div class="col-12 col-md-4 mb-3">
            <label for="username">Username</label>
            <input
                name="username"
                id="username"
                type="text"
                class="form-control @error('username') is-invalid @enderror"
                value="{{ old('username') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Choose a username for logging in">
            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Full Name --}}
        <div class="col-12 col-md-4 mb-3">
            <label for="name">Full Name</label>
            <input
                name="name"
                id="name"
                type="text"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Enter your full name">
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Phone --}}
        <div class="col-12 col-md-4 mb-3">
            <label for="phone">Phone</label>
            <input
                name="phone"
                id="phone"
                type="text"
                class="form-control @error('phone') is-invalid @enderror"
                value="{{ old('phone') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Enter your phone number">
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Email --}}
        <div class="col-12 col-md-4 mb-3">
            <label for="email">Email</label>
            <input
                name="email"
                id="email"
                type="email"
                class="form-control @error('email') is-invalid @enderror"
                value="{{ old('email') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Enter your email address">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Password --}}
        <div class="col-12 col-md-4 mb-3">
            <label for="password">Password</label>
            <input
                name="password"
                id="password"
                type="password"
                class="form-control @error('password') is-invalid @enderror"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Choose a strong password">
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="col-12 col-md-4 mb-3">
            <label for="password_confirmation">Repeat Password</label>
            <input
                name="password_confirmation"
                id="password_confirmation"
                type="password"
                class="form-control @error('password_confirmation') is-invalid @enderror"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Repeat the password for confirmation">
            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Country --}}
        <div class="col-12 col-md-4 mb-3 d-none">
            <label for="country_id">Country</label>
            <select
                name="country_id"
                id="country_id"
                class="form-control @error('country_id') is-invalid @enderror"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Your country">
                <option value="">--- Select Country ---</option>
                <option value="233" selected>United States</option>
            </select>
            @error('country_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- State --}}
        <div class="col-12 col-md-4 mb-3">
            <label for="state_id">State</label>
            <select
                name="state_id"
                id="state_id"
                class="form-control @error('state_id') is-invalid @enderror"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Select your state">
                <option value="">--- Select State ---</option>
                {{-- States loaded via JS --}}
            </select>
            @error('state_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- City --}}
        <div class="col-12 col-md-4 mb-3">
            <label for="city_name">City</label>
            <input
                name="city_name"
                id="city_name"
                type="text"
                class="form-control @error('city_name') is-invalid @enderror"
                value="{{ old('city_name') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Enter your city">
            @error('city_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Zip Code --}}
        <div class="col-12 col-md-4 mb-3">
            <label for="zip_code">Zip Code</label>
            <input
                name="zip_code"
                id="zip_code"
                type="text"
                class="form-control @error('zip_code') is-invalid @enderror"
                value="{{ old('zip_code') }}"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Enter your postal/zip code">
            @error('zip_code') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Address --}}
        <div class="col-12 col-md-6 mb-3">
            <label for="address">Address</label>
            <textarea
                name="address"
                id="address"
                class="form-control @error('address') is-invalid @enderror"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="Enter your street address">{{ old('address') }}</textarea>
            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        {{-- Terms Checkbox --}}
        <div class="col-12 col-md-4 mb-3">
            <input
                name="accept_terms"
                id="accept_terms"
                type="checkbox"
                class="form-check-input"
                data-bs-toggle="tooltip"
                data-bs-placement="top"
                title="You must accept terms to continue">
            <label for="accept_terms" class="form-check-label">
                Accept our <a href="#">Terms and Conditions</a>.
            </label>
        </div>

        {{-- Submit Button --}}
        <div class="col-12 col-md-4 mb-3">
            <button class="btn btn-dark btn-lg" type="submit">Create Account</button>
        </div>

    </div>
</form>




    </div>
</div>
</div>

{{-- Bootstrap JS (optional) --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- Initialize Bootstrap Tooltips --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
{{-- /// --}}
<<script>
$(document).ready(function() {
    $('#tenant-form').on('submit', function() {
        // Show "in progress" message
        $('#progress-message').show();

        // Disable submit button to prevent double submission
        $(this).find('button[type="submit"]').prop('disabled', true);
    });
});
</script>






{{-- //////  --}}
<script>
    $(document).ready(function() {
        const oldCountry = "{{ old('country_id', 233) }}"; // uses old input, defaults to 233

        const oldState = "{{ old('state_id') }}";
        const oldCity = "{{ old('city_id') }}";

        // Load States when Country changes
        $('#country_id').on('change', function() {
            const countryId = $(this).val();
            $('#state_id').html('<option value="">Loading...</option>');
            $('#city_id').html('<option value="">--- Select City ---</option>');

            if (countryId) {
                $.get('/get-states/' + countryId, function(states) {
                    let options = '<option value="">--- Select State ---</option>';
                    states.forEach(state => {
                        options += `<option value="${state.id}">${state.name}</option>`;
                    });
                    $('#state_id').html(options);
                });
            } else {
                $('#state_id').html('<option value="">--- Select State ---</option>');
            }
        });

        // Load Cities when State changes
        $('#state_id').on('change', function() {
            const stateId = $(this).val();
            $('#city_id').html('<option value="">Loading...</option>');

            if (stateId) {
                $.get('/get-cities/' + stateId, function(cities) {
                    let options = '<option value="">--- Select City ---</option>';
                    cities.forEach(city => {
                        options += `<option value="${city.id}">${city.name}</option>`;
                    });
                    $('#city_id').html(options);
                });
            } else {
                $('#city_id').html('<option value="">--- Select City ---</option>');
            }
        });

        // Auto-populate state and city on form error
        if (oldCountry) {
            $('#country_id').val(oldCountry).trigger('change');

            $.get('/get-states/' + oldCountry, function(states) {
                let stateOptions = '<option value="">--- Select State ---</option>';
                states.forEach(state => {
                    const selected = (state.id == oldState) ? 'selected' : '';
                    stateOptions += `<option value="${state.id}" ${selected}>${state.name}</option>`;
                });
                $('#state_id').html(stateOptions);

                if (oldState) {
                    $.get('/get-cities/' + oldState, function(cities) {
                        let cityOptions = '<option value="">--- Select City ---</option>';
                        cities.forEach(city => {
                            const selected = (city.id == oldCity) ? 'selected' : '';
                            cityOptions += `<option value="${city.id}" ${selected}>${city.name}</option>`;
                        });
                        $('#city_id').html(cityOptions);
                    });
                }
            });
        }
    });

</script>


@endsection
