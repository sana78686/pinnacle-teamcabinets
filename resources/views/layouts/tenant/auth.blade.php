<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', ucfirst(tenant('company_name') ?? tenant('name') ?? config('app.name')))</title>
    <link rel="icon" href="{{ asset('assets/logo/pinnacle-favicon.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/tenant-auth.css') }}?v=4">
    <link rel="stylesheet" href="{{ asset('css/tenant-forms.css') }}?v=3">
    <link rel="stylesheet" href="{{ asset('css/tenant-tooltips.css') }}?v=1">
    @stack('head')
</head>
<body class="tc-auth-body">
    <main class="tc-auth-main">
        @yield('content')
    </main>
    <footer class="tc-auth-footer">
        @php $footerName = tenant('company_name') ?? tenant('name') ?? config('app.name'); @endphp
        <p>&copy; {{ now()->year }} {{ $footerName }}. All rights reserved.</p>
    </footer>
    <script>window.TENANT_FIELD_TIPS = @json(config('tenant_field_tips', []));</script>
    <script src="{{ asset('js/tenant-tooltips.js') }}?v=1"></script>
    @stack('scripts')
</body>
</html>
