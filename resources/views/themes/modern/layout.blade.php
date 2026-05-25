<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('themes.modern.partials.head-meta')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        md: {
                            ink: '#1a1a1a',
                            slate: '#2d3e50',
                            gold: '#b8956b',
                            cream: '#f4f4f4',
                            line: '#e5e7eb',
                        },
                    },
                    maxWidth: {
                        'md-page': '1280px',
                    },
                    fontFamily: {
                        sans: ['"Helvetica Neue"', 'Helvetica', 'Arial', 'sans-serif'],
                    },
                },
            },
        };
    </script>
    <link rel="stylesheet" href="{{ tenant_static_asset('css/themes/modern-components.css') }}?v=1">
    <link rel="stylesheet" href="{{ tenant_static_asset('css/storefront-chrome.css') }}?v=7">
    @if (file_exists(public_path('css/themes/modern.css')))
        <link rel="stylesheet" href="{{ tenant_static_asset('css/themes/modern.css') }}?v=1">
    @endif
    @if (!empty($sfBrandStylesheet))
        <link rel="stylesheet" href="{{ $sfBrandStylesheet }}">
    @endif
    <link rel="stylesheet" href="{{ tenant_static_asset('css/tenant-responsive.css') }}?v=1">
    <link rel="stylesheet" href="{{ tenant_static_asset('css/storefront-responsive.css') }}?v=2">
    @stack('head')
</head>
<body class="bg-white font-sans text-md-ink antialiased sf-storefront">
    @include('themes.modern.partials.header')
    <main>@yield('content')</main>
    @include('themes.modern.partials.footer')
    @include('partials.storefront.chrome')
    <script src="{{ tenant_static_asset('js/storefront-nav.js') }}?v=1"></script>
    <script>
        (function () {
            var accountBtn = document.getElementById('md-account-btn');
            var accountMenu = document.getElementById('md-account-menu');
            if (accountBtn && accountMenu) {
                accountBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    accountMenu.classList.toggle('hidden');
                });
                document.addEventListener('click', function () {
                    accountMenu.classList.add('hidden');
                });
            }
            document.querySelectorAll('[data-md-gallery-prev]').forEach(function (el) {
                el.addEventListener('click', function () {
                    var track = document.getElementById('md-gallery-track');
                    if (track) track.scrollBy({ left: -480, behavior: 'smooth' });
                });
            });
            document.querySelectorAll('[data-md-gallery-next]').forEach(function (el) {
                el.addEventListener('click', function () {
                    var track = document.getElementById('md-gallery-track');
                    if (track) track.scrollBy({ left: 480, behavior: 'smooth' });
                });
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
