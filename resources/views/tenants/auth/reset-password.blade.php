@extends('layouts.tenant.auth')

@section('title', 'Set new password')

@section('content')
<x-tenant-auth-shell title="Set new password">
    @if(session('success'))
        <div class="tc-alert tc-alert--success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="tc-alert tc-alert--error">{{ session('error') }}</div>
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

    <form method="POST" action="{{ route('tenant.password.update') }}" novalidate>
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="tc-field">
            <label for="password">New password</label>
            <div class="tc-input-wrap">
                <span class="tc-icon"><i class="fa-solid fa-lock" aria-hidden="true"></i></span>
                <input class="tc-input" type="password" name="password" id="password" placeholder="New password" required autocomplete="new-password">
            </div>
        </div>
        <div class="tc-field">
            <label for="password_confirmation">Confirm password</label>
            <div class="tc-input-wrap">
                <span class="tc-icon"><i class="fa-solid fa-lock" aria-hidden="true"></i></span>
                <input class="tc-input" type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" required autocomplete="new-password">
            </div>
        </div>
        @include('partials.cloudflare-turnstile')
        <button type="submit" class="tc-btn">Update password</button>
    </form>

    <div class="tc-auth-links">
        <a href="{{ route('tenant_login') }}">← Back to login</a>
    </div>
</x-tenant-auth-shell>
@endsection
