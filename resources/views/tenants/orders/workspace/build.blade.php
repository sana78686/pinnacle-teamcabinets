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
    data-accordion-search-url="{{ route('tenant_order_workspace_accordion_search', [$catalog->id, $door->id]) }}"
    data-autosave-url="{{ route('tenant_order_workspace_cart_autosave', $catalog->id) }}"
    data-clear-cart-url="{{ route('tenant_order_workspace_clear_cart', $catalog->id) }}"
    data-store-print-url="{{ route('tenant_order_workspace_print') }}"
    data-store-quote-url="{{ route('tenant_order_workspace_quote') }}"
    data-store-shipping-url="{{ route('tenant_order_workspace_shipping_quote') }}"
    data-store-stock-url="{{ route('tenant_order_workspace_stock_check') }}"
    data-store-process-url="{{ route('tenant_order_workspace_process') }}"
    data-csrf="{{ csrf_token() }}"
    data-saved-cart="{{ json_encode($savedCart ?? null) }}">

    <header class="ow-minibar">
        <a href="{{ route('tenant_order_workspace') }}" class="ow-minibar__back" title="Back to catalogs">
            <i class="fa-solid fa-arrow-left"></i> Back
        </a>
        <span class="ow-minibar__title">{{ $catalog->name }}</span>
        <span class="ow-minibar__step">Build order</span>
    </header>

    {{-- Door style strip --}}
    <div class="ow-door-strip mb-3" role="listbox" aria-label="Door style">
        @foreach ($doorColors as $doorOption)
            <a href="{{ route('tenant_order_workspace_build', ['catalog' => $catalog->id, 'door' => $doorOption->id]) }}"
                class="ow-door-tile door-image-tile {{ $doorOption->id === $door->id ? 'is-selected' : '' }}"
                data-label="{{ $doorOption->product_label }}"
                title="{{ $doorOption->product_label }}">
                @if ($doorOption->image)
                    <img src="{{ asset($doorOption->image) }}" alt="">
                @else
                    <span class="ow-door-tile__ph"></span>
                @endif
                <span>{{ $doorOption->product_label }}</span>
            </a>
        @endforeach
    </div>

    <div class="row ow-main-row">
        {{-- LEFT: product catalog --}}
        <div class="col-lg-5 ow-col-picker">
            <div class="tc-card ow-picker-card">
                <div class="ow-search-row">
                    <input type="search" class="form-control sku-search-input" id="ow-sku-search" placeholder="Enter SKU number" autocomplete="off">
                    <button type="button" class="btn btn-primary btn-sku-search" id="ow-sku-search-btn">Search</button>
                </div>
                <p class="ow-hint mb-1"><strong>NOTE:</strong> Do empty search to reset.</p>
                <p class="ow-hint mb-2"><strong>NOTE:</strong> Double click on Cabinet Label to select product.</p>
                <div id="product-list-container" class="ow-accordion">
                    @include('tenants.orders.workspace.partials.product-accordion', ['sections' => $sections, 'door' => $door])
                </div>
            </div>
        </div>

        {{-- RIGHT: cart --}}
        <div class="col-lg-7 ow-col-cart">
            <div class="tc-card ow-cart-card">
                <p class="ow-step"><strong>Step #1:</strong> Please enter Job Name and Room before selecting items from inventory.</p>

                <div class="ow-toolbar form-inline flex-wrap">
                    <label class="mr-2 mb-2"><b>Job Name <span class="text-danger">*</span></b></label>
                    <input type="text" name="job_name" id="ow-job-name" class="form-control mr-2 mb-2 ow-job-input" placeholder="Enter Job Name." maxlength="120" autocomplete="off">
                    <span class="err-job-name text-danger mb-2 d-block w-100"></span>
                    <button type="button" class="btn btn-primary mb-2 btn-add-room" id="ow-add-room">+ ADD ROOM</button>
                    <a href="{{ route('tenant_order_workspace_clear_cart', $catalog->id) }}"
                        class="btn btn-light mb-2 ml-auto"
                        id="ow-clear-cart-link"
                        onclick="return confirm('Are you sure you want to clear all the items in cart?');">Clear Cart</a>
                </div>

                <div class="ow-assemble mb-2">
                    <strong>Assemble All Cabinetry?<span class="text-danger">*</span></strong>
                    <label class="ml-2 mb-0"><input type="radio" name="assemble_cabinets_check" value="yes"> Yes</label>
                    <label class="ml-2 mb-0"><input type="radio" name="assemble_cabinets_check" value="no"> No</label>
                    <span class="err-assemble text-danger d-block"></span>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered ow-cart-table" id="cart_table">
                        <tbody data-room-index="1" class="cart-room active" id="ow-room-tbody-1">
                            <tr class="room-header-row">
                                <th class="ow-room-th">Room <span class="text-danger">*</span></th>
                                <th colspan="6">
                                    <input type="text" name="roomlabel[]" data-attr="1" class="form-control form-control-sm room-name-input" placeholder="Enter Room Name.">
                                    <input type="hidden" name="roomlabel_id[]" value="1">
                                    <span class="err-roomlabel text-danger"></span>
                                </th>
                                <th></th>
                            </tr>
                            <tr class="cart-header-row">
                                <th>Double Check Work</th>
                                <th>Cabinet Name</th>
                                <th>Cabinet Description</th>
                                <th>Weight</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Quantity</th>
                                <th>Delete</th>
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
                <span class="err-cart-tot text-danger d-block mb-2"></span>

                <div class="ow-comment-row mb-3">
                    <label class="mr-2"><b>Comment</b></label>
                    <textarea name="order_comment" id="ow-comment" class="form-control order_comment" rows="4" maxlength="200"></textarea>
                </div>

                <input type="hidden" name="cart_product_weight" class="cart_product_weight" value="0 lbs">
                <input type="hidden" name="all_cart_total" class="all_cart_total" value="0">
                <input type="hidden" name="last_catalogue" value="{{ $catalog->id }}">
                <input type="hidden" name="product_img_src" class="product_img_src" value="{{ $door->image ? asset($door->image) : '' }}">
                <input type="hidden" name="product_img_name" class="product_img_name" value="{{ $door->product_label }}">
                <input type="hidden" name="catalogue_name" value="{{ $catalog->name }}">

                <div class="ow-actions">
                    <button type="button" class="btn btn-light" id="btn-print">Print</button>
                    <button type="button" class="btn btn-light" id="btn-save-quote">Save Quote</button>
                    <button type="button" class="btn btn-light" id="btn-shipping-quote">Request Shipping Quote</button>
                    <button type="button" class="btn btn-light" id="btn-stock-check">Stock Check</button>
                    <button type="button" class="btn btn-primary" id="btn-process-order">Process Order</button>
                </div>
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
<script src="{{ asset('js/order-page.js') }}?v=2"></script>
@endsection
