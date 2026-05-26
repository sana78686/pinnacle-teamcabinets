@php
    $record = $stock_check_request ?? $record;
    $isAdmin = $isAdminView ?? false;
    $hasAssemble = $assembleYes ?? false;
    $colSpan = $hasAssemble ? 9 : 8;
    $billAddress = implode(', ', array_filter([
        $bill_to_address ?? '',
        $bill_to_city ?? '',
        $bill_to_county ?? '',
        $bill_to_state ?? '',
        $bill_to_zipcode ?? '',
        $bill_to_country ?? '',
    ])) ?: ($record->user_address ?? '—');
    $shipAddress = implode(', ', array_filter([
        $ship_to_address ?? '',
        $ship_to_city ?? '',
        $ship_to_county ?? '',
        $ship_to_state ?? '',
        $ship_to_zipcode ?? '',
        $ship_to_country ?? '',
    ])) ?: ($record->user_address ?? '—');
    $footerShippingBreakdown = $isAdmin
        ? ($isShippingRequired ?? false)
        : ($showUserShipping ?? false);
    $footerSimpleShipping = $isAdmin
        ? (! ($isShippingRequired ?? false) && ($isApproved ?? false) && (float) ($shipping_cost ?? 0) > 0)
        : ($showSimpleShipping ?? false);
@endphp

<div class="container-fluid tc-quote-show" id="{{ $isAdmin ? 'tc-stock-check-admin' : 'tc-stock-check-user' }}"
    @if ($isAdmin)
        data-pallet-unit="{{ $palletUnitCost ?? 30 }}"
        data-subtotal="{{ $sub_total_price ?? 0 }}"
        data-assemble="{{ $sub_total_assemble ?? 0 }}"
        data-fuel="{{ $fuel_charges ?? 0 }}"
    @endif>

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <div>
            <h4 class="mb-1">{{ $pageTitle ?? 'Stock Check Request' }}</h4>
            @if ($isAdmin && ($viewingOrgData ?? false))
                <span class="badge bg-warning text-dark">Viewing original submitted data</span>
            @endif
            @if ($isAdmin)
                <div class="text-muted small">Request #{{ $record->id }} · {{ ($isApproved ?? false) ? 'Approved' : 'Pending approval' }}</div>
            @endif
        </div>
        <div class="d-flex gap-2">
            @if ($isAdmin && ($showAdminForm ?? false))
                <a href="{{ $editRoute ?? route('tenant_stock_check_edit', $record->id) }}" class="btn btn-outline-primary btn-sm">Edit</a>
            @endif
            <a href="{{ $listRoute ?? route('tenant_stock_check_index') }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>

    @include('partial.message')
    <div id="{{ $isAdmin ? 'sc-status-msg' : 'sc-user-status-msg' }}" class="alert py-2 mb-3" style="display:none;" role="status"></div>

    <div class="table-responsive mb-3 tc-quote-show__header-wrap">
        <table class="table table-bordered table-sm mb-0">
            <thead class="table-light">
                <tr>
                    <th style="width:{{ $isAdmin ? '33%' : '50%' }}">Bill To</th>
                    <th style="width:{{ $isAdmin ? '33%' : '50%' }}">Ship To</th>
                    @if ($isAdmin)
                        <th style="width:34%">Stock Check Information</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="align-top">
                        <div><strong>Name:</strong> {{ $bill_to_name ?? $billName ?? '—' }}</div>
                        <div><strong>Address:</strong> {{ $billAddress }}</div>
                        <div><strong>Email:</strong> {{ $bill_to_email ?? ($record->user_email ?? '—') }}</div>
                        <div><strong>Phone:</strong> {{ $bill_to_phone ?? ($record->user_phone ?? '—') }}</div>
                    </td>
                    <td class="align-top">
                        <div><strong>Name:</strong> {{ $ship_to_name ?? $billName ?? '—' }}</div>
                        <div><strong>Address:</strong> {{ $shipAddress }}</div>
                        <div><strong>Email:</strong> {{ $ship_to_email ?? ($record->user_email ?? '—') }}</div>
                        <div><strong>Phone:</strong> {{ $ship_to_phone ?? ($record->user_phone ?? '—') }}</div>
                    </td>
                    @if ($isAdmin)
                        <td class="align-top">
                            <div><strong>STOCK CHECK DATE #:</strong> {{ $record->created_at?->format('Y-m-d') ?? '—' }}</div>
                            <div><strong>STOCK CHECK REQUEST #:</strong> {{ $record->id }}</div>
                            <div><strong>Order #:</strong> N/A</div>
                            <div><strong>Company Name:</strong> {{ $companyName ?? 'N/A' }}</div>
                        </td>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>

    <div class="tc-quote-show__meta-above-table mb-2">
        @if ($isAdmin)
            <div><strong>Company Name</strong> : {{ $companyName ?? 'N/A' }}</div>
        @endif
        <div><strong>Job Name</strong> : {{ $record->job_name ?? '—' }}</div>
    </div>

    @if (! $isAdmin)
        <form action="{{ $itemNotesRoute ?? '#' }}" id="sc-item-notes-form" method="post">
            @csrf
    @endif

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
                    <th>Item {{ $isAdmin ? 'Note' : 'Notes' }}</th>
                </tr>
            </thead>
            <tbody>
                @php $lastRoom = null; @endphp
                @forelse ($lines as $lineIndex => $line)
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
                        <td>{{ $line['sku'] ?: $line['cabinet_name'] }}</td>
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
                        <td>
                            @if ($isAdmin || ($notesLocked ?? false))
                                {{ $line['note'] ?? '' }}
                            @else
                                <textarea class="form-control form-control-sm product_note" style="width:100%; min-width:100%;"
                                    name="line_notes[{{ $lineIndex }}]" rows="2">{{ $line['note'] ?? '' }}</textarea>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ $colSpan }}" class="text-center text-muted">No line items found.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                @include('tenants.stock_check.partials.summary-footer', [
                    'assembleYes' => $hasAssemble,
                    'showShippingBreakdown' => $footerShippingBreakdown,
                    'showSimpleShipping' => $footerSimpleShipping,
                    'totalLabel' => $isAdmin ? 'Order Total' : 'Total',
                    'grandTotalDisplay' => $displayGrandTotal ?? $grand_total ?? 0,
                ])
            </tfoot>
        </table>
    </div>

    @if (! $isAdmin)
        </form>
    @endif

    <div class="tc-quote-show__footer mt-3">
        @if (filled($record->comment))
            <div class="mb-3">
                <strong>Comment :</strong>
                <p class="mb-0 mt-1 text-break">{{ $record->comment }}</p>
            </div>
        @endif

        @if (! $isAdmin && ($canProceedToCheckout ?? false))
            <div class="d-flex flex-wrap justify-content-end align-items-center gap-2">
                <button type="button" class="btn btn-primary approve_stock_check" id="sc-btn-proceed-checkout">
                    Approve &amp; Proceed To Checkout
                </button>
            </div>
            <form method="POST" action="{{ $proceedCheckoutRoute }}" id="sc-proceed-checkout-form" class="d-none">
                @csrf
            </form>
            <div class="modal fade" id="userStockCheckApproveModal" tabindex="-1" aria-labelledby="userStockCheckApproveModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="userStockCheckApproveModalLabel">Stock Check Approved Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body tc-stock-check-approve-popup">
                            {!! other_page_content('stock_check_approve_pop_up') !!}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" id="sc-proceed-checkout-confirm">Yes</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">No</button>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($isApproved ?? false)
            <p class="text-success mb-0">This stock check request has been approved.</p>
        @elseif ($isAdmin)
            @if ($isShippingRequired ?? false)
                <form method="POST" action="{{ $updateRoute }}" id="sc-admin-shipping-form" class="tc-sq-admin__form tc-stock-check-admin-panel border rounded p-3 mb-3">
                    @csrf
                    @method('PUT')
                    <div class="row g-2 align-items-end">
                        <div class="col-md-2">
                            <label class="form-label mb-0 small fw-semibold" for="sc_total_pallets">Total Pallets</label>
                            <input type="number" min="1" step="1" class="form-control form-control-sm sc-cost-input"
                                name="total_pallets" id="sc_total_pallets" value="{{ $total_pallets ?? 1 }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-0 small fw-semibold" for="sc_delivery_cost">Delivery Cost</label>
                            <input type="number" min="0" step="0.01" class="form-control form-control-sm sc-cost-input"
                                name="delivery_cost" id="sc_delivery_cost" value="{{ number_format($delivery_cost ?? 0, 2, '.', '') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-0 small fw-semibold" for="sc_liftgate_cost">Liftgate Cost</label>
                            <input type="number" min="0" step="0.01" class="form-control form-control-sm sc-cost-input"
                                name="liftgate_cost" id="sc_liftgate_cost" value="{{ number_format($liftgate_cost ?? 0, 2, '.', '') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-0 small fw-semibold" for="sc_unload_cost">Unload Cost</label>
                            <input type="number" min="0" step="0.01" class="form-control form-control-sm sc-cost-input"
                                name="unload_cost" id="sc_unload_cost" value="{{ number_format($unload_cost ?? 0, 2, '.', '') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label mb-0 small fw-semibold" for="sc_misc_cost">Miscellaneous Charges</label>
                            <input type="number" min="0" step="0.01" class="form-control form-control-sm sc-cost-input"
                                name="miscellaneous_cost" id="sc_misc_cost" value="{{ number_format($miscellaneous_cost ?? 0, 2, '.', '') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary btn-sm w-100">Approve Stock Check</button>
                        </div>
                    </div>
                    <div class="mt-2 text-end tc-sc-shipping-total">
                        Total Shipping Charges: $<span id="sc-total-shipping-charges">{{ number_format($shipping_cost ?? 0, 2) }}</span>
                    </div>
                </form>
            @else
                <form method="POST" action="{{ $updateRoute }}" id="sc-admin-simple-form" class="tc-stock-check-admin-panel border rounded p-3 mb-3">
                    @csrf
                    @method('PUT')
                    <div class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label mb-0" for="sc_shipping_charges">Shipping Charges</label>
                            <input type="number" min="0" step="0.01" class="form-control" name="shipping_charges"
                                id="sc_shipping_charges" value="{{ $record->shipping_cost ?? '' }}" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary">Approve Stock Check</button>
                        </div>
                    </div>
                </form>
            @endif

            <form id="sc-warehouse-email-form" class="tc-stock-check-admin-panel border rounded p-3"
                data-action="{{ $warehouseEmailRoute ?? route('tenant_stock_check_warehouse_email', $record->id) }}">
                <div class="row g-2 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label mb-0" for="sc_warehouse_email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="sc_warehouse_email" name="email">
                        <div id="sc-warehouse-email-msg" class="small mt-1"></div>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary sc-warehouse-submit-btn">Send Email To Warehouse</button>
                    </div>
                </div>
            </form>
        @else
            <div class="d-flex justify-content-end flex-wrap gap-2">
                <a href="{{ $editRoute ?? route('tenant_stock_check_edit', $record->id) }}" class="btn btn-primary">Edit Stock Check</a>
                <button type="button" class="btn btn-primary" id="sc-btn-update-notes">Update Item Notes</button>
            </div>
        @endif
    </div>
</div>
