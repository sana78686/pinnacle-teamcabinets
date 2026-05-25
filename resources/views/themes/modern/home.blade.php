@extends('themes.modern.layout')

@section('content')
@php
    use App\Services\ModernHomeMediaService;

    $company = tenant('company_name') ?? tenant('name') ?? 'Your business';
    $md = app(ModernHomeMediaService::class)->resolve($homesettings ?? null);
    $copy = $md['content'];
    $mdMedia = fn (string $path) => tenant_static_asset('themes/modern/media/'.$path);
    $heroTitle = $homesettings?->benner_title ?? 'Built-to-Order Cabinets, Delivered Fully Assembled.';
    $heroLead = $homesettings?->benner_description ?? 'From fan-favorite Shaker to sleek modern slab — over 600 style &amp; finish combinations for dealers, showrooms, and contractors.';
    $heroVideo = $md['hero_video'];
    $heroPoster = $md['hero_poster'];
    $factoryVideo = $md['factory_video'];
    $factoryPoster = $md['factory_poster'];
    $slideshowMs = (int) ($md['slideshow_interval_ms'] ?? 2000);
    $contactUrl = $sfContactPage ? route('cms.page', $sfContactPage->slug) : ($sfShowContact ? route('cms.page', 'contact') : '#md-contact');
    $catalogRows = isset($catalogs) ? $catalogs->filter(fn ($c) => $c->doorColors && $c->doorColors->count() > 0) : collect();
    $homeFaqs = $homesettings?->resolvedFaqs() ?? ($faqs ?? []);
    $doorTitleLines = preg_split('/\s+/', trim($copy['door_title']), 2);
    $finishTitleLines = preg_split('/\s+/', trim($copy['finish_title']), 2);
@endphp

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

<section id="md-door-styles" class="bg-md-cream py-14 md:py-20">
    <div class="mx-auto max-w-md-page px-4 lg:px-6">
        <h2 class="text-center text-3xl font-bold text-md-ink md:text-4xl">{{ $copy['style_intro_title'] }}</h2>
        <div class="mx-auto mt-4 max-w-3xl text-center text-base text-gray-600">{!! $copy['style_intro_body'] !!}</div>
    </div>

    <div class="mx-auto mt-12 max-w-md-page overflow-hidden rounded-sm border border-md-line bg-white shadow-sm">
        <div class="md-showcase-strip bg-white" data-md-showcase-strip>
            @foreach ($md['door_styles'] as $door)
                <img src="{{ $mdMedia($door['file']) }}" alt="{{ $door['alt'] }}" loading="lazy" width="200" height="140">
            @endforeach
        </div>
        <div class="md-feature-split">
            <h3 class="md-feature-split__title">
                {{ $doorTitleLines[0] ?? 'Door' }}@if (!empty($doorTitleLines[1]))<br>{{ $doorTitleLines[1] }}@endif
            </h3>
            <div class="md-feature-split__body">
                <div class="text-lg text-gray-700">{!! $copy['door_body'] !!}</div>
                @auth
                    <a href="{{ route('tenant_order_workspace') }}" class="md-btn md-btn--outline w-fit">Shop cabinets</a>
                @else
                    <a href="{{ route('tenant_register') }}" class="md-btn md-btn--outline w-fit">Shop cabinets</a>
                @endauth
            </div>
        </div>
    </div>

    <div class="mx-auto mt-6 max-w-md-page overflow-hidden rounded-sm border border-md-line bg-white shadow-sm">
        <div class="md-showcase-strip bg-neutral-50" data-md-showcase-strip>
            @foreach ($md['finish_options'] as $finish)
                <img src="{{ $mdMedia($finish['file']) }}" alt="{{ $finish['alt'] }}" loading="lazy" width="160" height="120">
            @endforeach
        </div>
        <div class="md-feature-split">
            <h3 class="md-feature-split__title">
                {{ $finishTitleLines[0] ?? 'Finish' }}@if (!empty($finishTitleLines[1]))<br>{{ $finishTitleLines[1] }}@endif
            </h3>
            <div class="md-feature-split__body">
                <div class="text-lg text-gray-700">{!! $copy['finish_body'] !!}</div>
                <a href="{{ route('cms.page') }}#md-gallery" class="md-btn md-btn--outline w-fit">View gallery</a>
            </div>
        </div>
    </div>
</section>

<section class="relative overflow-hidden bg-md-ink py-0">
    <div class="relative mx-auto max-w-md-page">
        <div class="relative aspect-[21/9] min-h-[320px] w-full md:min-h-[420px]">
            <video class="absolute inset-0 h-full w-full object-cover" autoplay muted loop playsinline poster="{{ $factoryPoster }}">
                <source src="{{ $factoryVideo }}" type="video/mp4">
            </video>
            <div class="absolute inset-0 bg-black/50"></div>
            <div class="absolute inset-0 flex flex-col items-center justify-center px-6 text-center text-white">
                <h2 class="text-3xl font-bold md:text-4xl">{{ $copy['factory_title'] }}</h2>
                <div class="mt-4 max-w-2xl text-lg text-white/90">{!! $copy['factory_body'] !!}</div>
                @if ($sfShowAbout)
                    <a href="{{ $sfAboutPage ? route('cms.page', $sfAboutPage->slug) : route('cms.page', 'about') }}" class="mt-8 md-btn border border-white bg-transparent text-white hover:bg-white hover:text-md-ink">Learn more</a>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="bg-white py-16">
    <div class="mx-auto grid max-w-md-page gap-6 px-4 md:grid-cols-2 lg:px-6">
        <article class="rounded-lg border border-md-line bg-md-cream p-8">
            <h3 class="text-2xl font-bold">{{ $copy['cta_one_title'] }}</h3>
            <div class="mt-3 text-gray-600">{!! $copy['cta_one_body'] !!}</div>
            <a href="{{ route('tenant_register') }}" class="mt-6 inline-block font-semibold text-md-gold hover:underline">{{ $copy['cta_one_label'] }}</a>
        </article>
        <article class="rounded-lg border border-md-line bg-md-cream p-8">
            <h3 class="text-2xl font-bold">{{ $copy['cta_two_title'] }}</h3>
            <div class="mt-3 text-gray-600">{!! $copy['cta_two_body'] !!}</div>
            <a href="{{ route('tenant_register') }}" class="mt-6 inline-block font-semibold text-md-gold hover:underline">{{ $copy['cta_two_label'] }}</a>
        </article>
    </div>
</section>

<section id="md-gallery" class="bg-md-cream py-16 md:py-20">
    <div class="mx-auto max-w-md-page px-4 lg:px-6">
        <div class="mb-8 flex items-end justify-between gap-4">
            <h2 class="text-3xl font-bold text-md-ink">{{ $copy['gallery_title'] }}</h2>
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

@if (count($homeFaqs) > 0)
<section id="md-faq" class="border-t border-md-line bg-white py-16 md:py-20">
    <div class="mx-auto max-w-3xl px-4 lg:px-6">
        <h2 class="text-center text-3xl font-bold text-md-ink">Frequently asked questions</h2>
        <div class="mt-10 space-y-3">
            @foreach ($homeFaqs as $index => $faq)
                <details class="group rounded-lg border border-md-line bg-md-cream px-5 py-4" @if ($index === 0) open @endif>
                    <summary class="cursor-pointer list-none font-semibold text-md-ink marker:content-none [&::-webkit-details-marker]:hidden">
                        {{ $faq['q'] }}
                        <i class="fa-solid fa-chevron-down float-right mt-1 text-sm text-gray-500 transition group-open:rotate-180" aria-hidden="true"></i>
                    </summary>
                    <div class="mt-3 text-gray-600 leading-relaxed">{!! nl2br(e($faq['a'])) !!}</div>
                </details>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
    window.TC_MODERN_HOME = { intervalMs: {{ (int) $slideshowMs }} };
</script>
<script src="{{ tenant_static_asset('js/modern-home.js') }}?v=1"></script>
@endpush
