@component('mail::message')

Welcome to Pinnacle



Name: {{ $mailData['name'] }}<br/>

Email: {{ $mailData['email'] }}



Thanks,<br/>

{{ config('app.name') }}

@endcomponent
