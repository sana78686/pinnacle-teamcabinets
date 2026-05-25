@extends('themes.classic.layout')

@section('content')
@php
    $company = tenant('company_name') ?? tenant('name') ?? 'Your business';
    $hazelDefaults = config('tenant_hazel_home');
    $heroTitle = $homesettings?->benner_title ?? 'Premium Wholesale RTA Cabinets for Dealers & Contractors';
    $heroLead = $homesettings?->benner_description ?? 'Equipping showrooms, installers, and multi-family builders with high-quality, real-wood cabinetry. Protected wholesale pricing and reliable shipping from our warehouses to your job site.';
    $heroBg = !empty($bennersection?->banner_image) ? $sf->publicAsset($bennersection->banner_image) : null;
    $aboutTitle = $homesettings?->aboutus_title ?? 'The '.$company.' difference: built for the trade';
    $aboutBody = $homesettings?->aboutus_description ?? 'For over a decade we have supported successful showrooms and multi-family renovations across the USA. We offer uncompromised, furniture-grade quality at true wholesale rates.';
    $cards = $cardsection ? [
        ['icon' => 'fa-tags', 'title' => $homesettings->card_one_title, 'text' => $homesettings->card_one_description],
        ['icon' => 'fa-tree', 'title' => $homesettings->card_two_title, 'text' => $homesettings->card_two_description],
        ['icon' => 'fa-truck-fast', 'title' => $homesettings->card_three_title, 'text' => $homesettings->card_three_description],
    ] : [
        ['icon' => 'fa-tags', 'title' => 'Protected wholesale pricing', 'text' => 'Tiered B2B pricing designed exclusively for distributors, showrooms, and dealers.'],
        ['icon' => 'fa-tree', 'title' => 'Plywood box construction', 'text' => 'Real wood and top-grade plywood — no particle board for structural cabinet boxes.'],
        ['icon' => 'fa-truck-fast', 'title' => 'Express fulfillment & logistics', 'text' => 'Rapid turnaround, nationwide shipping, and flexible local pickup options.'],
    ];
    $qualityItems = $hazelDefaults['quality'] ?? [];
    $faqs = ! empty($faqs ?? null) ? $faqs : ($hazelDefaults['faqs'] ?? []);
    $aboutPageUrl = $sfAboutPage ? route('cms.page', $sfAboutPage->slug) : ($sfShowAbout ? route('cms.page', 'about') : null);
    $contactUrl = $sfContactPage ? route('cms.page', $sfContactPage->slug) : ($sfShowContact ? route('cms.page', 'contact') : null);
    $defaultBrands = $hazelDefaults['brands'] ?? [];
    $catalogRows = isset($catalogs) ? $catalogs->filter(fn ($c) => $c->doorColors && $c->doorColors->count() > 0) : collect();
@endphp

<section id="hz-hero" class="hz-hero cl-hero {{ $heroBg ? 'hz-hero--image cl-hero--image' : '' }}" @if($heroBg) style="--hz-hero-bg: url('{{ $heroBg }}')" @endif>
    <div class="hz-container">
        <span class="hz-hero__tag">Quality cabinets · Serving the USA</span>
        <h1>{{ $heroTitle }}</h1>
        <div class="hz-hero__lead hz-page-body">{!! $heroLead !!}</div>
        <div class="hz-hero__actions">
            <a href="{{ route('tenant_register') }}" class="hz-btn hz-btn--gold">Become a dealer</a>
            <a href="{{ route('tenant_register') }}" class="hz-btn hz-btn--outline-light">Apply for trade pricing</a>
        </div>
    </div>
</section>

<section id="hz-brands" class="hz-section hz-section--brands cl-band">
    <div class="hz-container">
        <h2 class="hz-section__title hz-section__title--sm">Proudly distributing leading cabinetry brands</h2>
        <div class="hz-brands cl-brands">
            @if ($catalogRows->count())
                @foreach ($catalogRows->take(6) as $catalog)
                    <div class="hz-brand cl-brand">
                        @if ($catalog->image)
                            <img src="{{ $sf->publicAsset($catalog->image) }}" alt="{{ $catalog->name }}">
                        @else
                            <span class="hz-brand__name">{{ $catalog->name }}</span>
                        @endif
                    </div>
                @endforeach
            @else
                @foreach ($defaultBrands as $brand)
                    <div class="hz-brand cl-brand"><span class="hz-brand__name">{{ $brand['name'] }}</span></div>
                @endforeach
            @endif
        </div>
    </div>
</section>

<section id="hz-difference" class="hz-section cl-section-cards">
    <div class="hz-container">
        <h2 class="hz-section__title">{{ $aboutTitle }}</h2>
        <p class="hz-section__sub">{{ $aboutBody }}</p>
        <div class="hz-grid-3">
            @foreach ($cards as $card)
                <article class="hz-card hz-card--lift cl-card">
                    <div class="hz-card__icon"><i class="fa-solid {{ $card['icon'] }}" aria-hidden="true"></i></div>
                    <h3>{{ $card['title'] }}</h3>
                    <div class="hz-page-body">{!! $card['text'] !!}</div>
                </article>
            @endforeach
        </div>
        @if ($aboutPageUrl)
            <p class="hz-section__cta mt-4 mb-0">
                <a href="{{ $aboutPageUrl }}" class="hz-btn hz-btn--primary">Read our full story</a>
            </p>
        @endif
    </div>
</section>

@if ($aboutussection && !empty($aboutussection->aboutus_image))
<section class="hz-section hz-section--cream cl-about-split">
    <div class="hz-container hz-about">
        <div class="hz-about__img">
            <img src="{{ $sf->publicAsset($aboutussection->aboutus_image) }}" alt="{{ $aboutTitle }}">
        </div>
        <div>
            <h2 class="hz-section__title hz-section__title--left">{{ $aboutussection->aboutus_title ?? $aboutTitle }}</h2>
            <div class="hz-page-body">{!! $aboutussection->aboutus_description ?? $aboutBody !!}</div>
            <a href="{{ route('tenant_register') }}" class="hz-btn hz-btn--primary">Partner with us</a>
        </div>
    </div>
</section>
@endif

<section id="hz-quality" class="hz-section hz-section--gray">
    <div class="hz-container">
        <h2 class="hz-section__title">Uncompromising quality inside and out</h2>
        <p class="hz-section__sub">Engineered to exceed industry standards for single kitchens or 200-unit complexes.</p>
        <div class="hz-grid-4">
            @foreach ($qualityItems as $item)
                <article class="hz-card hz-card--center">
                    <div class="hz-card__icon"><i class="fa-solid {{ $item['icon'] }}" aria-hidden="true"></i></div>
                    <h3>{{ $item['title'] }}</h3>
                    <p>{{ $item['text'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>

@if ($catalogRows->count())
    @include('partials.storefront.featured-catalog-lines', [
        'catalogRows' => $catalogRows,
        'defaultBrands' => $defaultBrands,
    ])
@elseif ($doorstyles && $doorstyles->count())
    <section id="hz-catalog-lines" class="hz-section cl-catalog cl-catalog--doors-only">
        <div class="hz-container">
            <div class="cl-doors-swiper-wrap">
                <header class="sf-catalog-lines__head">
                    <span class="sf-catalog-lines__eyebrow">Door styles</span>
                    <h2 class="hz-section__title sf-catalog-lines__title">Explore our featured cabinetry lines</h2>
                </header>
                <div class="swiper cl-doors-swiper">
                    <div class="swiper-wrapper">
                        @foreach ($doorstyles as $door)
                            <div class="swiper-slide">
                                <article class="cl-door-slide text-center">
                                    @if (!empty($door->image))
                                        <img src="{{ $sf->publicAsset($door->image) }}" alt="{{ $door->product_label }}">
                                    @endif
                                    <h4>{{ $door->product_label ?? 'Finish' }}</h4>
                                </article>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>
    </section>
@else
    @include('partials.storefront.featured-catalog-lines', [
        'catalogRows' => collect(),
        'defaultBrands' => $defaultBrands,
    ])
@endif

<section id="hz-steps" class="hz-section hz-section--cream">
    <div class="hz-container">
        <h2 class="hz-section__title">Partnering with {{ $company }} is simple</h2>
        <p class="hz-section__sub">Register, get approved, and start ordering RTA cabinets for your projects.</p>
        <div class="hz-step-boxes">
            <article class="hz-step-box cl-step-box">
                <span class="hz-step-box__num">Step 1</span>
                <h3>Register your business</h3>
                <p>Apply as showroom, dealer, installer, or distributor for B2B portal access.</p>
                <a href="{{ route('tenant_register') }}" class="hz-btn hz-btn--gold">Start registering</a>
            </article>
            <article class="hz-step-box cl-step-box">
                <span class="hz-step-box__num">Step 2</span>
                <h3>Get approved &amp; access pricing</h3>
                <p>After verification, unlock wholesale pricing tiers and live inventory catalogs.</p>
            </article>
            <article class="hz-step-box cl-step-box">
                <span class="hz-step-box__num">Step 3</span>
                <h3>Shop, order &amp; assemble</h3>
                <p>RTA cabinets ship flat-packed to your warehouse or job site, ready for rapid assembly.</p>
            </article>
        </div>
    </div>
</section>

<section id="hz-multifamily" class="hz-cta-band cl-cta-band">
    <div class="hz-container hz-cta-band__inner">
        <div>
            <h2>Built for multi-family renovations</h2>
            <p>Scaling a multi-unit project requires volume-ready inventory, consistent supply, and streamlined logistics. We tailor fulfillment for apartment builds and commercial developments.</p>
            @if ($contactUrl)
                <a href="{{ $contactUrl }}" class="hz-btn hz-btn--gold">Contact us</a>
            @else
                <a href="{{ route('cms.page') }}#hz-contact" class="hz-btn hz-btn--gold">Contact us</a>
            @endif
        </div>
    </div>
</section>

<section id="hz-faq" class="hz-section">
    <div class="hz-container hz-faq-wrap">
        <h2 class="hz-section__title">Frequently asked questions</h2>
        <div class="hz-faq" data-hz-faq>
            @foreach ($faqs as $index => $faq)
                <details class="hz-faq__item" {{ $index === 1 ? 'open' : '' }}>
                    <summary>{{ $faq['q'] }}</summary>
                    <p>{{ $faq['a'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.hz-faq__item').forEach(function (item) {
        item.addEventListener('toggle', function () {
            if (!item.open) return;
            document.querySelectorAll('.hz-faq__item').forEach(function (other) {
                if (other !== item) other.open = false;
            });
        });
    });
    if (document.querySelector('.cl-doors-swiper')) {
        new Swiper('.cl-doors-swiper', {
            slidesPerView: 2,
            spaceBetween: 20,
            loop: true,
            autoplay: { delay: 3500, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: {
                640: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });
    }
</script>
@endpush
