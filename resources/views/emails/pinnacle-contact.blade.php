@extends('emails.layouts.central', ['title' => 'Pinnacle contact form'])

@section('body')
    <p style="margin:0 0 16px;">New message from the Pinnacle contact form:</p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px;">
        <tr><td style="padding:6px 0;color:#64748b;width:100px;">Name</td><td style="padding:6px 0;"><strong>{{ $name }}</strong></td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Email</td><td style="padding:6px 0;">{{ $from }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Phone</td><td style="padding:6px 0;">{{ $phone }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Type</td><td style="padding:6px 0;">{{ $inquiry }}</td></tr>
    </table>
    <p style="margin:20px 0 8px;font-weight:600;">Message</p>
    <p style="margin:0;white-space:pre-wrap;">{{ $bodyMessage }}</p>
@endsection
