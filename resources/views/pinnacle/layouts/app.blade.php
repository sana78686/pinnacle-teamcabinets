<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', 'Pinnacle — Platform for cabinet distributors. Website, dealer portal, orders, and QuickBooks.')">
    <title>@yield('title', $pinnacle['name'] ?? 'Pinnacle') | Cabinets platform for distributors</title>
    <link rel="icon" href="{{ asset('assets/logo/pinnacle-favicon.png') }}" type="image/png">
    <link rel="preload" href="{{ asset('css/pinnacle-theme.css') }}?v=12" as="style">
    <link rel="stylesheet" href="{{ asset('css/pinnacle-theme.css') }}?v=12">
    {{-- Powered by {{ config('pinnacle.powered_by', 'apimstec') }} (not shown in UI) --}}
    @stack('head')
</head>
<body class="pn-body">
    @php $pinnacle = $pinnacle ?? config('pinnacle'); @endphp
    @include('pinnacle.partials.nav')
    @include('pinnacle.partials.breadcrumbs')
    <main>@yield('content')</main>
    @include('pinnacle.partials.footer')
    <script src="{{ asset('js/pinnacle.js') }}?v=7" defer></script>
    @stack('scripts')
</body>
</html>
