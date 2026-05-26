@extends('emails.layouts.professional', [
    'branding' => app(\App\Services\TenantEmailService::class)->centralBranding(),
    'title' => $title ?? config('pinnacle.name', 'Pinnacle'),
    'simpleHeader' => false,
    'showPoweredBy' => false,
])

@section('content')
    @yield('body')
@endsection
