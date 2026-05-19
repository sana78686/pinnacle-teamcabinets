<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pinnacle')</title>
    <link rel="icon" href="{{ asset('assets/logo/pinnacle-favicon.png') }}" type="image/png">
    <link rel="preload" href="{{ asset('css/pinnacle-theme.css') }}?v=9" as="style">
    <link rel="stylesheet" href="{{ asset('css/pinnacle-theme.css') }}?v=9">
    {{-- Powered by {{ config('pinnacle.powered_by', 'apimstec') }} (not shown in UI) --}}
    @stack('head')
</head>
<body class="pn-body">
    @php $pinnacle = config('pinnacle'); @endphp
    @include('pinnacle.partials.nav')
    @include('pinnacle.partials.breadcrumbs')
    <main class="pn-auth-main">@yield('content')</main>
    @include('pinnacle.partials.footer-minimal')
    <script src="{{ asset('js/pinnacle.js') }}?v=6" defer></script>
    @stack('scripts')
</body>
</html>
