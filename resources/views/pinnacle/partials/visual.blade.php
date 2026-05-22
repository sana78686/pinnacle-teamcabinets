@php
    $visualKey = $variant ?? 'hero';
    $visual = $visual ?? (config('pinnacle.visuals.'.$visualKey) ?? []);
    $relativePath = $path ?? ($visual['path'] ?? null);
    $imageUrl = pinnacle_public_asset_url($relativePath);
    $gradient = $visual['gradient'] ?? 'linear-gradient(145deg, #0c2340 0%, #2d5a87 100%)';
    $label = $visual['label'] ?? '';
    $altText = $alt ?? $label;
    $extraClass = $class ?? '';
    $aspect = $aspect ?? '4/3';
@endphp
<div class="pn-visual pn-visual--{{ $visualKey }} {{ $extraClass }}"
    style="--pn-visual-aspect: {{ $aspect }};@if (! $imageUrl) --pn-visual-bg: {{ $gradient }};@endif">
    @if ($imageUrl)
        <img src="{{ $imageUrl }}" alt="{{ $altText }}" loading="{{ $loading ?? 'lazy' }}" decoding="async">
    @else
        <span class="pn-visual__fill" aria-hidden="true"></span>
        @if ($label)
            <span class="pn-visual__label">{{ $label }}</span>
        @endif
    @endif
</div>
