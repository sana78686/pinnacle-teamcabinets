@extends('layouts.tenant.auth')

@section('title', 'Reset password')

@section('content')
<x-tenant-auth-shell title="Reset password">
    <p class="tc-field-hint">Enter your email and we will send a password reset link.</p>

    @if(session('success'))
        <div class="tc-alert tc-alert--success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="tc-alert tc-alert--error">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="tc-alert tc-alert--error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('tenant_forgot_password_link') }}" novalidate>
        @csrf
        <div class="tc-field">
            <label for="email">Email</label>
            <div class="tc-input-wrap">
                <span class="tc-icon"><i class="fa-regular fa-envelope" aria-hidden="true"></i></span>
                <input class="tc-input" type="email" name="email" id="email" placeholder="you@company.com"
                    value="{{ old('email') }}" required autocomplete="email">
            </div>
        </div>
        <button type="submit" class="tc-btn">Send reset link</button>
    </form>

    <div class="tc-auth-links">
        <a href="{{ route('tenant_login') }}">← Back to login</a>
    </div>
</x-tenant-auth-shell>
@endsection
