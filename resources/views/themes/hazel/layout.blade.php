<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', tenant('company_name') ?? tenant('name') ?? config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', 'Wholesale RTA cabinets for dealers, showrooms, and contractors.')">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ tenant_static_asset('css/themes/hazel.css') }}?v=3">
    @stack('head')
</head>
<body class="hz-body">
    @include('themes.hazel.partials.header')
    <main>@yield('content')</main>
    @include('themes.hazel.partials.footer')
    <script>
        document.getElementById('hz-menu-btn')?.addEventListener('click', function () {
            var nav = document.getElementById('hz-mobile-nav');
            var open = nav.classList.toggle('is-open');
            this.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    </script>
    @stack('scripts')
</body>
</html>
