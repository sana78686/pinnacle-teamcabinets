@extends('layouts.tenant.standalone')

@section('title', 'Select Door Style')

@section('content')
<div class="co-shell">
    <header class="co-topbar">
        <div class="co-topbar__brand">
            <a href="{{ route('tenant_order_workspace') }}" class="co-topbar__back"><i class="fa-solid fa-arrow-left"></i> Catalogs</a>
            <h1>{{ $catalog->name }}</h1>
        </div>
        @include('tenants.orders.standalone.partials.steps')
    </header>

    <main class="co-main">
        <p class="co-note">Choose a door style for <strong>{{ $catalog->name }}</strong>.</p>

        <div class="co-door-grid">
            @forelse ($doorColors as $door)
                <a href="{{ route('tenant_order_workspace_build', [$catalog->id, $door->id]) }}" class="co-door-card">
                    @if ($door->image)
                        <img src="{{ asset($door->image) }}" alt="{{ $door->product_label }}">
                    @else
                        <div class="co-door-card__swatch"></div>
                    @endif
                    <span>{{ $door->product_label }}</span>
                </a>
            @empty
                <div class="co-empty">No door styles for this catalog.</div>
            @endforelse
        </div>
    </main>
</div>
@endsection
