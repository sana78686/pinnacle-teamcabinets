@php
    $brandName = $tenantName ?? tenant('company_name') ?? tenant('name') ?? config('app.name');
    $heading = $heading ?? $brandName;
@endphp
@extends('emails.layouts.professional', [
    'title' => $subjectLine ?? $heading,
    'heading' => $heading,
    'subheading' => $subheading ?? null,
    'footerBrand' => $brandName,
    'simpleHeader' => true,
    'showPoweredBy' => false,
])

@section('content')
    @yield('body')
@endsection
