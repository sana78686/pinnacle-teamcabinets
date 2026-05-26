@extends('emails.layouts.professional', [
    'branding' => tenant() ? app(\App\Services\TenantEmailService::class)->branding() : app(\App\Services\TenantEmailService::class)->centralBranding(),
    'title' => 'Password Changed',
])

@section('content')
    <h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">Password Changed Successfully</h2>
    <p style="margin:0 0 16px;">Hi {{ $user->name }},</p>
    <p style="margin:0 0 16px;">Your password was successfully changed on <strong>{{ $changedAt }}</strong>.</p>
    <p style="margin:0 0 16px;">If this was you, no further action is required.</p>
    <p style="margin:0 0 20px;">If you did not make this change, please reset your password immediately.</p>
    <p style="margin:0 0 24px;text-align:center;">
        <a href="{{ url('/forgot-password') }}" style="display:inline-block;padding:12px 24px;background-color:#398ebd;color:#ffffff;text-decoration:none;border-radius:6px;font-weight:600;">Reset Password</a>
    </p>
    <p style="margin:0;">Thanks,<br>{{ config('app.name') }}</p>
@endsection
