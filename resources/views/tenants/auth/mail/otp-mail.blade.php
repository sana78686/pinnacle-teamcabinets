@extends('emails.layouts.professional', [
    'branding' => app(\App\Services\TenantEmailService::class)->branding(),
    'title' => 'Your OTP Code',
    'heading' => 'Your OTP Code',
    'simpleHeader' => true,
    'showPoweredBy' => false,
])

@section('content')
    <p style="margin:0 0 16px;">Hello,</p>
    <p style="margin:0 0 16px;">We received a request to verify your login. Please use the OTP code below to complete the process:</p>
    <p style="margin:24px 0;text-align:center;font-size:28px;font-weight:700;letter-spacing:6px;color:#0f172a;border:2px dashed #398ebd;padding:16px;border-radius:8px;">{{ $otp }}</p>
    <p style="margin:0 0 16px;">This OTP will expire in <strong>10 minutes</strong>. If you did not request this, you can ignore this email.</p>
    <p style="margin:0;">Thank you,<br>The Support Team</p>
@endsection
