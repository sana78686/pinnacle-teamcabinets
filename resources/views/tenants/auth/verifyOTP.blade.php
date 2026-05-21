@extends('layouts.tenant.auth')

@section('title', 'Verify OTP')

@section('content')
<x-tenant-auth-shell title="Verify OTP">
    <p class="tc-field-hint">Enter the 6-digit code sent to your email.</p>

    @if(!empty($success))
        <div class="tc-alert tc-alert--success">{{ $success }}</div>
    @endif
    @if(session('success'))
        <div class="tc-alert tc-alert--success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="tc-alert tc-alert--error">{{ session('error') }}</div>
    @endif
    @if($errors->has('otp'))
        <div class="tc-alert tc-alert--error">{{ $errors->first('otp') }}</div>
    @endif

    <form method="POST" action="{{ route('otp.verify.submit') }}" novalidate>
        @csrf
        <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
        <div class="tc-field">
            <label for="otp">One-time code</label>
            <div class="tc-input-wrap">
                <span class="tc-icon"><i class="fa-solid fa-key" aria-hidden="true"></i></span>
                <input class="tc-input" type="text" name="otp" id="otp" placeholder="000000" maxlength="6"
                    value="{{ old('otp') }}" required inputmode="numeric" autocomplete="one-time-code">
            </div>
        </div>
        @include('partials.cloudflare-turnstile')
        <button type="submit" class="tc-btn">Verify</button>
    </form>

    <div class="tc-auth-links">
        <span>Didn't get the code?</span>
        <form method="POST" action="{{ route('otp.resend') }}" class="tc-inline-form">
            @csrf
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">
            @include('partials.cloudflare-turnstile', ['class' => 'cf-turnstile-wrap--inline'])
            <button type="submit" class="tc-btn-link">Resend now</button>
        </form>
    </div>
    <div class="tc-auth-links">
        <a href="{{ route('tenant_login') }}">← Back to login</a>
    </div>
</x-tenant-auth-shell>
@endsection
