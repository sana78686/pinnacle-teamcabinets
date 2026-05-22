@extends('layouts.tenant.standalone')

@section('title', 'Build Order')

@section('content')
<div class="co-shell co-shell--build"
    data-catalog-id="{{ $catalog->id }}"
    data-door-id="{{ $door->id }}"
    data-catalog-name="{{ $catalog->name }}"
    data-door-label="{{ $door->product_label }}"
    data-search-url="{{ route('tenant_order_workspace_search', [$catalog->id, $door->id]) }}"
    data-build-url="{{ route('tenant_order_workspace_build', $catalog->id) }}"
    data-store-order-url="{{ route('tenant_order_workspace_store') }}"
    data-store-quote-url="{{ route('tenant_order_workspace_quote') }}"
    data-store-shipping-url="{{ route('tenant_order_workspace_shipping_quote') }}"
    data-store-stock-check-url="{{ route('tenant_order_workspace_stock_check') }}"
    data-cart-get-url="{{ route('cart.getCart') }}"
    data-cart-save-job-url="{{ route('cart.saveJobName') }}"
    data-cart-add-room-url="{{ route('cart.addRoom') }}"
    data-cart-remove-room-url="{{ route('cart.removeRoom') }}"
    data-cart-add-product-url="{{ route('cart.addProduct') }}"
    data-cart-remove-product-url="{{ route('cart.removeProduct') }}"
    data-cart-clear-url="{{ route('cart.clearCart') }}"
    data-cart-save-totals-url="{{ route('cart.saveTotals') }}"
    data-csrf="{{ csrf_token() }}">

    <header class="co-topbar co-topbar--light co-topbar--slim">
        <div class="co-topbar__brand">
            <a href="{{ route('tenant_order_workspace') }}" class="co-topbar__back"><i class="fa-solid fa-arrow-left"></i> Catalogs</a>
            <h1>{{ $catalog->name }}</h1>
        </div>
        @include('tenants.orders.standalone.partials.steps', ['step' => 2])
    </header>

    @if ($doorColors->count() > 1)
        <div class="co-door-strip" role="listbox" aria-label="Door style">
            @foreach ($doorColors as $doorOption)
                <a href="{{ route('tenant_order_workspace_build', ['catalog' => $catalog->id, 'door' => $doorOption->id]) }}"
                    class="co-door-strip__item {{ $doorOption->id === $door->id ? 'is-active' : '' }}"
                    role="option"
                    aria-selected="{{ $doorOption->id === $door->id ? 'true' : 'false' }}">
                    @if ($doorOption->image)
                        <img src="{{ asset($doorOption->image) }}" alt="">
                    @else
                        <span class="co-door-strip__swatch"></span>
                    @endif
                    <span class="co-door-strip__label">{{ $doorOption->product_label }}</span>
                </a>
            @endforeach
        </div>
    @endif

    <div class="co-build co-build--ci">
        <aside class="co-build__door" aria-label="Selected door style">
            @if ($door->image)
                <img src="{{ asset($door->image) }}" alt="{{ $door->product_label }}" class="co-door-preview__img">
            @else
                <div class="co-door-preview__placeholder"></div>
            @endif
            <p class="co-door-preview__title">{{ $door->product_label }}</p>
            @if ($doorColors->count() > 1)
                <div class="co-door-preview__thumbs">
                    @foreach ($doorColors as $doorOption)
                        <a href="{{ route('tenant_order_workspace_build', ['catalog' => $catalog->id, 'door' => $doorOption->id]) }}"
                            class="co-door-preview__thumb {{ $doorOption->id === $door->id ? 'is-active' : '' }}"
                            title="{{ $doorOption->product_label }}">
                            @if ($doorOption->image)
                                <img src="{{ asset($doorOption->image) }}" alt="">
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </aside>

        <aside class="co-build__picker">
            <div class="co-search">
                <input type="search" id="co-sku-search" placeholder="Enter SKU number" autocomplete="off">
                <button type="button" id="co-sku-search-btn" class="btn btn-default co-search-btn">Search</button>
            </div>
            <p class="co-hint"><strong>NOTE:</strong> Do empty search to reset.</p>
            <p class="co-hint"><strong>NOTE:</strong> Double click on Cabinet Label to select product.</p>

            <div class="co-accordion" id="co-product-sections">
                @foreach ($sections as $section)
                    <details class="co-accordion__item">
                        <summary>{{ $section->cabinets_name }}</summary>
                        <div class="co-table-wrap">
                            <table class="co-table co-table--picker table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Cabinet Label</th>
                                        <th>SKU</th>
                                        <th>Description</th>
                                        <th>Weight</th>
                                        <th>Cost</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($section->products as $product)
                                        <tr class="co-product-row"
                                            data-product-id="{{ $product->id }}"
                                            data-label="{{ $product->label }}"
                                            data-sku="{{ $product->sku }}"
                                            data-description="{{ $product->sku }} — {{ $door->product_label }} — {{ $product->description }}"
                                            data-list-description="{{ $product->sku }}-{{ $door->product_label }}"
                                            data-stock-qty="{{ $product->qty }}"
                                            data-weight="{{ preg_replace('/[^\d.]/', '', (string) $product->weight) }}"
                                            data-cost="{{ preg_replace('/[^\d.]/', '', (string) $product->cost) }}"
                                            data-assemble="{{ preg_replace('/[^\d.]/', '', (string) $product->assemble_cost) }}">
                                            <td class="co-product-label">{{ $product->label }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->sku }}-{{ $door->product_label }}</td>
                                            <td>{{ $product->weight }}</td>
                                            <td>{{ $product->cost }}</td>
                                            <td>{{ $product->qty }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </details>
                @endforeach
            </div>
            <div id="co-search-results" class="co-search-results d-none"></div>
        </aside>

        <section class="co-build__cart co-cart-panel">
            <p class="co-cart-intro"><strong>Step #1:</strong> Please enter Job Name and Room before selecting items from inventory.</p>

            <div class="co-cart-toolbar form-inline">
                <span class="co-cart-toolbar__label"><b>Job Name <span class="co-asterisk">*</span></b></span>
                <input type="text" id="co-job-name" class="form-control co-job-input" value="" placeholder="Enter Job Name." maxlength="120" autocomplete="off">
                <button type="button" class="btn btn-default" id="co-add-room">+ ADD ROOM</button>
                <a href="#" class="btn btn-default co-clear-link" id="co-clear-cart">Clear Cart</a>
            </div>

            <div class="co-assemble">
                <strong>Assemble All Cabinetry?<span class="co-asterisk">*</span></strong>
                <label class="co-assemble__opt"><input type="radio" name="assemble" value="yes" id="co-assemble-yes"> Yes</label>
                <label class="co-assemble__opt"><input type="radio" name="assemble" value="no" id="co-assemble-no"> No</label>
                <span class="err_assemble_check co-assemble-error" id="co-assemble-error" aria-live="polite"></span>
            </div>

            <div class="co-table-wrap co-cart-table-wrap">
                <table class="co-table co-table--cart table table-bordered" id="co-cart-table">
                    <thead>
                        <tr>
                            <th>Double Check Work</th>
                            <th>Cabinet Name</th>
                            <th>Cabinet Description</th>
                            <th>Weight</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Quantity</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody id="co-cart-body"></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"></td>
                            <td id="co-total-weight">0 lbs</td>
                            <td></td>
                            <td id="co-total-price">$0.00</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="co-comment-row">
                <label class="co-comment-label"><b>Comment</b></label>
                <textarea id="co-comment" class="form-control co-comment-input" rows="4" maxlength="200"></textarea>
            </div>

            <div class="co-actions co-cart-footer">
                <button type="button" class="btn btn-default" id="co-print-btn">Print</button>
                <button type="button" class="btn btn-default" id="co-quote-btn">Save Quote</button>
                <button type="button" class="btn btn-default" id="co-shipping-btn">Request Shipping Quote</button>
                <button type="button" class="btn btn-default" id="co-stock-check-btn">Stock Check</button>
                <button type="button" class="btn btn-default d-none" id="co-process-btn">Process Order</button>
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ tenant_static_asset('js/create-order.js') }}?v=6"></script>
@endpush
