@extends('emails.tenant.layout', [
    'tenantName' => $tenantName,
    'heading' => 'Your login code',
    'subheading' => $tenantName,
    'subjectLine' => 'Your login OTP',
])

@section('body')
    <p>Hello{{ !empty($userName) ? ' '.$userName : '' }},</p>
    <p>Use this one-time code to complete sign-in to <strong>{{ $tenantName }}</strong>:</p>
    <p style="text-align:center;margin:24px 0;font-size:28px;font-weight:700;letter-spacing:6px;color:#0c2340;">{{ $otp }}</p>
    <p style="font-size:14px;color:#64748b;">This code expires in 10 minutes. If you did not try to sign in, ignore this email.</p>
    <p>Best regards,<br>{{ $tenantName }}</p>
@endsection
