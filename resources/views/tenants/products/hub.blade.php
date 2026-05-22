@extends('layouts.tenant.products-list')
@section('title', 'Products')

@section('products_title')
    Product setup
@endsection

@section('products_content')
    <p class="text-muted f-14 mb-4">
        Set up catalogs, categories, door styles, and products in order. Use the tabs above to open each list,
        or follow the steps below.
    </p>
    <div class="row">
        @foreach (config('tenant_products_menu.form_sections', []) as $section)
            <div class="col-md-6 col-lg-3 mb-3">
                <div class="tc-wd-card h-100 d-flex flex-column">
                    <span class="tc-products-hub-step">Step {{ $section['step'] }}</span>
                    <span class="tc-wd-card__icon"><i data-feather="{{ $section['icon'] ?? 'circle' }}"></i></span>
                    <strong>{{ $section['label'] }}</strong>
                    <span class="tc-wd-card__desc flex-grow-1">{{ $section['hint'] ?? '' }}</span>
                    <div class="mt-2 d-flex flex-wrap gap-2">
                        <a href="{{ route($section['create_route']) }}" class="btn btn-primary btn-sm">{{ $section['create_label'] }}</a>
                        <a href="{{ route($section['list_route']) }}" class="btn btn-light btn-sm">View list</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
