@extends('emails.layouts.central', ['title' => 'Welcome to '.config('pinnacle.name', 'Pinnacle')])

@section('body')
    <p style="margin:0 0 16px;">Dear {{ $tenant->name ?? $tenant->company_name }},</p>
    <p style="margin:0 0 16px;">Your cabinets business tenant has been created successfully. You can sign in to your management panel using the link below.</p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0 0 20px;font-size:14px;">
        <tr><td style="padding:6px 0;color:#64748b;width:100px;">Company</td><td style="padding:6px 0;">{{ $tenant->company_name }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Email</td><td style="padding:6px 0;">{{ $tenant->email }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Your site</td><td style="padding:6px 0;"><a href="{{ $loginUrl }}" style="color:#398ebd;">{{ $tenant->domain_name ?? $loginUrl }}</a></td></tr>
    </table>
    <p style="margin:0 0 24px;text-align:center;">
        <a href="{{ $loginUrl }}" style="display:inline-block;padding:12px 24px;background-color:#398ebd;color:#ffffff;text-decoration:none;border-radius:6px;font-weight:600;">Sign in to your tenant</a>
    </p>
    <p style="margin:0;">If you have any questions, contact our support team.<br><br>Best regards,<br>The Pinnacle Team</p>
@endsection
