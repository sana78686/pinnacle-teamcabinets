@extends('layouts.tenant.standalone')

@section('title', 'Select Catalog')

@section('content')
<div class="co-shell ow-page--fullscreen tc-order-workspace">
    <main class="co-main container-fluid">
        <p class="mb-3">
            <a href="{{ route('tenant_dashboard') }}" class="ow-door-strip__back"><i class="fa fa-arrow-left"></i> Back to panel</a>
        </p>
        <p class="ow-hint mb-3">Select a product catalog to begin. Click <strong>View PDF</strong> when a catalog PDF is available.</p>

        <div class="co-catalog-grid">
            @forelse ($catalogs as $catalog)
                <a href="{{ route('tenant_order_workspace_build', $catalog->id) }}" class="co-catalog-card">
                    <div class="co-catalog-card__media">
                        @if ($catalog->pdf)
                            <span class="co-catalog-card__pdf" onclick="event.preventDefault(); window.open('{{ asset($catalog->pdf) }}','_blank');">
                                <i class="fa-solid fa-file-pdf"></i> View PDF
                            </span>
                        @endif
                        @if ($catalog->image)
                            <img src="{{ asset($catalog->image) }}" alt="{{ $catalog->name }}">
                        @else
                            <div class="co-catalog-card__placeholder"><i class="fa-solid fa-box"></i></div>
                        @endif
                    </div>
                    <div class="co-catalog-card__footer">{{ $catalog->name }}</div>
                </a>
            @empty
                <div class="co-empty">
                    <p>No catalogs available. Run the Team Cabinets seeder or add catalogs in Products.</p>
                </div>
            @endforelse
        </div>
    </main>
</div>
@endsection
