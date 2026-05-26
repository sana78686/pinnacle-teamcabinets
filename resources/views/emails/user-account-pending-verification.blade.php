@extends('emails.layouts.professional', [
    'branding' => tenant() ? app(\App\Services\TenantEmailService::class)->branding() : app(\App\Services\TenantEmailService::class)->centralBranding(),
    'title' => 'Account Pending Verification',
    'footerNote' => 'This is an automated message. Please do not reply.',
])

@section('content')
    <h2 style="margin:0 0 16px;font-size:20px;color:#0f172a;">Welcome {{ $user->name }}!</h2>
    <p style="margin:0 0 16px;">Your account has been successfully created. We are excited to have you join our community!</p>
    <p style="margin:0 0 20px;padding:14px 16px;background-color:#fffbeb;border:1px solid #fde68a;border-radius:6px;color:#92400e;">
        <strong>Important:</strong> Your account is currently pending admin verification. You will not be able to log in until an administrator reviews and approves your account.
    </p>
    <p style="margin:0 0 16px;">Once your account is verified by our admin team, you will receive a confirmation email and will be able to access all features of the platform.</p>
    <p style="margin:0;">We appreciate your patience during this verification process.<br><br>Best regards,<br>The {{ config('app.name') }} Team</p>
@endsection
