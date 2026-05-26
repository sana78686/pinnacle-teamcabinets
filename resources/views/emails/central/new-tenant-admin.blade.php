@extends('emails.layouts.central', ['title' => 'New tenant registration'])

@section('body')
    <p style="margin:0 0 16px;">Hello,</p>
    <p style="margin:0 0 16px;">A new tenant has been registered on {{ config('pinnacle.name', 'Pinnacle') }}.</p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin:0 0 20px;font-size:14px;">
        <tr><td style="padding:6px 0;color:#64748b;width:120px;">Company</td><td style="padding:6px 0;"><strong>{{ $tenant->company_name ?? $tenant->name }}</strong></td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Contact</td><td style="padding:6px 0;">{{ $tenant->name }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Email</td><td style="padding:6px 0;">{{ $tenant->email }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Domain</td><td style="padding:6px 0;">{{ $tenant->domain_name ?? tenant_url($tenant->id) }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Tenant ID</td><td style="padding:6px 0;">{{ $tenant->id }}</td></tr>
    </table>
    <p style="margin:0;">Please review the tenant in the Pinnacle admin panel.</p>
@endsection
