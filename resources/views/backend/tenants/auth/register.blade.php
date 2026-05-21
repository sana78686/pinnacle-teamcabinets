@extends('layouts.mega.master')
@section('content')
<div class="app-container app-theme-white body-tabs-shadow ">
    <div class="app-container">
        <div class="h-100">
            <div class="h-100 no-gutters row">
                <div
                    class="bg-white h-100 d-md-flex d-sm-block justify-content-center align-items-center col-md-12 col-lg-12">
                    <div class="mx-auto app-login-box col-sm-12 col-md-12 col-lg-12">
                        <!-- <div class="mt-5">
                            {{--
                            <x-application-logo class="block w-auto text-gray-800 fill-current h-9"
                                style="height: 40px" /> --}}
                            <img src="{{ dynamic_url('/assets/logo/pinnacle.png') }}"
                                class="block w-auto text-center text-gray-800 fill-current h-9" style="height: 80px">

                            {{-- <img src="{{ asset('assets/logo/team_cabinets.jpg') }}" alt="Team Cabinets"
                                style="height: 70px" /> --}}
                        </div> -->
                        <h4>
                            <div>Welcome,</div>
                            <span>It only takes a <span class="text-success">few seconds</span> to create your
                                account</span>
                        </h4>
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
                        <div>
                            <form method="POST" action="{{ route('pinnacle_tenant_register') }}">
                                @csrf
                                <div class="form-row">
                                    {{-- Company Name --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="company_name">Company Name</label>
                                            <input name="company_name" id="company_name"
                                                placeholder="Enter your company name..." type="text"
                                                class="form-control @error('company_name') is-invalid @enderror"
                                                value="{{ old('company_name') }}" autofocus>
                                            @error('company_name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Username --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="username">Username</label>
                                            <input name="username" id="username" placeholder="Enter Username here..."
                                                type="text" class="form-control @error('username') is-invalid @enderror"
                                                value="{{ old('username') }}">
                                            @error('username') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Full Name --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="name">Full Name</label>
                                            <input name="name" id="name" placeholder="Enter Full Name here..."
                                                type="text" class="form-control @error('name') is-invalid @enderror"
                                                value="{{ old('name') }}">
                                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Phone --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="phone">Phone</label>
                                            <input name="phone" id="phone" placeholder="Enter Contact Number..."
                                                type="text" class="form-control @error('phone') is-invalid @enderror"
                                                value="{{ old('phone') }}">
                                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Email --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="email">Email <span class="text-danger">*</span></label>
                                            <input name="email" id="email" placeholder="Enter valid email..."
                                                type="email" class="form-control @error('email') is-invalid @enderror"
                                                value="{{ old('email') }}">
                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Password --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="password">Password <span class="text-danger">*</span></label>
                                            <input name="password" id="password" placeholder="Enter Password..."
                                                type="password" class="form-control @error('password') is-invalid @enderror"
                                                autocomplete="new-password">
                                            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Confirm Password --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="password_confirmation">Repeat Password <span class="text-danger">*</span></label>
                                            <input name="password_confirmation" id="password_confirmation"
                                                placeholder="Repeat Password..." type="password"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                autocomplete="new-password">
                                            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Country --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="country_id">Country</label>
                                            <select name="country_id" id="country_id" class="form-control @error('country_id') is-invalid @enderror">
                                                <option value="">--- Select Country ---</option>
                                                <option value="233" {{ old('country_id') == 233 ? 'selected' : '' }}>United States</option>
                                            </select>
                                            @error('country_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- State --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="state_id">State</label>
                                            <select name="state_id" id="state_id"
                                                class="form-control @error('state_id') is-invalid @enderror">
                                                <option value="">--- Select State ---</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}" {{ old('state_id') == $state->id ? 'selected' : '' }}>
                                                        {{ ucfirst($state->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('state_id') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- City --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="city_name">City</label>
                                            <input name="city_name" id="city_name" placeholder="Enter city..."
                                                type="text" class="form-control @error('city_name') is-invalid @enderror"
                                                value="{{ old('city_name') }}">
                                            @error('city_name') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Zip Code --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="zip_code">Zip Code</label>
                                            <input name="zip_code" id="zip_code" placeholder="Enter Zip Code..."
                                                type="text" class="form-control @error('zip_code') is-invalid @enderror"
                                                value="{{ old('zip_code') }}">
                                            @error('zip_code') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                            
                                    {{-- Address --}}
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <label for="address">Address</label>
                                            <textarea name="address" id="address" placeholder="Enter Full Address..."
                                                class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                                            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            
                                {{-- Terms --}}
                                <div class="mt-3 position-relative form-check">
                                    <input name="accept_terms" id="accept_terms" type="checkbox" class="form-check-input">
                                    <label for="accept_terms" class="form-check-label">Accept our <a href="#">Terms and Conditions</a>.</label>
                                </div>
                            
                                @include('partials.cloudflare-turnstile')

                                {{-- Submit --}}
                                <div class="mt-4 d-flex align-items-center">
                                    <div class="ml-auto">
                                        <button class="btn btn-dark btn-lg btn-shadow btn-hover-shine">
                                            Create Account
                                        </button>
                                    </div>
                                </div>
                            </form>
                            

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
