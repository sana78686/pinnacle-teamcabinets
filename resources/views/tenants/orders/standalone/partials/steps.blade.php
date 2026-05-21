@php
    $step = $step ?? 1;
@endphp
<nav class="co-steps" aria-label="Order steps">
    <a href="{{ route('tenant_order_workspace') }}" class="co-steps__item {{ $step === 1 ? 'is-active' : ($step > 1 ? 'is-done' : '') }}">
        <span class="co-steps__num">1</span>
        <span>Catalog</span>
    </a>
    <span class="co-steps__line"></span>
    <span class="co-steps__item {{ $step === 2 ? 'is-active' : ($step > 2 ? 'is-done' : '') }}">
        <span class="co-steps__num">2</span>
        <span>Door style</span>
    </span>
    <span class="co-steps__line"></span>
    <span class="co-steps__item {{ $step === 3 ? 'is-active' : '' }}">
        <span class="co-steps__num">3</span>
        <span>Build order</span>
    </span>
</nav>
