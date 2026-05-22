@php
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
@endphp

<div class="container-fluid tc-sq-admin" id="tc-shipping-quote-admin"
    data-pallet-unit="{{ $palletUnitCost }}"
    data-subtotal="{{ $sub_total_price }}"
    data-assemble="{{ $sub_total_assemble }}">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">View Shipping Quote</h4>
        <a href="{{ route($listRoute) }}" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i> Back</a>
    </div>

    @include('partial.message')

    <div class="table-responsive mb-3">
        <table class="table table-bordered table-sm mb-0 tc-sq-admin__header-table">
            <tbody>
                <tr class="table-light">
                    <th style="width:33%">Bill To:</th>
                    <th style="width:33%">Ship To:</th>
                    <th style="width:34%"></th>
                </tr>
                <tr>
                    <td>
                        <div><strong>Name:</strong> {{ $bill_to_name }}</div>
                        <div><strong>Address:</strong> {{ $billAddress }}</div>
                        <div><strong>Email:</strong> {{ $bill_to_email ?: '—' }}</div>
                        <div><strong>Phone:</strong> {{ $bill_to_phone ?: '—' }}</div>
                    </td>
                    <td>
                        <div><strong>Name:</strong> {{ $ship_to_name }}</div>
                        <div><strong>Address:</strong> {{ $shipAddress }}</div>
                        <div><strong>Email:</strong> {{ $ship_to_email ?: '—' }}</div>
                        <div><strong>Phone:</strong> {{ $ship_to_phone ?: '—' }}</div>
                    </td>
                    <td>
                        <div><strong>Shipping Quote #:</strong> {{ $record->id }}</div>
                        <div><strong>Shipping Quote Name:</strong> {{ $quoteName }}</div>
                        <div><strong>Order #:</strong> N/A</div>
                        <div><strong>Date:</strong> {{ $record->created_at?->format('m-d-Y') ?? '—' }}</div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Company Name:</strong> {{ $companyName }}</td>
                </tr>
                <tr>
                    <td colspan="3"><strong>Job Name:</strong> {{ $record->job_name ?? '—' }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="table-responsive mb-3">
        <table class="table table-bordered table-sm mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>Double Check Work</th>
                    <th>Cabinet Name</th>
                    <th>Cabinet Description</th>
                    <th class="text-end">Weight</th>
                    <th class="text-end">Unit Price</th>
                    <th class="text-end">Total Price</th>
                    <th class="text-end">Quantity</th>
                    <th class="text-end">Assemble Cost</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lines as $line)
                    <tr>
                        <td class="tc-sq-admin__checks">
                            <span class="tc-sq-check tc-sq-check--yellow{{ $line['check_yellow'] ? ' is-on' : '' }}" title="Check 1"></span>
                            <span class="tc-sq-check tc-sq-check--green{{ $line['check_green'] ? ' is-on' : '' }}" title="Check 2"></span>
                        </td>
                        <td>{{ $line['cabinet_name'] }}</td>
                        <td>{{ $line['description'] }}</td>
                        <td class="text-end">{{ number_format($line['weight'], 2) }}</td>
                        <td class="text-end">${{ number_format($line['unit_price'], 2) }}</td>
                        <td class="text-end">${{ number_format($line['line_total'], 2) }}</td>
                        <td class="text-end">{{ $line['quantity'] }}</td>
                        <td class="text-end">${{ number_format($line['assemble_cost'], 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="8" class="text-center text-muted">No line items.</td></tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="table-light fw-semibold">
                    <td colspan="3" class="text-end">Sub Total</td>
                    <td class="text-end" id="sq-display-subtotal-weight">{{ number_format($sub_total_weight, 2) }} lbs</td>
                    <td></td>
                    <td class="text-end" id="sq-display-subtotal-price">${{ number_format($sub_total_price, 2) }}</td>
                    <td></td>
                    <td class="text-end" id="sq-display-subtotal-assemble">${{ number_format($sub_total_assemble, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="row mb-3">
        <div class="col-lg-6">
            <table class="table table-bordered table-sm mb-0">
                <tbody>
                    <tr>
                        <th>Cabinetry Assembly Cost</th>
                        <td class="text-end" id="sq-summary-assemble">${{ number_format($sub_total_assemble, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-lg-6">
            <table class="table table-bordered table-sm mb-0">
                <thead class="table-secondary">
                    <tr><th colspan="2">Shipping Charges</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Pallets Cost (Total Pallets = <span id="sq-summary-pallets-count">{{ $total_pallets }}</span>)</td>
                        <td class="text-end">$<span id="sq-summary-pallets-cost">{{ number_format($pallets_cost, 2) }}</span></td>
                    </tr>
                    <tr>
                        <td>Delivery Cost ({{ $deliveryLabel }})</td>
                        <td class="text-end">$<span id="sq-summary-delivery">{{ number_format($delivery_cost, 2) }}</span></td>
                    </tr>
                    <tr>
                        <td>Liftgate Cost</td>
                        <td class="text-end">$<span id="sq-summary-liftgate">{{ number_format($liftgate_cost, 2) }}</span></td>
                    </tr>
                    <tr>
                        <td>Unload Cost ({{ $unloadLabel }})</td>
                        <td class="text-end">$<span id="sq-summary-unload">{{ number_format($unload_cost, 2) }}</span></td>
                    </tr>
                    <tr>
                        <td>Miscellaneous Charges</td>
                        <td class="text-end">$<span id="sq-summary-misc">{{ number_format($miscellaneous_cost, 2) }}</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <table class="table table-bordered table-sm mb-3">
        <tbody>
            <tr class="table-light fw-semibold">
                <th>Order Total</th>
                <td class="text-end" style="width:25%">{{ number_format($sub_total_weight, 0) }} lbs</td>
                <td class="text-end" style="width:25%">$<span id="sq-display-order-total">{{ number_format($grand_total, 2) }}</span></td>
            </tr>
        </tbody>
    </table>

    @if (! empty($record->comment))
        <div class="mb-3">
            <label class="fw-semibold d-block">Comment</label>
            <div class="border rounded p-2 bg-light">{{ $record->comment }}</div>
        </div>
    @endif

    <form method="POST" action="{{ $updateRoute }}" id="sq-admin-shipping-form" class="tc-sq-admin__form border rounded p-3 bg-light">
        @csrf
        @method('PUT')
        <div class="row g-2 align-items-end">
            <div class="col-md-2">
                <label class="form-label mb-0 small fw-semibold" for="sq_total_pallets">Total Pallets</label>
                <input type="number" min="1" step="1" class="form-control form-control-sm sq-cost-input"
                    name="total_pallets" id="sq_total_pallets" value="{{ $total_pallets }}" data-field="pallets">
            </div>
            <div class="col-md-2">
                <label class="form-label mb-0 small fw-semibold" for="sq_delivery_cost">Delivery Cost</label>
                <input type="number" min="0" step="0.01" class="form-control form-control-sm sq-cost-input"
                    name="delivery_cost" id="sq_delivery_cost" value="{{ number_format($delivery_cost, 2, '.', '') }}" data-field="delivery">
            </div>
            <div class="col-md-2">
                <label class="form-label mb-0 small fw-semibold" for="sq_liftgate_cost">Liftgate Cost</label>
                <input type="number" min="0" step="0.01" class="form-control form-control-sm sq-cost-input"
                    name="liftgate_cost" id="sq_liftgate_cost" value="{{ number_format($liftgate_cost, 2, '.', '') }}" data-field="liftgate">
            </div>
            <div class="col-md-2">
                <label class="form-label mb-0 small fw-semibold" for="sq_unload_cost">Unload Cost</label>
                <input type="number" min="0" step="0.01" class="form-control form-control-sm sq-cost-input"
                    name="unload_cost" id="sq_unload_cost" value="{{ number_format($unload_cost, 2, '.', '') }}" data-field="unload">
            </div>
            <div class="col-md-2">
                <label class="form-label mb-0 small fw-semibold" for="sq_misc_cost">Miscellaneous Charges</label>
                <input type="number" min="0" step="0.01" class="form-control form-control-sm sq-cost-input"
                    name="miscellaneous_cost" id="sq_misc_cost" value="{{ number_format($miscellaneous_cost, 2, '.', '') }}" data-field="misc">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary btn-sm w-100">Submit</button>
            </div>
        </div>
        <div class="mt-2 text-end fw-semibold">
            Total Shipping Charges: $<span id="sq-total-shipping-charges">{{ number_format($shipping_cost, 2) }}</span>
        </div>
    </form>
</div>
