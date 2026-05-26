@extends('emails.layouts.central', ['title' => 'New tenant registered'])

@section('body')
    <h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">New tenant registered</h2>
    <p style="margin:0 0 16px;">Hello,</p>
    <p style="margin:0 0 16px;">A new tenant has registered on the {{ config('pinnacle.name', 'Pinnacle') }} platform:</p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0 0 20px;font-size:14px;">
        <tr><td style="padding:6px 0;color:#64748b;width:100px;">Company</td><td style="padding:6px 0;">{{ $tenant->company_name }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Contact</td><td style="padding:6px 0;">{{ $tenant->name }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Email</td><td style="padding:6px 0;">{{ $tenant->email }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Username</td><td style="padding:6px 0;">{{ $tenant->username }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Domain</td><td style="padding:6px 0;">{{ $tenant->domain_name }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Phone</td><td style="padding:6px 0;">{{ $tenant->phone ?? '—' }}</td></tr>
    </table>
    <p style="margin:0;"><a href="{{ $loginUrl }}" style="color:#398ebd;font-weight:600;">Open tenant login</a></p>
    <p style="margin:16px 0 0;">— Pinnacle System</p>
@endsection
