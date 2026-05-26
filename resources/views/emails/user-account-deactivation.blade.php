@extends('emails.layouts.professional', [
    'branding' => tenant() ? app(\App\Services\TenantEmailService::class)->branding() : app(\App\Services\TenantEmailService::class)->centralBranding(),
    'title' => config('app.name').' - Account Deactivated',
    'footerNote' => 'This is an automated message. Please do not reply.',
])

@section('content')
    <h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">Hello {{ $user->name }},</h2>
    <p style="margin:0 0 16px;">We wanted to inform you that your account on <strong>{{ config('app.name') }}</strong> has been <strong>deactivated</strong> by the administrator.</p>
    <p style="margin:0 0 16px;">This means you will no longer be able to log in or access your account until it is reactivated.</p>
    <p style="margin:0 0 20px;">If you believe this was a mistake or wish to appeal this decision, please contact our support team for assistance.</p>
    <p style="margin:0;">Thank you for your understanding,<br>The <strong>{{ config('app.name') }}</strong> Team</p>
@endsection
