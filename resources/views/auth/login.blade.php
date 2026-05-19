@extends('layouts.auth')
@section('styles')

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
            <div class="col-md-9 col-lg-6 col-xl-5">
                <div style="display: flex; justify-content: center; align-items: center;">
                    <x-application-logo class="block w-auto text-gray-800 fill-current h-9" />

                    {{-- <img src="{{ asset('assets/logo/team_cabinets.jpg') }}"
                         alt="Sample image"
                         class="responsive-image"> --}}
                </div>
            </div>
            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="text:red">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login_post') }}">
                    @csrf

                    <!-- Email input -->
                    <div data-mdb-input-init class="mb-4 form-outline">
                        <label class="form-label" for="form3Example3">Email address</label>
                        <input type="email" id="form3Example3"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            placeholder="Enter a valid email address" name="email" value="{{ old('email') }}"
                            autofocus />
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password input -->
                    <div data-mdb-input-init class="mb-3 form-outline">
                        <label class="form-label" for="form3Example4">Password</label>
                        <input type="password" id="form3Example4"
                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                            placeholder="Enter password" name="password" />
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="pt-2 mt-4 text-center text-lg-start">
                        <button type="submit" class="btn btn-secondary btn-lg"
                            style="padding-left: 2.5rem; padding-right: 2.5rem;background-color:#00214f">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
