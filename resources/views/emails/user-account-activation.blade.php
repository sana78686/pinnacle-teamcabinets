@extends('emails.layouts.professional', [
    'branding' => tenant() ? app(\App\Services\TenantEmailService::class)->branding() : app(\App\Services\TenantEmailService::class)->centralBranding(),
    'title' => config('app.name').' - Account Activated',
    'footerNote' => 'This is an automated message. Please do not reply.',
])

@section('content')
    <h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">Welcome, {{ $user->name }}!</h2>
    <p style="margin:0 0 16px;">Great news — your account on <strong>{{ config('app.name') }}</strong> has been <strong>activated and verified</strong> by our team.</p>
    <p style="margin:0 0 20px;">You can now log in and start using all the features available to your account.</p>
    <p style="margin:0 0 24px;text-align:center;">
        <a href="{{ route('tenant_login') }}" style="display:inline-block;padding:12px 24px;background-color:#398ebd;color:#ffffff;text-decoration:none;border-radius:6px;font-weight:600;">Login to Your Account</a>
    </p>
    <p style="margin:0 0 16px;">If you did not request this account or believe this was sent in error, please contact our support team immediately.</p>
    <p style="margin:0;">Welcome aboard,<br>The <strong>{{ config('app.name') }}</strong> Team</p>
@endsection
