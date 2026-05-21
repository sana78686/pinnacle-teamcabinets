@php
    $step = $step ?? 1;
@endphp
<nav class="co-steps co-steps--light" aria-label="Order steps">
    <a href="{{ route('tenant_order_workspace') }}" class="co-steps__item {{ $step === 1 ? 'is-active' : ($step > 1 ? 'is-done' : '') }}">
        <span class="co-steps__num">1</span>
        <span>Catalog</span>
    </a>
    <span class="co-steps__line"></span>
    <span class="co-steps__item {{ $step === 2 ? 'is-active' : '' }}">
        <span class="co-steps__num">2</span>
        <span>Build order</span>
    </a>
</nav>
