@extends('layouts.auth')
@section('styles')

{{-- <script type="text/javascript"
src="https://maps.google.com/maps/api/js?key=AIzaSyCZDgTTb7vm0co-2yHGinkgSs_yDTNtbSo&libraries=places&callback=initialize&loading=async">
</script> --}}
<style>
    .responsive-image {
        height: 300px; /* Default height for larger screens */
        width: auto;
    }

    @media (max-width: 576px) { /* Adjust for mobile screens */
        .responsive-image {
            height: 150px; /* Height for mobile */
        }
    }
</style>

@endsection
@section('content')
    <div class="container-fluid">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-md-9 col-lg-3 col-xl-2">
                <div style="display: flex; justify-content: center; align-items: center;">
                    <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />

                    {{-- <img src="{{ asset('assets/logo/team_cabinets.jpg') }}"
                         alt="Sample image"
                         class="responsive-image"> --}}
                </div>
            </div>
            <div class="col-md-8 col-lg-9 col-xl-8 offset-xl-1">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Error messages for inputs -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('tenants.store') }}">
                    @csrf


                    <div class="row">
                        <div class="col-md-6">
                            <div data-mdb-input-init class="mb-3 form-outline d-flex align-items-center">
                                <label class="form-label" style="width: 40%" for="form3Example3">Full Name</label>
                                <input type="text" id="form3Example3"
                                    class="form-control form-control-lg @error('full_name') is-invalid @enderror"
                                    placeholder="Enter Full Name" name="full_name" value="{{ old('full_name') }}" autofocus
                                    required data-toggle="tooltip" title="Enter your Full Name." />
                            </div>
                            @error('full_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div data-mdb-input-init class="mb-3 form-outline d-flex align-items-center">
                                <label class="form-label" style="width: 40%" for="contact">Contact</label>
                                <input type="text" id="contact"
                                    class="form-control form-control-lg @error('contact') is-invalid @enderror"
                                    placeholder="Enter contact number" name="contact" value="{{ old('contact') }}" autofocus
                                    required data-toggle="tooltip" title="Enter a valid Phone Number." />
                            </div>
                            @error('contact')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <div data-mdb-input-init class="mb-3 form-outline d-flex align-items-center">
                                <label class="form-label" style="width: 40%" for="email">Email Address</label>
                                <input type="email" id="email"
                                    class="form-control form-control-lg @error('email') is-invalid @enderror"
                                    placeholder="Enter a valid email address" name="email" value="{{ old('email') }}"
                                    autofocus required data-toggle="tooltip"
                                    title="Enter a valid email address for your business." />
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <div data-mdb-input-init class="mb-3 form-outline d-flex align-items-center">
                                <label class="form-label" style="width: 40%" for="business_name">Business Name / URL</label>
                                <input type="text" id="business_name" name="business_name"
                                    class="form-control form-control-lg @error('business_name') is-invalid @enderror"
                                    placeholder="Enter Business Name" required data-toggle="tooltip"
                                    title="Enter the official name of your business." />
                            </div>
                            @error('business_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        {{-- <div class="mb-3 form-outline">
                            <span data-toggle="tooltip" title="Click to Reset Your Review Link.">
                                <a href="{{ route('review.reset') }}">
                                    Reset your Business Review Link Here.
                                </a>
                            </span>
                        </div> --}}

                        <div class="col-md-6">
                            <input type="hidden" name="owner_business_name" id="owner_business_name" />
                            <input type="hidden" name="place_id" id="place_id" />
                            <div class="pt-2 mt-0 text-center text-lg-start">
                                <button type="submit" class="btn btn-primary btn-lg"
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;background-color:#00214f">Next</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
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
            var input = document.getElementById('business_name');
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
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZDgTTb7vm0co-2yHGinkgSs_yDTNtbSo&libraries=places&callback=initialize&loading=async" defer></script>

    {{-- <script>
        function initialize() {
            var input = document.getElementById('business_name');
            var autocomplete = new google.maps.places.Autocomplete(input);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();
                if (place.place_id) {
                    document.getElementById('place_id').value = place.place_id;
                }
                if (place.name) {
                    document.getElementById('owner_business_name').value = place.name;
                }
            });

            console.log('Autocomplete initialized');
        }

        // Ensure initialization works
        google.maps.event.addDomListener(window, 'load', initialize);
    </script> --}}


@endsection
