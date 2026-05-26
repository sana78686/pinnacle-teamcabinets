@extends('emails.layouts.professional', [
    'branding' => tenant() ? app(\App\Services\TenantEmailService::class)->branding() : app(\App\Services\TenantEmailService::class)->centralBranding(),
    'title' => config('app.name').' - New User Registration',
    'footerNote' => 'This is an automated notification. Please do not reply.',
])

@section('content')
    <h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">New User Registration Awaiting Approval</h2>
    <p style="margin:0 0 16px;">A new user has just registered on <strong>{{ config('app.name') }}</strong> and is currently pending admin verification.</p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0 0 20px;font-size:14px;background-color:#f8fafc;border-radius:6px;">
        <tr><td style="padding:10px 14px;color:#64748b;width:140px;">Name</td><td style="padding:10px 14px;">{{ $user->name }}</td></tr>
        <tr><td style="padding:10px 14px;color:#64748b;">Email</td><td style="padding:10px 14px;">{{ $user->email }}</td></tr>
        <tr><td style="padding:10px 14px;color:#64748b;">User Type</td><td style="padding:10px 14px;">{{ ucfirst($user->role) }}</td></tr>
        <tr><td style="padding:10px 14px;color:#64748b;">Registration Date</td><td style="padding:10px 14px;">{{ $user->created_at->format('M d, Y H:i:s') }}</td></tr>
    </table>
    <p style="margin:0 0 20px;">Please review this user's details and verify their account to grant them access to the platform.</p>
    <p style="margin:0 0 24px;text-align:center;">
        <a href="{{ url('/admin/users') }}" style="display:inline-block;padding:12px 24px;background-color:#398ebd;color:#ffffff;text-decoration:none;border-radius:6px;font-weight:600;">Review User</a>
    </p>
    <p style="margin:0;">Best regards,<br>The <strong>{{ config('app.name') }}</strong> System</p>
@endsection
