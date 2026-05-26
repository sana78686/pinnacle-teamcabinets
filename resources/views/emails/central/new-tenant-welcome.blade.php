@extends('emails.layouts.central', ['title' => 'Welcome to '.config('pinnacle.name', 'Pinnacle')])

@section('body')
    <p style="margin:0 0 16px;">Dear {{ $tenant->name ?? 'User' }},</p>
    <p style="margin:0 0 16px;">Your dealer account <strong>{{ $tenant->company_name ?? $tenant->name }}</strong> has been created on {{ config('pinnacle.name', 'Pinnacle') }}.</p>
    <p style="margin:0 0 16px;">{{ config('pinnacle.portal.registration_success_message') }}</p>
    <p style="margin:0 0 12px;">You can sign in here:</p>
    <p style="margin:0 0 20px;"><a href="{{ $loginUrl }}" style="color:#398ebd;text-decoration:none;font-weight:600;">{{ $loginUrl }}</a></p>
    <p style="margin:0 0 16px;">Questions? Contact <a href="mailto:{{ config('pinnacle.support_email') }}" style="color:#398ebd;">{{ config('pinnacle.support_email') }}</a>.</p>
    <p style="margin:0;">If you did not request this account, please contact support.</p>
@endsection
