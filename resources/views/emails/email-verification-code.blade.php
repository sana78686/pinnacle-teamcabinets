@extends('emails.layouts.professional', [
    'branding' => tenant() ? app(\App\Services\TenantEmailService::class)->branding() : app(\App\Services\TenantEmailService::class)->centralBranding(),
    'title' => 'Email Verification Code',
    'footerNote' => 'This is an automated message. Please do not reply.',
])

@section('content')
    <h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">Email Verification Code</h2>
    <p style="margin:0 0 16px;">You have requested to change your email address. Please use the verification code below to complete the process:</p>
    <p style="margin:24px 0;text-align:center;font-size:28px;font-weight:700;letter-spacing:6px;color:#0f172a;">{{ $verificationCode }}</p>
    <p style="margin:0 0 20px;padding:14px 16px;background-color:#fffbeb;border:1px solid #fde68a;border-radius:6px;color:#92400e;">
        <strong>Important:</strong> This code expires in 10 minutes. If you did not request this email change, please ignore this message.
    </p>
    <p style="margin:0;">Best regards,<br>The {{ config('app.name') }} Team</p>
@endsection
