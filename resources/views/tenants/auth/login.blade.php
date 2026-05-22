@extends('layouts.tenant.auth')

@section('title', 'Login')

@section('content')
<x-tenant-auth-shell title="Login">
    @if(request('success'))
        <div class="tc-alert tc-alert--success">Your account was created. Sign in below — check the notification bell on your dashboard for setup steps.</div>
    @endif
    @if(session('success'))
        <div class="tc-alert tc-alert--success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="tc-alert tc-alert--error">{{ session('error') }}</div>
    @endif
    @if($errors->any() && !$errors->has('cf-turnstile-response'))
        <div class="tc-alert tc-alert--error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('tenant_login_post') }}" novalidate>
        @csrf
        <div class="tc-field">
            <label for="login">Email or username</label>
            <div class="tc-input-wrap">
                <span class="tc-icon"><i class="fa-regular fa-user" aria-hidden="true"></i></span>
                <input class="tc-input" type="text" name="login" id="login" placeholder="Email or username"
                    value="{{ old('login', Cookie::get('login')) }}" required autocomplete="username">
            </div>
        </div>
        <div class="tc-field">
            <label for="password">Password</label>
            <div class="tc-input-wrap">
                <span class="tc-icon"><i class="fa-solid fa-lock" aria-hidden="true"></i></span>
                <input class="tc-input" type="password" name="password" id="password" placeholder="Password" required autocomplete="current-password">
            </div>
        </div>
        <div class="tc-check">
            <input type="checkbox" name="remember" id="remember" value="1"
                {{ old('remember', Cookie::get('login') ? '1' : null) ? 'checked' : '' }}>
            <label for="remember">Remember me</label>
        </div>
        @include('partials.cloudflare-turnstile')
        <button type="submit" class="tc-btn">Login</button>
    </form>

    <div class="tc-auth-links tc-auth-links--split">
        <span>Forgot</span>
        <a href="{{ route('tenant_forgot_username') }}">Username</a>
        <span>/</span>
        <a href="{{ route('tenant_forgot_password') }}">Password?</a>
    </div>
    <div class="tc-auth-links">
        <a href="{{ route('tenant_register') }}">Create your account →</a>
    </div>
</x-tenant-auth-shell>
@endsection
