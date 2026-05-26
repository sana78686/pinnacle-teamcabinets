@extends('emails.layouts.professional', [
    'branding' => app(\App\Services\TenantEmailService::class)->branding(),
    'title' => 'Contact form message',
])

@section('content')
    <p style="margin:0 0 16px;">You have received a new message from the contact form:</p>
    <p style="margin:0 0 8px;"><strong>From:</strong> {{ $from }}</p>
    <p style="margin:16px 0 8px;font-weight:600;">Message</p>
    <p style="margin:0;white-space:pre-wrap;">{{ $bodyMessage }}</p>
@endsection
