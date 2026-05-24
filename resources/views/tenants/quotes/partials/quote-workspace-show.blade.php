@php
    $hasAssemble = $assembleYes ?? false;
    $colSpan = $hasAssemble ? 8 : 7;
    $billAddress = implode(', ', array_filter([
        $bill_to_address ?? '',
        $bill_to_city ?? '',
        $bill_to_county ?? '',
        $bill_to_state ?? '',
        $bill_to_zipcode ?? '',
        $bill_to_country ?? '',
    ])) ?: '—';
    $shipAddress = implode(', ', array_filter([
        $ship_to_address ?? '',
        $ship_to_city ?? '',
        $ship_to_county ?? '',
        $ship_to_state ?? '',
        $ship_to_zipcode ?? '',
        $ship_to_country ?? '',
    ])) ?: '—';
    $pageTitle = $pageTitle ?? 'View Quote';
    $listRoute = $listRoute ?? 'tenant_quotes_index';
@endphp

<div class="container-fluid tc-quote-show" id="{{ ($isShippingQuote ?? false) ? 'tc-shipping-quote-admin' : 'tc-quote-show-page' }}"
    @if ($isShippingQuote ?? false)
        data-pallet-unit="{{ $palletUnitCost ?? 0 }}"
        data-subtotal="{{ $sub_total_price ?? 0 }}"
        data-assemble="{{ $sub_total_assemble ?? 0 }}"
    @endif>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">{{ $pageTitle }}</h4>
        <a href="{{ route($listRoute) }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    @include('partial.message')

    {{-- CI: one header row (bill | ship | quote meta) --}}
    <div class="table-responsive mb-3 tc-quote-show__header-wrap">
        <table class="table table-bordered table-sm mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:33%">Bill To</th>
                    <th style="width:33%">Ship To</th>
                    <th style="width:34%">Quote Information</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="align-top">
                        <div><strong>Name:</strong> {{ $bill_to_name ?? '—' }}</div>
                        <div><strong>Address:</strong> {{ $billAddress }}</div>
                        <div><strong>Email:</strong> {{ $bill_to_email ?: '—' }}</div>
                        <div><strong>Phone:</strong> {{ $bill_to_phone ?: '—' }}</div>
                    </td>
                    <td class="align-top">
                        <div><strong>Name:</strong> {{ $ship_to_name ?? '—' }}</div>
                        <div><strong>Address:</strong> {{ $shipAddress }}</div>
                        <div><strong>Email:</strong> {{ $ship_to_email ?: '—' }}</div>
                        <div><strong>Phone:</strong> {{ $ship_to_phone ?: '—' }}</div>
                    </td>
                    <td class="align-top">
                        <div><strong>{{ ($isShippingQuote ?? false) ? 'Shipping Quote' : 'Quote' }} #:</strong> {{ $record->id }}</div>
                        <div><strong>{{ ($isShippingQuote ?? false) ? 'Shipping Quote' : 'Quote' }} Name:</strong> {{ $quoteName ?? '—' }}</div>
                        <div><strong>Order #:</strong> N/A</div>
                        <div><strong>Date:</strong> {{ $record->created_at?->format('m-d-Y') ?? '—' }}</div>
                        <div><strong>Company Name:</strong> {{ $companyName ?? '—' }}</div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- CI: company + job name above line items table --}}
    <div class="tc-quote-show__meta-above-table mb-2">
        <div><strong>Company Name</strong> : {{ $companyName ?? '—' }}</div>
        <div><strong>Job Name</strong> : {{ $record->job_name ?? '—' }}</div>
    </div>

    {{-- Line items table --}}
    <div class="table-responsive mb-0">
        <table class="table table-bordered table-sm mb-0 tc-quote-show__lines">
            <thead>
                <tr>
                    <th>Double Check Work</th>
                    <th>Cabinet Name</th>
                    <th>Cabinet Description</th>
                    <th class="text-end">Weight</th>
                    <th class="text-end">Unit Price</th>
                    <th class="text-end">Total Price</th>
                    <th class="text-end">Quantity</th>
                    @if ($hasAssemble)<th class="text-end">Assemble Cost</th>@endif
                </tr>
            </thead>
            <tbody>
                @php $lastRoom = null; @endphp
                @forelse ($lines as $line)
                    @if ($lastRoom !== ($line['room_name'] ?? ''))
                        @php $lastRoom = $line['room_name'] ?? ''; @endphp
                        <tr class="table-light">
                            <th colspan="{{ $colSpan }}">{{ $lastRoom }}</th>
                        </tr>
                    @endif
                    <tr>
                        <td class="tc-sq-admin__checks">
                            <span class="tc-sq-check tc-sq-check--yellow{{ ! empty($line['check_yellow']) ? ' is-on' : '' }}"></span>
                            <span class="tc-sq-check tc-sq-check--green{{ ! empty($line['check_green']) ? ' is-on' : '' }}"></span>
                        </td>
                        <td>{{ $line['cabinet_name'] }}</td>
                        <td>{{ $line['description'] }}</td>
                        <td class="text-end">{{ number_format($line['weight'], 2) }} lbs</td>
                        <td class="text-end">${{ number_format($line['unit_price'], 2) }}</td>
                        <td class="text-end">${{ number_format($line['line_total'], 2) }}</td>
                        <td class="text-end">{{ $line['quantity'] }}</td>
                        @if ($hasAssemble)
                            <td class="text-end">
                                @if (($line['assemble_cost'] ?? 0) > 0)
                                    ${{ number_format($line['assemble_cost'], 2) }}
                                @else
                                    N/A
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr><td colspan="{{ $colSpan }}" class="text-center text-muted">No line items.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                @if ($isShippingQuote ?? false)
                    <tr class="table-light fw-semibold">
                        <td colspan="3" class="text-end">Sub Total</td>
                        <td class="text-end" id="sq-display-subtotal-weight">{{ number_format($sub_total_weight ?? 0, 2) }} lbs</td>
                        <td></td>
                        <td class="text-end" id="sq-display-subtotal-price">${{ number_format($sub_total_price ?? 0, 2) }}</td>
                        <td></td>
                        @if ($hasAssemble)
                            <td class="text-end" id="sq-display-subtotal-assemble">${{ number_format($sub_total_assemble ?? 0, 2) }}</td>
                        @endif
                    </tr>
                @endif
                @if ($hasAssemble)
                    <tr>
                        <th colspan="5" class="text-end">Cabinetry Assembly Cost</th>
                        <td class="text-end" id="sq-summary-assemble">${{ number_format($sub_total_assemble ?? 0, 2) }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                @endif
                @if ($isShippingQuote ?? false)
                    <tr class="table-secondary">
                        <th colspan="{{ $colSpan }}" class="text-start">Shipping Charges</th>
                    </tr>
                    <tr>
                        <td colspan="5">Pallets Cost (Total Pallets = <span id="sq-summary-pallets-count">{{ $total_pallets ?? 1 }}</span>)</td>
                        <td class="text-end">$<span id="sq-summary-pallets-cost">{{ number_format($pallets_cost ?? 0, 2) }}</span></td>
                        <td></td>
                        @if ($hasAssemble)<td></td>@endif
                    </tr>
                    <tr>
                        <td colspan="5">Delivery Cost ({{ $deliveryLabel ?? 'Residential' }})</td>
                        <td class="text-end">$<span id="sq-summary-delivery">{{ number_format($delivery_cost ?? 0, 2) }}</span></td>
                        <td></td>
                        @if ($hasAssemble)<td></td>@endif
                    </tr>
                    <tr>
                        <td colspan="5">Liftgate Cost</td>
                        <td class="text-end">$<span id="sq-summary-liftgate">{{ number_format($liftgate_cost ?? 0, 2) }}</span></td>
                        <td></td>
                        @if ($hasAssemble)<td></td>@endif
                    </tr>
                    <tr>
                        <td colspan="5">Unload Cost ({{ $unloadLabel ?? 'By Forklift' }})</td>
                        <td class="text-end">$<span id="sq-summary-unload">{{ number_format($unload_cost ?? 0, 2) }}</span></td>
                        <td></td>
                        @if ($hasAssemble)<td></td>@endif
                    </tr>
                    <tr>
                        <td colspan="5">Miscellaneous Charges</td>
                        <td class="text-end">$<span id="sq-summary-misc">{{ number_format($miscellaneous_cost ?? 0, 2) }}</span></td>
                        <td></td>
                        @if ($hasAssemble)<td></td>@endif
                    </tr>
                @endif
                <tr class="table-light fw-semibold">
                    <th colspan="2" class="text-end">{{ ($isShippingQuote ?? false) ? 'Order Total' : 'Total' }}</th>
                    <td></td>
                    <td class="text-end">{{ number_format($sub_total_weight ?? 0, 0) }} lbs</td>
                    <td></td>
                    <td class="text-end">$<span id="sq-display-order-total">{{ number_format($grand_total ?? 0, 2) }}</span></td>
                    <td></td>
                    @if ($hasAssemble)<td></td>@endif
                </tr>
            </tfoot>
        </table>
    </div>

    {{-- Comment + actions below table (CI) --}}
    <div class="tc-quote-show__footer mt-3">
        @if (! empty($record->comment))
            <div class="mb-3">
                <strong>Comment :</strong>
                <p class="mb-0 mt-1 text-break order_comment_para_cls">{{ $record->comment }}</p>
            </div>
        @endif

        <div class="d-flex flex-wrap justify-content-end align-items-center gap-2">
            @if (! empty($editRoute))
                <a href="{{ route($editRoute, $record->id) }}" class="btn btn-outline-primary">CONTINUE TO CART</a>
            @endif
            @if (! empty($canProceedToCheckout))
                <form method="POST" action="{{ $proceedCheckoutRoute }}" class="d-inline mb-0">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg">Proceed To Checkout</button>
                </form>
            @elseif (($isShippingQuote ?? false) && empty($showAdminForm) && (float) ($shipping_cost ?? 0) <= 0)
                <span class="text-muted small me-2">Shipping charges pending — checkout available after admin completes quote.</span>
            @endif
        </div>

        @if (! empty($showAdminForm))
            <form method="POST" action="{{ $updateRoute }}" id="sq-admin-shipping-form" class="tc-sq-admin__form tc-stock-check-admin-panel border rounded p-3 mt-3">
                @csrf
                @method('PUT')
                <div class="row g-2 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label mb-0 small fw-semibold" for="sq_total_pallets">Total Pallets</label>
                        <input type="number" min="1" step="1" class="form-control form-control-sm sq-cost-input"
                            name="total_pallets" id="sq_total_pallets" value="{{ $total_pallets ?? 1 }}" data-field="pallets">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-0 small fw-semibold" for="sq_delivery_cost">Delivery Cost</label>
                        <input type="number" min="0" step="0.01" class="form-control form-control-sm sq-cost-input"
                            name="delivery_cost" id="sq_delivery_cost" value="{{ number_format($delivery_cost ?? 0, 2, '.', '') }}" data-field="delivery">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-0 small fw-semibold" for="sq_liftgate_cost">Liftgate Cost</label>
                        <input type="number" min="0" step="0.01" class="form-control form-control-sm sq-cost-input"
                            name="liftgate_cost" id="sq_liftgate_cost" value="{{ number_format($liftgate_cost ?? 0, 2, '.', '') }}" data-field="liftgate">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-0 small fw-semibold" for="sq_unload_cost">Unload Cost</label>
                        <input type="number" min="0" step="0.01" class="form-control form-control-sm sq-cost-input"
                            name="unload_cost" id="sq_unload_cost" value="{{ number_format($unload_cost ?? 0, 2, '.', '') }}" data-field="unload">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label mb-0 small fw-semibold" for="sq_misc_cost">Miscellaneous Charges</label>
                        <input type="number" min="0" step="0.01" class="form-control form-control-sm sq-cost-input"
                            name="miscellaneous_cost" id="sq_misc_cost" value="{{ number_format($miscellaneous_cost ?? 0, 2, '.', '') }}" data-field="misc">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary btn-sm w-100">Submit</button>
                    </div>
                </div>
                <div class="mt-2 text-end tc-sq-admin__shipping-total">
                    Total Shipping Charges: $<span id="sq-total-shipping-charges">{{ number_format($shipping_cost ?? 0, 2) }}</span>
                </div>
            </form>
        @endif
    </div>
</div>
