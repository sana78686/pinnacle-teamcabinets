@extends('layouts.tenant.standalone')

@section('title', 'Create Order — '.$catalog->name)

@section('content')
<div class="ow-page ow-page--fullscreen"
    id="ow-page"
    data-catalog-id="{{ $catalog->id }}"
    data-door-id="{{ $door->id }}"
    data-door-label="{{ $door->product_label }}"
    data-door-image="{{ $door->image ? asset($door->image) : '' }}"
    data-catalog-name="{{ $catalog->name }}"
    data-accordion-search-prefix="{{ url('/orders/workspace/catalog/'.$catalog->id.'/door') }}"
    data-autosave-url="{{ route('tenant_order_workspace_cart_autosave', $catalog->id) }}"
    data-clear-cart-url="{{ route('tenant_order_workspace_clear_cart', $catalog->id) }}"
    data-store-print-url="{{ route('tenant_order_workspace_print') }}"
    data-store-quote-url="{{ route('tenant_order_workspace_quote') }}"
    data-store-shipping-url="{{ route('tenant_order_workspace_shipping_quote') }}"
    data-store-stock-url="{{ route('tenant_order_workspace_stock_check') }}"
    data-store-process-url="{{ route('tenant_order_workspace_process') }}"
    data-csrf="{{ csrf_token() }}"
    data-saved-cart="{{ json_encode($savedCart ?? null) }}">

    {{-- Door styles — portal pill tabs (like Settings subnav) --}}
    <nav class="ow-door-strip tc-wd-subnav" role="listbox" aria-label="Door style">
        <a href="{{ route('tenant_order_workspace') }}" class="ow-door-strip__back" title="Back to catalogs">
            <i class="fa fa-arrow-left"></i> Catalogs
        </a>
        @foreach ($doorColors as $doorOption)
            <button type="button"
                class="ow-door-pill door-image-tile {{ $doorOption->id === $door->id ? 'is-selected selected' : '' }}"
                data-door-id="{{ $doorOption->id }}"
                data-label="{{ $doorOption->product_label }}"
                data-src="{{ $doorOption->image ? asset($doorOption->image) : '' }}"
                title="{{ $doorOption->product_label }}">
                @if ($doorOption->image)
                    <img src="{{ asset($doorOption->image) }}" alt="" class="ow-door-pill__img">
                @endif
                <span>{{ $doorOption->product_label }}</span>
            </button>
        @endforeach
    </nav>

    <div class="container-fluid ow-main-wrap">
        <div class="row ow-main-row">

            {{-- Col 4: Door + product preview --}}
            <div class="col-lg-3 ow-col ow-col-preview">
                <div class="ow-panel tc-settings-panel">
                    <h3 class="ow-panel__heading">
                        <span class="ow-panel__title" id="door-heading">{{ $door->product_label }}</span>
                        <span class="ow-panel__sep">-</span>
                        <span class="ow-panel__subtitle">Door style &amp; product preview</span>
                    </h3>

                    <div class="ow-door-preview">
                        @if ($door->image)
                            <img src="{{ asset($door->image) }}" alt="" id="door-preview-img" class="ow-door-preview__img">
                        @else
                            <img src="" alt="" id="door-preview-img" class="ow-door-preview__img d-none">
                        @endif
                        <p class="ow-door-preview__empty text-muted mb-0 {{ $door->image ? 'd-none' : '' }}" id="door-preview-empty">No door image</p>
                    </div>

                    <div class="ow-product-details">
                        <h4 class="tc-settings-section__title">Product Details</h4>
                        <div class="ow-product-details__body">
                            <p class="text-muted f-12 mb-2 ow-detail-placeholder">Select a product row to preview.</p>
                            <p class="mb-0 f-12" id="detail-category"></p>
                            <p class="mb-0 f-12 font-weight-bold" id="detail-label"></p>
                            <p class="mb-0 f-12" id="detail-sku"></p>
                            <p class="mb-0 f-12" id="detail-weight"></p>
                            <p class="mb-0 f-12" id="detail-cost"></p>
                            <p class="mb-0 f-12" id="detail-info"></p>
                            <img src="" alt="" id="detail-img" class="ow-detail-diagram d-none">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Col 4: Inventory tables + search --}}
            <div class="col-lg-4 ow-col ow-col-inventory">
                <div class="ow-panel tc-settings-panel">
                    <h3 class="ow-panel__heading">
                        <span class="ow-panel__title">Inventory</span>
                        <span class="ow-panel__sep">-</span>
                        <span class="ow-panel__subtitle">Search and double-click label to add</span>
                    </h3>

                    <div class="ow-sku-toolbar mb-2">
                        <div class="ow-sku-toolbar__row">
                            <label for="ow-sku-search" class="ow-sku-toolbar__label">SKU search</label>
                            <input type="search" class="form-control sku-search-input ow-sku-toolbar__input" id="ow-sku-search" placeholder="Enter SKU number" autocomplete="off">
                            <button type="button" class="btn btn-primary btn-sm btn-sku-search flex-shrink-0" id="ow-sku-search-btn">Search</button>
                        </div>
                    </div>
                    <p class="f-12 text-muted mb-2 ow-inventory-notes">
                        <strong>NOTE:</strong> Empty search resets the list.
                        <span class="ow-inventory-notes__sep">|</span>
                        <strong>NOTE:</strong> Double-click <strong>Cabinet Label</strong> to add to cart.
                    </p>

                    <div id="product-list-container" class="ow-accordion">
                        @include('tenants.orders.workspace.partials.product-accordion', ['sections' => $sections, 'door' => $door])
                    </div>
                </div>
            </div>

            {{-- Col 4: Live cart --}}
            <div class="col-lg-5 ow-col ow-col-cart">
                <form id="cart_form" class="ow-panel ow-panel--cart tc-settings-panel" onsubmit="return false;">
                    <div class="ow-cart-scroll">
                    <h3 class="ow-panel__heading">
                        <span class="ow-panel__title">Cart</span>
                        <span class="ow-panel__sep">-</span>
                        <span class="ow-panel__subtitle">Step #1: Enter job name and room before adding products.</span>
                    </h3>

                    <div class="ow-job-toolbar mb-2">
                        <div class="ow-job-toolbar__row">
                            <label for="ow-job-name" class="ow-job-toolbar__label">Job Name <span class="text-danger">*</span></label>
                            <input type="text" name="job_name" id="ow-job-name" class="form-control ow-job-toolbar__input" placeholder="Enter job name" maxlength="120" autocomplete="off">
                            <button type="button" class="btn btn-primary btn-sm btn-add-room flex-shrink-0" id="ow-add-room" disabled>+ ADD ROOM</button>
                            <a href="{{ route('tenant_order_workspace_clear_cart', $catalog->id) }}"
                                class="btn btn-light btn-sm flex-shrink-0"
                                id="ow-clear-cart-link"
                                onclick="return confirm('Are you sure you want to clear all the items in cart?');">Clear Cart</a>
                        </div>
                        <span class="err-job-name text-danger f-12 d-block"></span>
                    </div>

                    <div class="ow-assemble-toolbar mb-2">
                        <div class="ow-assemble-toolbar__row">
                            <span class="ow-assemble-toolbar__label">Assemble All Cabinetry? <span class="text-danger">*</span></span>
                            <label class="form-check form-check-inline mb-0 ow-assemble-option">
                                <input type="radio" name="assemble_cabinets_check" value="yes" class="form-check-input"> Yes
                            </label>
                            <label class="form-check form-check-inline mb-0 ow-assemble-option">
                                <input type="radio" name="assemble_cabinets_check" value="no" class="form-check-input"> No
                            </label>
                        </div>
                        <span class="err-assemble text-danger f-12 d-block"></span>
                    </div>

                    <div class="ow-cart-table-wrap">
                        <table class="table table-bordered table-sm ow-cart-table mb-0" id="cart_table">
                            <tbody data-room-index="1" class="cart-room active" id="ow-room-tbody-1">
                                <tr class="room-header-row">
                                    <th colspan="8">
                                        <div class="ow-room-toolbar">
                                            <span class="ow-room-toolbar__label">Room <span class="text-danger">*</span></span>
                                            <input type="text" name="roomlabel[]" data-attr="1" class="form-control form-control-sm room-name-input ow-room-toolbar__input" placeholder="Enter job name first" readonly>
                                            <input type="hidden" name="roomlabel_id[]" value="1">
                                        </div>
                                        <span class="err-roomlabel text-danger f-12 d-block"></span>
                                    </th>
                                </tr>
                                <tr class="cart-header-row">
                                    <th>Check</th>
                                    <th>Name</th>
                                    <th>Desc</th>
                                    <th>Wt</th>
                                    <th>Unit</th>
                                    <th>Total</th>
                                    <th>Qty</th>
                                    <th></th>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3"></th>
                                    <th class="total-weight">0 lbs</th>
                                    <th></th>
                                    <th class="total-price">$0.00</th>
                                    <th colspan="2"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <span class="err-cart-tot text-danger f-12 d-block mb-2"></span>

                    <div class="ow-comment-toolbar mb-2">
                        <div class="ow-comment-toolbar__row">
                            <label for="ow-comment" class="ow-comment-toolbar__label">Comment</label>
                            <textarea name="order_comment" id="ow-comment" class="form-control order_comment ow-comment-toolbar__input" rows="1" maxlength="200" placeholder="Optional"></textarea>
                        </div>
                    </div>

                    <input type="hidden" name="cart_product_weight" class="cart_product_weight" value="0 lbs">
                    <input type="hidden" name="all_cart_total" class="all_cart_total" value="0">
                    <input type="hidden" name="last_catalogue" value="{{ $catalog->id }}">
                    <input type="hidden" name="cus_rep_id" value="{{ $pricingContext['cus_rep_id'] ?? '' }}">
                    <input type="hidden" name="cus_parent_id" value="{{ $pricingContext['cus_parent_id'] ?? '' }}">
                    <input type="hidden" name="product_img_src" class="product_img_src" value="{{ $door->image ? asset($door->image) : '' }}">
                    <input type="hidden" name="product_img_name" class="product_img_name" value="{{ $door->product_label }}">
                    <input type="hidden" name="catalogue_name" value="{{ $catalog->name }}">
                    <input type="hidden" name="quote_name" id="quote_name">
                    <input type="hidden" name="quote_saved_id" id="quote_saved_id" value="{{ $editingQuoteId ?? '' }}">
                    <input type="hidden" name="shipping_quote_saved_id" id="shipping_quote_saved_id" value="{{ $editingShippingQuoteId ?? '' }}">
                    <input type="hidden" name="save_quote_mod_btn" id="save_quote_mod_btn">
                    <input type="hidden" name="ship_quote_delivery_type" id="ship_quote_delivery_type">
                    <input type="hidden" name="ship_quote_liftgate_req" id="ship_quote_liftgate_req">
                    <input type="hidden" name="ship_quote_unload_type" id="ship_quote_unload_type">
                    <input type="hidden" name="ship_quote_type" id="ship_quote_type">

                    <div class="tc-settings-form-actions ow-actions">
                        <button type="button" class="btn btn-light btn-sm" id="btn-print">Print</button>
                        <button type="button" class="btn btn-light btn-sm" id="btn-save-quote">Save Quote</button>
                        <button type="button" class="btn btn-light btn-sm" id="btn-shipping-quote">Shipping Quote</button>
                        <button type="button" class="btn btn-light btn-sm" id="btn-stock-check">Stock Check</button>
                        <button type="button" class="btn btn-primary btn-sm" id="btn-process-order">Process Order</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('tenants.orders.workspace.partials.order-modals', [
    'shippingPopup' => $shippingPopup ?? '',
    'stockShippingPopup' => $stockShippingPopup ?? '',
    'shipTerms' => $shipTerms ?? '',
])
@endsection

@section('script')
<script src="{{ asset('js/order-page.js') }}?v=15"></script>
@endsection
