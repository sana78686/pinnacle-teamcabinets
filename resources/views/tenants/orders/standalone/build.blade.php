@extends('layouts.tenant.standalone')

@section('title', 'Build Order')

@section('content')
<div class="co-shell co-shell--build"
    data-catalog-id="{{ $catalog->id }}"
    data-door-id="{{ $door->id }}"
    data-catalog-name="{{ $catalog->name }}"
    data-door-label="{{ $door->product_label }}"
    data-search-url="{{ route('tenant_order_workspace_search', [$catalog->id, $door->id]) }}"
    data-store-url="{{ route('tenant_order_workspace_store') }}"
    data-csrf="{{ csrf_token() }}">

    <header class="co-topbar co-topbar--compact">
        <div class="co-topbar__brand">
            <a href="{{ route('tenant_order_workspace_doors', $catalog->id) }}" class="co-topbar__back"><i class="fa-solid fa-arrow-left"></i> Door styles</a>
            <div>
                <h1>{{ $catalog->name }}</h1>
                <p class="co-topbar__sub">{{ $door->product_label }}</p>
            </div>
        </div>
        @include('tenants.orders.standalone.partials.steps')
    </header>

    <div class="co-build">
        <aside class="co-build__picker">
            <div class="co-selection-chip">
                @if ($door->image)
                    <img src="{{ asset($door->image) }}" alt="">
                @endif
                <div>
                    <strong>{{ $door->product_label }}</strong>
                    <span>{{ $catalog->name }}</span>
                </div>
            </div>

            <div class="co-search">
                <input type="search" id="co-sku-search" placeholder="Enter SKU number" autocomplete="off">
                <button type="button" id="co-sku-search-btn" class="co-btn co-btn--secondary">Search</button>
            </div>
            <p class="co-hint">Empty search resets the list. Double-click a cabinet label to add it to the active room.</p>

            <div class="co-accordion" id="co-product-sections">
                @foreach ($sections as $section)
                    <details class="co-accordion__item">
                        <summary>{{ $section->cabinets_name }}</summary>
                        <div class="co-table-wrap">
                            <table class="co-table co-table--picker">
                                <thead>
                                    <tr>
                                        <th>Cabinet label</th>
                                        <th>SKU</th>
                                        <th>Weight</th>
                                        <th>Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($section->products as $product)
                                        <tr class="co-product-row"
                                            data-product-id="{{ $product->id }}"
                                            data-label="{{ $product->label }}"
                                            data-sku="{{ $product->sku }}"
                                            data-description="{{ $product->sku }} — {{ $door->product_label }} — {{ $product->description }}"
                                            data-weight="{{ preg_replace('/[^\d.]/', '', (string) $product->weight) }}"
                                            data-cost="{{ preg_replace('/[^\d.]/', '', (string) $product->cost) }}"
                                            data-assemble="{{ preg_replace('/[^\d.]/', '', (string) $product->assemble_cost) }}">
                                            <td class="co-product-label">{{ $product->label }}</td>
                                            <td>{{ $product->sku }}</td>
                                            <td>{{ $product->weight }}</td>
                                            <td>${{ number_format((float) preg_replace('/[^\d.]/', '', (string) $product->cost), 2) }}</td>
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

        <section class="co-build__cart">
            <p class="co-cart-intro"><strong>Step 1:</strong> Enter job name and add at least one room before selecting products.</p>

            <div class="co-cart-toolbar">
                <label class="co-field">
                    <span>Job name <em>*</em></span>
                    <input type="text" id="co-job-name" value="Quote Data" maxlength="120">
                </label>
                <button type="button" class="co-btn co-btn--primary" id="co-add-room">+ Add room</button>
                <button type="button" class="co-btn co-btn--ghost" id="co-clear-cart">Clear cart</button>
            </div>

            <fieldset class="co-assemble">
                <legend>Assemble all cabinetry? <em>*</em></legend>
                <label><input type="radio" name="assemble" value="yes"> Yes</label>
                <label><input type="radio" name="assemble" value="no" checked> No</label>
            </fieldset>

            <div class="co-table-wrap co-cart-table-wrap">
                <table class="co-table co-table--cart" id="co-cart-table">
                    <thead>
                        <tr>
                            <th>Check</th>
                            <th>Cabinet</th>
                            <th>Description</th>
                            <th>Weight</th>
                            <th>Unit</th>
                            <th>Total</th>
                            <th>Qty</th>
                            <th></th>
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

            <label class="co-field co-field--block">
                <span>Comment</span>
                <textarea id="co-comment" rows="3" maxlength="200"></textarea>
            </label>

            <div class="co-actions">
                <button type="button" class="co-btn co-btn--ghost" id="co-print-btn">Print</button>
                <button type="button" class="co-btn co-btn--secondary" id="co-quote-btn">Save quote</button>
                <button type="button" class="co-btn co-btn--secondary" id="co-shipping-btn">Request shipping quote</button>
                <button type="button" class="co-btn co-btn--primary" id="co-process-btn">Process order</button>
            </div>
        </section>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/create-order.js') }}?v=1"></script>
@endpush
