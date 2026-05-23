<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('themes.hazel.partials.head-meta')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ tenant_static_asset('css/themes/hazel.css') }}?v=8">
    <link rel="stylesheet" href="{{ tenant_static_asset('css/themes/classic.css') }}?v=1">
    @if (!empty($sfBrandStylesheet))
        <link rel="stylesheet" href="{{ $sfBrandStylesheet }}">
    @endif
    <link rel="stylesheet" href="{{ tenant_static_asset('css/tenant-responsive.css') }}?v=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    @stack('head')
</head>
<body class="cl-body hz-body">
    @include('themes.classic.partials.header')
    <main class="cl-main hz-main">@yield('content')</main>
    @include('themes.classic.partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.getElementById('cl-menu-btn')?.addEventListener('click', function () {
            var nav = document.getElementById('cl-mobile-nav');
            var open = nav.classList.toggle('is-open');
            this.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        (function () {
            var btn = document.getElementById('hz-account-btn');
            var menu = document.getElementById('hz-account-menu');
            if (!btn || !menu) return;
            function closeMenu() { menu.hidden = true; btn.setAttribute('aria-expanded', 'false'); }
            function openMenu() { menu.hidden = false; btn.setAttribute('aria-expanded', 'true'); }
            btn.addEventListener('click', function (e) {
                e.stopPropagation();
                if (menu.hidden) openMenu(); else closeMenu();
            });
            document.addEventListener('click', function (e) {
                if (!document.getElementById('hz-account')?.contains(e.target)) closeMenu();
            });
            document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeMenu(); });
        })();
    </script>
    @stack('scripts')
</body>
</html>
