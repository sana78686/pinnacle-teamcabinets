@extends('emails.layouts.professional', [
    'branding' => tenant() ? app(\App\Services\TenantEmailService::class)->branding() : app(\App\Services\TenantEmailService::class)->centralBranding(),
    'title' => config('app.name').' - Account Unverified',
    'footerNote' => 'This is an automated message. Please do not reply.',
])

@section('content')
    <h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">Hello {{ $user->name }},</h2>
    <p style="margin:0 0 16px;">Thank you for registering on <strong>{{ config('app.name') }}</strong>.</p>
    <p style="margin:0 0 16px;">Your account is currently <strong>unverified</strong> and requires administrator approval before you can access the platform.</p>
    <p style="margin:0 0 20px;">We will notify you once your account is verified. If you have any questions or believe this is a mistake, please reach out to our support team.</p>
    <p style="margin:0;">Thank you for your patience,<br>The {{ config('app.name') }} Team</p>
@endsection
