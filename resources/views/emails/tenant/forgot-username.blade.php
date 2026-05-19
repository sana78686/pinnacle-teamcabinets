@extends('emails.tenant.layout', [
    'tenantName' => $tenantName,
    'heading' => 'Username reminder',
    'subheading' => $tenantName,
    'subjectLine' => 'Your username',
])

@section('body')
    <p>Hello {{ $user->name ?? 'there' }},</p>
    <p>You requested a reminder of your username for <strong>{{ $tenantName }}</strong>.</p>
    <p style="margin:20px 0;padding:16px;background:#f1f5f9;border-radius:8px;font-size:18px;">
        <strong>Username:</strong> {{ $user->username }}
    </p>
    <p><a href="{{ $loginUrl }}" style="display:inline-block;padding:10px 20px;background:#0c2340;color:#fff;text-decoration:none;border-radius:999px;">Sign in</a></p>
    <p style="font-size:14px;color:#64748b;">If you did not request this, you can ignore this email.</p>
    <p>Best regards,<br>{{ $tenantName }}</p>
@endsection
