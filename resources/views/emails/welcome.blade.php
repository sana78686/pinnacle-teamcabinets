@extends('emails.layouts.central', ['title' => 'Welcome to '.config('pinnacle.name', 'Pinnacle')])

@section('body')
    <p style="margin:0 0 16px;">Welcome to {{ config('pinnacle.name', 'Pinnacle') }}</p>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size:14px;">
        <tr><td style="padding:6px 0;color:#64748b;width:80px;">Name</td><td style="padding:6px 0;">{{ $mailData['name'] ?? '' }}</td></tr>
        <tr><td style="padding:6px 0;color:#64748b;">Email</td><td style="padding:6px 0;">{{ $mailData['email'] ?? '' }}</td></tr>
    </table>
    <p style="margin:20px 0 0;">Thanks,<br>{{ config('app.name') }}</p>
@endsection
