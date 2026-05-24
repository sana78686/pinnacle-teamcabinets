@php
    $aboutUrl = $sfAboutPage ? route('cms.page', $sfAboutPage->slug) : route('cms.page', 'about');
    $blogUrl = $sfBlogPage ? route('cms.page', $sfBlogPage->slug) : null;
    $contactUrl = $sfContactPage
        ? route('cms.page', $sfContactPage->slug)
        : ($sfShowContact ? route('cms.page', 'contact') : route('cms.page').'#md-contact');
    $phone = $settings?->phone ?? null;
@endphp
<div class="bg-md-ink text-center text-xs font-medium tracking-wide text-white">
    <div class="mx-auto max-w-md-page px-4 py-2">
        Built-to-order cabinets — dealer &amp; trade portal for {{ $sfCompany }}
    </div>
</div>
<header class="sticky top-0 z-50 border-b border-md-line bg-white/95 shadow-sm backdrop-blur">
    <div class="mx-auto flex max-w-md-page items-center justify-between gap-4 px-4 py-3 lg:px-6">
        <a href="{{ route('cms.page') }}" class="shrink-0">
            @if ($sfLogoUrl)
                <img src="{{ $sfLogoUrl }}" alt="{{ $sfCompany }}" class="h-10 w-auto md:h-12">
            @else
                <span class="text-lg font-bold tracking-tight text-md-ink">{{ $sfCompany }}</span>
            @endif
        </a>
        <nav class="hidden items-center gap-6 text-sm font-medium text-md-ink lg:flex" aria-label="Main">
            <a href="{{ route('cms.page') }}" class="hover:text-md-gold">Home</a>
            @if ($sfShowAbout)
                <a href="{{ $aboutUrl }}" class="hover:text-md-gold">About</a>
            @endif
            <a href="{{ route('cms.page') }}#md-door-styles" class="hover:text-md-gold">Door styles</a>
            <a href="{{ route('cms.page') }}#md-gallery" class="hover:text-md-gold">Gallery</a>
            @if ($blogUrl)
                <a href="{{ $blogUrl }}" class="hover:text-md-gold">Articles</a>
            @endif
            @foreach ($sfMenuPages as $navItem)
                <a href="{{ $navItem['url'] }}" class="hover:text-md-gold">{{ $navItem['label'] }}</a>
            @endforeach
            @if ($sfShowContact)
                <a href="{{ $contactUrl }}" class="hover:text-md-gold">Contact</a>
            @endif
        </nav>
        <div class="flex items-center gap-2">
            @if ($phone)
                <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}" class="hidden text-sm font-medium text-md-ink hover:text-md-gold md:inline-flex">
                    <i class="fa-solid fa-phone mr-1" aria-hidden="true"></i>{{ $phone }}
                </a>
            @endif
            @auth
                @include('themes.modern.partials.header-account', ['variant' => 'desktop'])
            @else
                <a href="{{ route('tenant_login') }}" class="hidden rounded-full border border-md-ink px-4 py-2 text-sm font-semibold text-md-ink hover:bg-md-cream sm:inline-flex">Sign in</a>
                <a href="{{ route('tenant_register') }}" class="md-btn md-btn--dark !px-5 !py-2 text-xs">Get started</a>
            @endauth
            <button type="button" id="md-menu-btn" class="inline-flex h-10 w-10 items-center justify-center rounded border border-md-line lg:hidden" aria-label="Open menu" aria-expanded="false" aria-controls="md-mobile-nav">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <nav id="md-mobile-nav" class="hidden border-t border-md-line bg-white px-4 py-4 lg:hidden" aria-label="Mobile">
        <div class="flex flex-col gap-3 text-sm font-medium">
            <a href="{{ route('cms.page') }}">Home</a>
            @if ($sfShowAbout)<a href="{{ $aboutUrl }}">About</a>@endif
            <a href="{{ route('cms.page') }}#md-door-styles">Door styles</a>
            <a href="{{ route('cms.page') }}#md-gallery">Gallery</a>
            @if ($blogUrl)<a href="{{ $blogUrl }}">Articles</a>@endif
            @foreach ($sfMenuPages as $navItem)<a href="{{ $navItem['url'] }}">{{ $navItem['label'] }}</a>@endforeach
            @if ($sfShowContact)<a href="{{ $contactUrl }}">Contact</a>@endif
            @auth
                @include('themes.modern.partials.header-account', ['variant' => 'mobile'])
            @else
                <a href="{{ route('tenant_login') }}">Sign in</a>
                <a href="{{ route('tenant_register') }}" class="md-btn md-btn--dark w-full">Get started</a>
            @endauth
        </div>
    </nav>
</header>
