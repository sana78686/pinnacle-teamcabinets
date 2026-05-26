@extends('emails.layouts.professional', [
    'branding' => tenant() ? app(\App\Services\TenantEmailService::class)->branding() : app(\App\Services\TenantEmailService::class)->centralBranding(),
    'title' => 'Account Verified',
    'footerNote' => 'This is an automated message. Please do not reply.',
])

@section('content')
    <h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">Congratulations {{ $user->name }}!</h2>
    <p style="margin:0 0 16px;"><strong>Great news!</strong> Your account has been successfully verified by our admin team.</p>
    <p style="margin:0 0 16px;">You can now log in to your account and access all the features of our platform.</p>
    <p style="margin:0 0 16px;">If you have any questions or need assistance, please contact our support team.</p>
    <p style="margin:0;">Best regards,<br>The {{ config('app.name') }} Team</p>
@endsection
