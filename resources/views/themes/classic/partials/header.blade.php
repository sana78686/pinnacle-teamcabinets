@php
    $aboutUrl = $sfAboutPage
        ? route('cms.page', $sfAboutPage->slug)
        : route('cms.page', 'about');
    $blogUrl = $sfBlogPage ? route('cms.page', $sfBlogPage->slug) : null;
    $contactUrl = $sfContactPage
        ? route('cms.page', $sfContactPage->slug)
        : ($sfShowContact ? route('cms.page', 'contact') : route('cms.page').'#hz-contact');
    $phone = $settings?->phone ?? null;
@endphp
<header class="cl-header">
    <div class="hz-container cl-header__inner">
        <a href="{{ route('cms.page') }}" class="cl-logo">
            @if ($sfLogoUrl)
                <img src="{{ $sfLogoUrl }}" alt="{{ $sfCompany }}">
            @else
                <span class="cl-logo__text">{{ $sfCompany }}</span>
            @endif
        </a>
        <nav class="cl-nav" aria-label="Main">
            <a href="{{ route('cms.page') }}">Home</a>
            @if ($sfShowAbout)
                <a href="{{ $aboutUrl }}">About</a>
            @endif
            <a href="{{ route('cms.page') }}#hz-catalog-lines">Cabinetry lines</a>
            <a href="{{ route('cms.page') }}#hz-steps">Become a partner</a>
            @if ($blogUrl)
                <a href="{{ $blogUrl }}">Articles</a>
            @endif
            @foreach ($sfMenuPages as $navItem)
                <a href="{{ $navItem['url'] }}">{{ $navItem['label'] }}</a>
            @endforeach
            <a href="{{ route('cms.page') }}#hz-faq">FAQs</a>
            @if ($sfShowContact)
                <a href="{{ $contactUrl }}">Contact</a>
            @endif
        </nav>
        <div class="cl-header__cta">
            @if ($phone)
                <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}" class="cl-header__phone">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i> {{ $phone }}
                </a>
            @endif
            @auth
                @include('themes.hazel.partials.header-account', ['variant' => 'desktop'])
            @else
                <a href="{{ route('tenant_login') }}" class="hz-btn hz-btn--login hz-btn--sm">Log In</a>
                <a href="{{ route('tenant_register') }}" class="hz-btn hz-btn--gold hz-btn--sm">Get started</a>
            @endauth
            <button type="button" class="cl-menu-toggle" id="cl-menu-btn" aria-label="Open menu" aria-expanded="false" aria-controls="cl-mobile-nav">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <nav class="cl-mobile-nav" id="cl-mobile-nav" aria-label="Mobile">
        <a href="{{ route('cms.page') }}">Home</a>
        @if ($sfShowAbout)
            <a href="{{ $aboutUrl }}">About</a>
        @endif
        <a href="{{ route('cms.page') }}#hz-catalog-lines">Cabinetry lines</a>
        <a href="{{ route('cms.page') }}#hz-steps">Become a partner</a>
        @if ($blogUrl)
            <a href="{{ $blogUrl }}">Articles</a>
        @endif
        @foreach ($sfMenuPages as $navItem)
            <a href="{{ $navItem['url'] }}">{{ $navItem['label'] }}</a>
        @endforeach
        <a href="{{ route('cms.page') }}#hz-faq">FAQs</a>
        @if ($sfShowContact)
            <a href="{{ $contactUrl }}">Contact</a>
        @endif
        @if ($phone)
            <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}">{{ $phone }}</a>
        @endif
        @auth
            @include('themes.hazel.partials.header-account', ['variant' => 'mobile'])
        @else
            <a href="{{ route('tenant_login') }}">Log In</a>
            <a href="{{ route('tenant_register') }}" class="hz-btn hz-btn--gold">Get started</a>
        @endauth
    </nav>
</header>
