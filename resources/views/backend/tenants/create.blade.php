@extends('layouts.mega.master')
@section('content')


    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Add Tenants') }}
            <x-btn-link href="{{ route('tenant_index') }}" class="float-right">Back</x-btn-link>
        </h2>
    </x-slot>
    @include('partial.message')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('tenants.store') }}">
                        @csrf
                        <div class="row">
                            <!-- Name -->
                            <div class="mt-2 col-md-6">
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" class="block w-full mt-1" type="text" name="name"
                                    :value="old('name')" required autofocus autocomplete="name" placeholder="Enter Full Name"
                                    data-toggle="tooltip" title="Enter your Full Name." />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>
                            <div class="mt-2 col-md-6">
                                <x-input-label for="company_name" :value="__('Company Name')" />
                                <x-text-input id="company_name" class="block w-full mt-1" type="text" name="company_name"
                                    :value="old('company_name')" required autofocus autocomplete="company_name"
                                    placeholder="Enter Company / Business Name" data-toggle="tooltip"
                                    title="Enter the official name of your company / Business." />
                                <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                            </div>
                            {{-- <div class="mt-2 col-md-6">
                            <x-input-label for="company_name" :value="__('Company Name')" />
                            <x-text-input id="company_name" class="block w-full mt-1" type="text" name="company_name"
                                :value="old('company_name')" required autofocus autocomplete="company_name" />
                            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                        </div> --}}
                            <div class="mt-2 col-md-6">
                                <x-input-label for="domain_name" :value="__('Domain Name')" />
                                <x-text-input id="domain_name" class="block w-full mt-1" type="text" name="domain_name"
                                    :value="old('name')" required autofocus autocomplete="domain_name"
                                    placeholder="Enter Domain Name" data-toggle="tooltip"
                                    title="Enter Official Domain of Your company / Business." />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="mt-2 col-md-6">
                                <x-input-label for="username" :value="__('Username')" />
                                <x-text-input id="username" class="block w-full mt-1" type="text" name="username"
                                    :value="old('username')" required autofocus autocomplete="username"
                                    placeholder="Enter Username" data-toggle="tooltip" title="Enter your username." />
                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                            </div>
                            <div class="mt-2 col-md-6">
                                <x-input-label for="phone" :value="__('Contact')" />
                                <x-text-input id="phone" class="block w-full mt-1" type="text" name="phone"
                                    :value="old('phone')" required autofocus autocomplete="phone" placeholder="Enter contact"
                                    data-toggle="tooltip" title="Enter your contact." />
                                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                            </div>
                            <!-- Email Address -->
                            <div class="mt-2 col-md-6">
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" class="block w-full mt-1" type="email" name="email"
                                    :value="old('email')" required autocomplete="username"
                                    placeholder="Enter a valid email address" data-toggle="tooltip"
                                    title="Enter a valid email address for your business." />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div class="mt-2 col-md-6">
                                <x-input-label for="password" :value="__('Password')" />

                                <x-text-input id="password" class="block w-full mt-1" type="password" name="password"
                                    required autocomplete="new-password" placeholder="Enter your Password"
                                    data-toggle="tooltip" title="Enter your password." />

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-2 col-md-6">
                                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                                <x-text-input id="password_confirmation" class="block w-full mt-1" type="password"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Repeat Above Password" data-toggle="tooltip"
                                    title="Enter the Above Password." />

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                            <div class="mt-2 col-md-6">
                                <x-input-label for="g-recaptcha-response" :value="__('ReCaptcha')" />

                                {{-- <x-text-input id="password_confirmation" class="block w-full mt-1" type="password"
                                name="password_confirmation" required autocomplete="new-password" /> --}}

                                {{-- <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" /> --}}
                                <div class="g-recaptcha" data-sitekey="{{ env('GOOGLE_RECAPTCHA_KEY') }}"></div>
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif
                            </div>

                            <div class="mt-2 col-md-6">
                                <x-input-label for="seperate_domain" :value="__('Want a separate
                                                                            domain?')" />

                                <x-text-input id="seperate_domain" class="block mt-1" type="checkbox"
                                    name="seperate_domain" autocomplete="seperate_domain" />

                                <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
                            </div>

                            <input type="hidden" name="owner_business_name" id="owner_business_name" />
                            <input type="hidden" name="place_id" id="place_id" />
                        </div>

                        <div class="flex items-center justify-end mt-4">

                            <x-primary-button class="ms-4">
                                {{ __('Create Tenant') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.2.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.2.0/js/dataTables.bootstrap5.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Bootstrap tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        })
    </script>
    <script type="text/javascript">
        function initialize() {
            var input = document.getElementById('company_name');
            var autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                console.log('Selected place: ', place);
                if (place.place_id) {
                    // Set the hidden input field with the place_id value
                    document.getElementById('place_id').value = place.place_id;
                    console.log('Place ID: ' + place.place_id);
                }
                if (place.name) {
                    // Set the hidden input field with the business name value
                    document.getElementById('owner_business_name').value = place.name;
                    console.log('Business Name: ' + place.name);
                }
            });
        }

        // Ensure the Google Maps API is fully loaded before calling initialize()
        google.maps.event.addEventListener(window, 'load', initialize);
    </script>
    <script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZDgTTb7vm0co-2yHGinkgSs_yDTNtbSo&libraries=places&callback=initialize&loading=async"
        defer></script>

@endsection
