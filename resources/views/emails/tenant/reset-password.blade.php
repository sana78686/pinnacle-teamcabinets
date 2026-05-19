@extends('emails.tenant.layout', [
    'tenantName' => $tenantName,
    'heading' => 'Reset your password',
    'subheading' => $tenantName,
    'subjectLine' => 'Reset your password',
])

@section('body')
    <p>Hello {{ $user->name ?? 'there' }},</p>
    <p>We received a request to reset your password for <strong>{{ $tenantName }}</strong>.</p>
    <p style="text-align:center;margin:28px 0;">
        <a href="{{ $resetLink }}" style="display:inline-block;padding:10px 20px;background:#0c2340;color:#fff;text-decoration:none;border-radius:999px;font-weight:600;">Reset password</a>
    </p>
    <p style="font-size:14px;color:#64748b;">This link expires in 60 minutes. If you did not request a reset, ignore this email.</p>
    <p>Best regards,<br>{{ $tenantName }}</p>
@endsection
