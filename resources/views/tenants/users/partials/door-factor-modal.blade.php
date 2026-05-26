@php
    $doorFactorValue = $doorFactorValue ?? function ($catalogId, $doorColorId) {
        return '';
    };
    $selectedCatalogs = $selected_catalogs ?? [];
    $modalTitle = $modalTitle ?? 'Product Catalog Visibility & Door Point Factors';
@endphp
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">{{ $modalTitle }}</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($door_factor_setup_incomplete ?? false)
                    @include('partials.tenant-door-factor-setup-empty', [
                        'context' => 'modal',
                        'missingDefaults' => ! ($has_point_factor_defaults ?? false),
                        'missingCatalogs' => ! ($has_product_catalogs ?? false),
                        'missingDoorStyles' => ! ($has_door_styles ?? false),
                    ])
                @else
                    <div class="container-fluid">
                        <div class="row g-3">
                            <div class="col-lg-4">
                                <h6 class="tc-form-section-title">Catalog visibility</h6>
                                <hr class="mt-1 mb-2">
                                @foreach ($product_catalogs as $product_catalog)
                                    <div class="form-check mb-2">
                                        <input type="checkbox"
                                            name="catalog_visibility[{{ $product_catalog->id }}]"
                                            id="checkbox-primary-{{ $product_catalog->id }}"
                                            class="form-check-input product-catalog-checkbox"
                                            data-catalog-id="{{ $product_catalog->id }}"
                                            value="{{ $product_catalog->id }}"
                                            @checked(in_array((int) $product_catalog->id, array_map('intval', $selectedCatalogs), true))>
                                        <label class="form-check-label" for="checkbox-primary-{{ $product_catalog->id }}">
                                            {{ $product_catalog->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <div class="col-lg-8">
                                <h6 class="tc-form-section-title">Door point factors</h6>
                                <hr class="mt-1 mb-2">
                                @foreach ($product_catalogs as $product_catalog)
                                    @php $isVisible = in_array((int) $product_catalog->id, array_map('intval', $selectedCatalogs), true); @endphp
                                    <div class="door-colors-container mb-3" data-catalog-id="{{ $product_catalog->id }}"
                                        style="{{ $isVisible ? '' : 'display:none;' }}">
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <strong class="small text-muted">{{ $product_catalog->name }}</strong>
                                            <button type="button" class="btn btn-sm btn-outline-secondary"
                                                data-apply-catalog-default="{{ $product_catalog->id }}">
                                                Apply role default
                                            </button>
                                        </div>
                                        @foreach (($doors_by_catalog[$product_catalog->id] ?? collect()) as $door_color)
                                            <div class="mb-2">
                                                <label class="form-label small mb-1">{{ $door_color->product_label }}</label>
                                                <input type="number" step="any" min="0"
                                                    name="door_factors[{{ $product_catalog->id }}][{{ $door_color->id }}]"
                                                    placeholder="e.g. 0.42"
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
            </div>
            <div class="modal-footer">
                @unless ($door_factor_setup_incomplete ?? false)
                    <button type="button" class="btn btn-primary btn-sm" data-door-factor-save>Save</button>
                @else
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                @endunless
            </div>
        </div>
    </div>
</div>
