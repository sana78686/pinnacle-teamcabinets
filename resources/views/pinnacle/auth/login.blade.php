@extends('pinnacle.layouts.auth')

@section('title', 'Super admin login — Pinnacle')

@section('content')
<div class="pn-container pn-auth-login">
    <div class="pn-auth-form-plain pn-auth-form-plain--card">
        <h1 class="pn-auth-form-plain__title">Super admin login</h1>
        <p class="pn-auth-form-plain__sub">Sign in to manage tenants and the central platform.</p>

        @if (session('success'))
            <div class="pn-alert pn-alert--success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="pn-alert pn-alert--error">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login_post') }}" class="pn-auth-form-plain__form">
            @csrf
            <div class="pn-form-grid">
                <div class="pn-field">
                    @include('pinnacle.partials.form-label', [
                        'for' => 'email',
                        'label' => 'Email',
                        'required' => true,
                        'tip' => 'Your Pinnacle super-admin email address.',
                    ])
                    <input type="email" name="email" id="email" class="pn-input pn-input--lg @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" placeholder="admin@example.com" required autofocus autocomplete="email">
                    @error('email')<p class="pn-field-error">{{ $message }}</p>@enderror
                </div>

                <div class="pn-field">
                    @include('pinnacle.partials.form-label', [
                        'for' => 'password',
                        'label' => 'Password',
                        'required' => true,
                        'tip' => 'Your account password.',
                    ])
                    <input type="password" name="password" id="password" class="pn-input pn-input--lg @error('password') is-invalid @enderror"
                        placeholder="Enter your password" required autocomplete="current-password">
                    @error('password')<p class="pn-field-error">{{ $message }}</p>@enderror
                </div>
            </div>

            <button type="submit" class="pn-btn pn-btn--primary pn-btn--block pn-btn--lg">Sign in</button>
        </form>

        <p class="pn-auth-form-plain__foot">
            Registering a cabinets business? <a href="{{ route('registeration') }}">Create tenant account</a>
        </p>
        <p class="pn-auth-form-plain__foot">
            <a href="{{ route('/') }}">← Back to Pinnacle home</a>
        </p>
    </div>
</div>
@endsection
