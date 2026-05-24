@extends('themes.modern.layout')

@section('content')
@php
    $company = tenant('company_name') ?? tenant('name') ?? 'Your business';
    $md = config('tenant_modern_home');
    $mdMedia = fn (string $path) => tenant_static_asset('themes/modern/media/'.$path);
    $heroTitle = $homesettings?->benner_title ?? 'Built-to-Order Cabinets, Delivered Fully Assembled.';
    $heroLead = $homesettings?->benner_description ?? 'From fan-favorite Shaker to sleek modern slab — over 600 style &amp; finish combinations for dealers, showrooms, and contractors.';
    $heroVideo = $mdMedia($md['hero_video']);
    $heroPoster = $mdMedia($md['hero_poster']);
    $factoryVideo = $mdMedia($md['factory_video']);
    $factoryPoster = $mdMedia($md['factory_poster']);
    $contactUrl = $sfContactPage ? route('cms.page', $sfContactPage->slug) : ($sfShowContact ? route('cms.page', 'contact') : '#md-contact');
    $catalogRows = isset($catalogs) ? $catalogs->filter(fn ($c) => $c->doorColors && $c->doorColors->count() > 0) : collect();
@endphp

{{-- Hero with background video (Cabinets.com customer-closeups) --}}
<section class="relative flex min-h-[88vh] items-center justify-center overflow-hidden bg-md-ink">
    <video class="md-hero-video" autoplay muted loop playsinline poster="{{ $heroPoster }}">
        <source src="{{ $heroVideo }}" type="video/mp4">
    </video>
    <div class="md-hero-overlay"></div>
    <div class="relative z-10 mx-auto max-w-4xl px-6 text-center text-white">
        <h1 class="text-4xl font-bold leading-tight tracking-tight md:text-5xl lg:text-6xl">{{ $heroTitle }}</h1>
        <div class="mx-auto mt-4 max-w-2xl text-lg text-white/90">{!! $heroLead !!}</div>
        <div class="mt-10 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('tenant_register') }}" class="md-btn md-btn--dark min-w-[200px] bg-white text-md-ink hover:bg-md-cream">Start design</a>
            @auth
                <a href="{{ route('tenant_order_workspace') }}" class="md-btn md-btn--light min-w-[200px]">Shop cabinets</a>
            @else
                <a href="{{ route('tenant_register') }}" class="md-btn md-btn--light min-w-[200px]">Shop cabinets</a>
            @endauth
        </div>
    </div>
</section>

{{-- Style & budget intro + door / finish panels --}}
<section id="md-door-styles" class="bg-md-cream py-14 md:py-20">
    <div class="mx-auto max-w-md-page px-4 lg:px-6">
        <h2 class="text-center text-3xl font-bold text-md-ink md:text-4xl">Cabinets for every style and budget</h2>
        <p class="mx-auto mt-4 max-w-3xl text-center text-base text-gray-600">
            {{ $company }} makes kitchen design easy with multiple door styles, finishes, and construction options — tailored for your trade customers.
        </p>
    </div>

    <div class="mx-auto mt-12 max-w-md-page overflow-hidden rounded-sm border border-md-line bg-white shadow-sm">
        <div class="md-showcase-strip bg-white">
            @foreach ($md['door_styles'] as $door)
                <img src="{{ $mdMedia($door['file']) }}" alt="{{ $door['alt'] }}" loading="lazy" width="200" height="140">
            @endforeach
        </div>
        <div class="md-feature-split">
            <h3 class="md-feature-split__title">Door<br>Styles</h3>
            <div class="md-feature-split__body">
                <p class="text-lg text-gray-700">21 door styles in Framed, Frameless, and European Frameless cabinets</p>
                @auth
                    <a href="{{ route('tenant_order_workspace') }}" class="md-btn md-btn--outline w-fit">Shop cabinets</a>
                @else
                    <a href="{{ route('tenant_register') }}" class="md-btn md-btn--outline w-fit">Shop cabinets</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="mx-auto mt-6 max-w-md-page overflow-hidden rounded-sm border border-md-line bg-white shadow-sm">
        <div class="md-showcase-strip bg-neutral-50">
            @foreach ($md['finish_options'] as $finish)
                <img src="{{ $mdMedia($finish['file']) }}" alt="{{ $finish['alt'] }}" loading="lazy" width="160" height="120">
            @endforeach
        </div>
        <div class="md-feature-split">
            <h3 class="md-feature-split__title">Finish<br>Options</h3>
            <div class="md-feature-split__body">
                <p class="text-lg text-gray-700">More than 80 unique colors including stains, paints, and enhancements</p>
                <a href="{{ route('cms.page') }}#md-gallery" class="md-btn md-btn--outline w-fit">View gallery</a>
            </div>
        </div>
    </div>
</section>

{{-- Factory video section --}}
<section class="relative overflow-hidden bg-md-ink py-0">
    <div class="relative mx-auto max-w-md-page">
        <div class="relative aspect-[21/9] min-h-[320px] w-full md:min-h-[420px]">
            <video class="absolute inset-0 h-full w-full object-cover" autoplay muted loop playsinline poster="{{ $factoryPoster }}">
                <source src="{{ $factoryVideo }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center px-6 text-center text-white">
                <h2 class="text-3xl font-bold md:text-4xl">From our hands, to your home</h2>
                <p class="mt-4 max-w-2xl text-lg text-white/90">
                    Technology meets craftsmanship at our facility, where we transform raw wood into kitchen cabinets for {{ $company }} partners.
                </p>
                @if ($sfShowAbout)
                    <a href="{{ $sfAboutPage ? route('cms.page', $sfAboutPage->slug) : route('cms.page', 'about') }}" class="mt-8 md-btn border border-white bg-transparent text-white hover:bg-white hover:text-md-ink">Learn more</a>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Dealer CTA cards --}}
<section class="bg-white py-16">
    <div class="mx-auto grid max-w-md-page gap-6 px-4 md:grid-cols-2 lg:px-6">
        <article class="rounded-lg border border-md-line bg-md-cream p-8">
            <h3 class="text-2xl font-bold">Create-A-Kitchen Tool</h3>
            <p class="mt-3 text-gray-600">Our user-friendly virtual kitchen planner for approved dealers.</p>
            <a href="{{ route('tenant_register') }}" class="mt-6 inline-block font-semibold text-md-gold hover:underline">Get access →</a>
        </article>
        <article class="rounded-lg border border-md-line bg-md-cream p-8">
            <h3 class="text-2xl font-bold">Trade Pro Program</h3>
            <p class="mt-3 text-gray-600">For businesses directly involved with cabinet installation and distribution.</p>
            <a href="{{ route('tenant_register') }}" class="mt-6 inline-block font-semibold text-md-gold hover:underline">Apply today →</a>
        </article>
    </div>
</section>

{{-- Inspiration gallery carousel --}}
<section id="md-gallery" class="bg-md-cream py-16 md:py-20">
    <div class="mx-auto max-w-md-page px-4 lg:px-6">
        <div class="mb-8 flex items-end justify-between gap-4">
            <h2 class="text-3xl font-bold text-md-ink">Design inspiration</h2>
            <div class="flex gap-2">
                <button type="button" data-md-gallery-prev class="flex h-10 w-10 items-center justify-center rounded-full border border-md-line bg-white hover:bg-white/80" aria-label="Previous">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button type="button" data-md-gallery-next class="flex h-10 w-10 items-center justify-center rounded-full border border-md-line bg-white hover:bg-white/80" aria-label="Next">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </div>
        <div id="md-gallery-track" class="md-gallery-track">
            @foreach ($md['gallery'] as $slide)
                <a href="{{ route('cms.page') }}#md-gallery" class="group relative block overflow-hidden rounded-sm">
                    <img src="{{ $mdMedia($slide['file']) }}" alt="{{ $slide['title'] }}" loading="lazy">
                    <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-black/70 to-transparent px-4 py-6 text-sm font-medium text-white opacity-0 transition group-hover:opacity-100">{{ $slide['title'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</section>

@if ($catalogRows->count())
<section class="border-t border-md-line bg-white py-16">
    <div class="mx-auto max-w-md-page px-4 lg:px-6">
        <h2 class="text-center text-3xl font-bold">Your assigned product lines</h2>
        <p class="mx-auto mt-3 max-w-2xl text-center text-gray-600">Catalogs enabled for your account in the dealer portal.</p>
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($catalogRows as $catalog)
                <a href="{{ route('tenant_order_workspace_build', $catalog->id) }}" class="group overflow-hidden rounded-lg border border-md-line bg-md-cream transition hover:shadow-md">
                    @if ($catalog->image)
                        <img src="{{ $sf->publicAsset($catalog->image) }}" alt="{{ $catalog->name }}" class="h-48 w-full object-cover transition group-hover:scale-[1.02]">
                    @endif
                    <div class="p-5">
                        <h3 class="font-bold text-md-ink">{{ $catalog->name }}</h3>
                        <span class="mt-2 inline-block text-sm font-semibold text-md-gold">Build order →</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<section class="bg-md-ink py-16 text-center text-white">
    <div class="mx-auto max-w-2xl px-6">
        <h2 class="text-3xl font-bold">Ready to partner with {{ $company }}?</h2>
        <p class="mt-4 text-white/85">Register for trade pricing, catalog access, and online ordering.</p>
        <div class="mt-8 flex flex-col justify-center gap-4 sm:flex-row">
            <a href="{{ route('tenant_register') }}" class="md-btn bg-md-gold text-md-ink hover:bg-white">Create your account</a>
            <a href="{{ $contactUrl }}" class="md-btn md-btn--light">Contact us</a>
        </div>
    </div>
</section>
@endsection
