@extends('layouts.tenant.auth')

@section('title', 'Register — ' . (tenant('company_name') ?? tenant('name') ?? config('app.name')))

@section('content')
<x-tenant-auth-shell title="Registration" :wide="true">
            @if(session('success'))
                <div class="tc-alert tc-alert--success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="tc-alert tc-alert--error">
                    <ul style="margin:0;padding-left:1.25rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('tenant_register_post') }}" novalidate>
                @csrf

                <div class="tc-register-grid">
                    <div class="tc-field">
                        <label for="role">Role</label>
                        <select class="tc-select" name="role" id="role">
                            <option value="">Select role</option>
                            @foreach (\Spatie\Permission\Models\Role::whereNotIn('name', ['admin', 'customer'])->get() as $role)
                                <option value="{{ $role->id }}" @selected(old('role') == $role->id)>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tc-field">
                        <label for="username">Username</label>
                        <input class="tc-input tc-input--plain" type="text" name="username" id="username" placeholder="Username" value="{{ old('username') }}">
                    </div>

                    <div class="tc-field">
                        <label for="full_name">Full name</label>
                        <input class="tc-input tc-input--plain" type="text" name="full_name" id="full_name" placeholder="Full name" value="{{ old('full_name') }}">
                    </div>

                    <div class="tc-field">
                        <label for="email">Email</label>
                        <input class="tc-input tc-input--plain" type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                    </div>

                    <div class="tc-field">
                        <label for="password">Password</label>
                        <input class="tc-input tc-input--plain" type="password" name="password" id="password" placeholder="Password">
                    </div>

                    <div class="tc-field">
                        <label for="country_id">Country</label>
                        <select class="tc-select" name="country_id" id="country_id">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" @selected(old('country_id', 233) == $country->id)>{{ ucfirst($country->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tc-field">
                        <label for="state_id">State</label>
                        <select class="tc-select" name="state_id" id="state_id">
                            <option value="">Select state</option>
                            @foreach ($states as $state)
                                <option value="{{ $state->id }}" @selected(old('state_id') == $state->id)>{{ ucfirst($state->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="tc-field">
                        <label for="city_name">City</label>
                        <input class="tc-input tc-input--plain" type="text" name="city_name" id="city_name" placeholder="City" value="{{ old('city_name') }}">
                    </div>

                    <div class="tc-field">
                        <label for="zip_code">Zip code</label>
                        <input class="tc-input tc-input--plain" type="text" name="zip_code" id="zip_code" placeholder="Zip code" value="{{ old('zip_code') }}">
                    </div>

                    <div class="tc-field">
                        <label for="phone">Phone</label>
                        <input class="tc-input tc-input--plain" type="text" name="phone" id="phone" placeholder="Phone" value="{{ old('phone') }}">
                    </div>

                    @if(env('GOOGLE_RECAPTCHA_KEY'))
                    <div class="tc-field tc-field--full">
                        <label>Verification</label>
                        <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                        @error('g-recaptcha-response')<p class="tc-field-hint" style="color:#991b1b;">{{ $message }}</p>@enderror
                    </div>
                    @endif
                </div>

                <button type="submit" class="tc-btn" style="margin-top:1rem;">Register</button>
            </form>

            <div class="tc-auth-links">
                <span>Already have an account?</span>
                <a href="{{ route('tenant_login') }}">Login</a>
            </div>
</x-tenant-auth-shell>
@endsection

@push('head')
@if(env('GOOGLE_RECAPTCHA_KEY'))
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endpush
