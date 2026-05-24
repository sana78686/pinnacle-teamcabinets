@php
    $paths = config('pinnacle.hero_slideshow', []);
    $slides = [];
    foreach ($paths as $path) {
        $url = pinnacle_public_asset_url($path);
        if ($url) {
            $slides[] = $url;
        }
    }
    $interval = (int) (config('pinnacle.hero_slideshow_interval_ms') ?? 4000);
    $gradient = config('pinnacle.visuals.hero.gradient', 'linear-gradient(145deg, #0c2340 0%, #2d5a87 100%)');
@endphp
@if (count($slides) > 0)
    <div class="pn-hero-rotator"
        data-interval="{{ $interval }}"
        @if (count($slides) < 2) data-static="1" @endif
        style="--pn-visual-bg: {{ $gradient }};">
        @foreach ($slides as $index => $src)
            <img src="{{ $src }}"
                alt="Cabinet finish option {{ $index + 1 }}"
                class="pn-hero-rotator__img{{ $index === 0 ? ' is-active' : '' }}"
                loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                decoding="async">
        @endforeach
    </div>
@else
    @include('pinnacle.partials.visual', [
        'variant' => 'hero',
        'alt' => 'Modern kitchen with custom cabinets',
        'loading' => 'eager',
    ])
@endif
