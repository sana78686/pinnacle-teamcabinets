@php
    $doorFactorValue = $doorFactorValue ?? function ($catalogId, $doorColorId) {
        return '';
    };
    $selectedCatalogs = $selected_catalogs ?? [];
@endphp

@if ($door_factor_setup_incomplete ?? false)
    @include('partials.tenant-door-factor-setup-empty', [
        'context' => 'modal',
        'missingDefaults' => ! ($has_point_factor_defaults ?? false),
        'missingCatalogs' => ! ($has_product_catalogs ?? false),
        'missingDoorStyles' => ! ($has_door_styles ?? false),
    ])
@else
    <p class="small text-muted mb-3">
        Choose which product catalogs this user can see. <strong>Door point factors are optional</strong> — leave them blank to show catalogs only without custom pricing factors.
    </p>
    <div class="container-fluid px-0">
        <div class="row g-3">
            <div class="col-lg-4">
                <h6 class="tc-form-section-title">Catalog visibility</h6>
                <hr class="mt-1 mb-2">
                @forelse ($product_catalogs as $product_catalog)
                    <div class="form-check mb-2">
                        <input type="checkbox"
                            name="catalog_visibility[{{ $product_catalog->id }}]"
                            id="approval-catalog-{{ $product_catalog->id }}"
                            class="form-check-input product-catalog-checkbox"
                            data-catalog-id="{{ $product_catalog->id }}"
                            value="{{ $product_catalog->id }}"
                            @checked(in_array($product_catalog->id, $selectedCatalogs))>
                        <label class="form-check-label" for="approval-catalog-{{ $product_catalog->id }}">
                            {{ $product_catalog->name }}
                        </label>
                    </div>
                @empty
                    <p class="small text-muted">No active product catalogs. Add catalogs under Products first.</p>
                @endforelse
            </div>
            <div class="col-lg-8">
                <h6 class="tc-form-section-title">Door point factors <span class="fw-normal text-muted">(optional)</span></h6>
                <hr class="mt-1 mb-2">
                @foreach ($product_catalogs as $product_catalog)
                    @php $isVisible = in_array($product_catalog->id, $selectedCatalogs); @endphp
                    <div class="door-colors-container mb-3" data-catalog-id="{{ $product_catalog->id }}"
                        style="{{ $isVisible ? '' : 'display:none;' }}">
                        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap gap-2">
                            <strong class="small text-muted">{{ $product_catalog->name }}</strong>
                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                data-apply-catalog-default="{{ $product_catalog->id }}">
                                Apply role default
                            </button>
                        </div>
                        @foreach ($door_colors->where('product_catalog_id', $product_catalog->id) as $door_color)
                            <div class="mb-2">
                                <label class="form-label small mb-1">{{ $door_color->product_label }}</label>
                                <input type="number" step="any" min="0"
                                    name="door_factors[{{ $product_catalog->id }}][{{ $door_color->id }}]"
                                    placeholder="Optional"
                                    class="form-control form-control-sm door-factor-input"
                                    inputmode="decimal"
                                    value="{{ is_callable($doorFactorValue) ? $doorFactorValue($product_catalog->id, $door_color->id) : '' }}">
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
