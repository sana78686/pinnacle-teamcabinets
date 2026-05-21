@php
    $company = tenant('company_name') ?? tenant('name') ?? config('app.name');
    $phone = $settings?->phone ?? null;
    $aboutPage = $aboutPage ?? \App\Models\Page::findAboutPage();
    $blogPage = $blogPage ?? \App\Models\Page::findBlogPage();
    $contactPage = $contactPage ?? \App\Models\Page::findContactPage();
    $reservedSlugs = ['about', 'about-us', 'blog', 'contact', 'contact-us'];
    $navPages = \App\Models\Page::query()
        ->where('status', 'published')
        ->whereNull('parent_id')
        ->whereNotIn('slug', $reservedSlugs)
        ->where('show_in_menu', true)
        ->orderBy('order_no')
        ->limit(6)
        ->get();
    $aboutUrl = $aboutPage ? route('cms.page', $aboutPage->slug) : route('cms.page').'#hz-difference';
    $blogUrl = $blogPage ? route('cms.page', $blogPage->slug) : route('cms.page');
@endphp
<header class="hz-header hz-header--dark">
    <div class="hz-container hz-header__inner">
        <a href="{{ route('cms.page') }}" class="hz-logo">
            @if (!empty($settings?->logo))
                <img src="{{ asset($settings->logo) }}" alt="{{ $company }}">
            @else
                <span class="hz-logo__badge">{{ $company }}</span>
            @endif
        </a>
        <nav class="hz-nav" aria-label="Main">
            <a href="{{ route('cms.page') }}">Home</a>
            <a href="{{ $aboutUrl }}">About</a>
            <a href="{{ route('cms.page') }}#hz-catalog-lines">Cabinetry lines</a>
            <a href="{{ route('cms.page') }}#hz-steps">Become a partner</a>
            <a href="{{ $blogUrl }}">Blog</a>
            @foreach ($navPages as $navPage)
                <a href="{{ route('cms.page', $navPage->slug) }}">{{ $navPage->title }}</a>
            @endforeach
            <a href="{{ route('cms.page') }}#hz-faq">FAQs</a>
            @if ($contactPage)
                <a href="{{ route('cms.page', $contactPage->slug) }}">Contact</a>
            @else
                <a href="{{ route('cms.page') }}#hz-contact">Contact</a>
            @endif
        </nav>
        <div class="hz-header__cta">
            @if ($phone)
                <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}" class="hz-header__phone">
                    <i class="fa-solid fa-phone" aria-hidden="true"></i> {{ $phone }}
                </a>
            @endif
            <a href="{{ route('tenant_login') }}" class="hz-btn hz-btn--login hz-btn--sm">Log In</a>
            <a href="{{ route('tenant_register') }}" class="hz-btn hz-btn--gold hz-btn--sm">Get started</a>
            <button type="button" class="hz-menu-toggle" id="hz-menu-btn" aria-label="Open menu" aria-expanded="false" aria-controls="hz-mobile-nav">
                <i class="fa-solid fa-bars" aria-hidden="true"></i>
            </button>
        </div>
    </div>
    <nav class="hz-mobile-nav hz-mobile-nav--dark" id="hz-mobile-nav" aria-label="Mobile">
        <a href="{{ route('cms.page') }}">Home</a>
        <a href="{{ $aboutUrl }}">About</a>
        <a href="{{ route('cms.page') }}#hz-catalog-lines">Cabinetry lines</a>
        <a href="{{ route('cms.page') }}#hz-steps">Become a partner</a>
        <a href="{{ $blogUrl }}">Blog</a>
        @foreach ($navPages as $navPage)
            <a href="{{ route('cms.page', $navPage->slug) }}">{{ $navPage->title }}</a>
        @endforeach
        <a href="{{ route('cms.page') }}#hz-faq">FAQs</a>
        @if ($contactPage)
            <a href="{{ route('cms.page', $contactPage->slug) }}">Contact</a>
        @endif
        @if ($phone)
            <a href="tel:{{ preg_replace('/\D+/', '', $phone) }}">{{ $phone }}</a>
        @endif
        <a href="{{ route('tenant_login') }}">Log In</a>
        <a href="{{ route('tenant_register') }}" class="hz-btn hz-btn--gold">Get started</a>
    </nav>
</header>
