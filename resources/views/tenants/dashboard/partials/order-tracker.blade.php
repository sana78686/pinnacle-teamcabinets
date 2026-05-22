@php
    $trackerRows = $trackerRows ?? collect();
    $trackerStatuses = $trackerStatuses ?? [];
    $fuelChargePercent = $fuelChargePercent ?? 0;
@endphp

<div class="card tc-dash-card tc-dash-tracker mb-4">
    <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
        <div>
            <h5 class="mb-0 tc-dash-card__title">Order tracker details</h5>
            <p class="tc-dash-card__sub mb-0">Edit fields inline; changes save automatically.</p>
        </div>
    </div>
    @if ($trackerRows->total() > 0)
    <div class="card-body border-bottom py-2">
        <form method="get" action="{{ route('tenant_dashboard') }}" class="tc-list-toolbar row align-items-center g-2 mb-0">
            <div class="col-auto">
                <label class="tc-list-toolbar__label mb-0 me-1">Show</label>
                <select name="tracker_per_page" class="form-control form-control-sm d-inline-block tc-list-toolbar__select" onchange="this.form.submit()">
                    @foreach ([10, 15, 25, 50] as $opt)
                        <option value="{{ $opt }}" @selected(($trackerPerPage ?? 10) === $opt)>{{ $opt }}</option>
                    @endforeach
                </select>
                <span class="text-muted small ms-1">entries</span>
            </div>
            <div class="col-auto ms-md-auto">
                <label class="tc-list-toolbar__label mb-0 me-1">Search:</label>
                <input type="search" name="tracker_search" class="form-control form-control-sm d-inline-block tc-list-toolbar__search"
                    value="{{ $trackerSearch ?? '' }}" placeholder="Filter orders…">
                <button type="submit" class="btn btn-sm btn-light ms-1">Go</button>
            </div>
        </form>
    </div>
    @endif
    <div class="card-body p-0">
        <div class="table-responsive tc-admin-datatable tc-dash-tracker-wrap">
            <table id="tcOrderTrackerTable" class="table table-striped table-bordered table-sm mb-0 tc-dash-tracker__table">
                <thead>
                    <tr>
                        <th class="tc-tracker-col-order">Order</th>
                        <th>Customer</th>
                        <th>Status</th>
                        <th class="text-center">Cust. paid</th>
                        <th class="text-center">Team paid</th>
                        <th class="text-end">Margin</th>
                        <th class="tc-tracker-col-actions text-center">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($trackerRows->total() > 0)
                        @foreach ($trackerRows as $row)
                        @php $detailId = 't-'.$row['order_id'].'-'.$row['sc_id'].'-'.$row['mq_id']; @endphp
                        <tr class="tc-tracker-row {{ !empty($row['is_unviewed']) ? 'tc-row-unviewed' : '' }}"
                            data-mark-viewed-url="{{ route('tenant_dashboard_tracker_viewed') }}"
                            data-mark-viewed-type="{{ $row['mark_viewed_type'] }}"
                            data-mark-viewed-id="{{ $row['mark_viewed_id'] }}"
                            data-update-url="{{ route('tenant_dashboard_tracker_update') }}"
                            data-fuel-percent="{{ $fuelChargePercent }}"
                            data-order-id="{{ $row['order_id'] }}"
                            data-sc-id="{{ $row['sc_id'] }}"
                            data-mq-id="{{ $row['mq_id'] }}"
                            data-sub-total="{{ $row['sub_total'] }}"
                            data-assemble="{{ $row['assemble_cabinetry_charged'] }}"
                            data-cc="{{ $row['credit_card_charges'] }}"
                            data-fuel="{{ $row['fuel_charges_display'] }}"
                            data-tax="{{ $row['tax_display'] }}"
                            <td class="tc-tracker-cell-order" data-label="Order">
                                @if ($row['order_show_url'])
                                    <a href="{{ $row['order_show_url'] }}" class="fw-semibold">{{ $row['order_number'] }}</a>
                                @else
                                    <span class="fw-semibold">{{ $row['order_number'] }}</span>
                                @endif
                                <div class="tc-tracker-meta">{{ $row['job_name'] ?: '—' }}</div>
                                @if ($row['sc_id'])
                                    <div class="tc-tracker-meta">
                                        SC#
                                        @if ($row['sc_show_url'])
                                            <a href="{{ $row['sc_show_url'] }}">{{ $row['sc_id'] }}</a>
                                        @else
                                            {{ $row['sc_id'] }}
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td data-label="Customer">
                                <span class="tc-tracker-customer">{{ $row['customer'] }}</span>
                                <div class="tc-tracker-meta">{{ $row['created_at'] }}</div>
                            </td>
                            <td data-label="Status">
                                <select class="form-select form-select-sm tc-tracker-field tc-select2-search" name="stock_check_status" data-field="stock_check_status">
                                    @foreach ($trackerStatuses as $value => $label)
                                        <option value="{{ $value }}" @selected((int) $row['stock_check_status'] === (int) $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center" data-label="Customer paid">
                                <select class="form-select form-select-sm tc-tracker-field tc-tracker-yn tc-select2-search" name="customer_paid">
                                    <option value="Yes" @selected($row['customer_paid'] === 'Yes')>Yes</option>
                                    <option value="No" @selected($row['customer_paid'] !== 'Yes')>No</option>
                                </select>
                            </td>
                            <td class="text-center" data-label="Team paid">
                                <select class="form-select form-select-sm tc-tracker-field tc-tracker-yn" name="team_paid">
                                    <option value="Yes" @selected($row['team_paid'] === 'Yes')>Yes</option>
                                    <option value="No" @selected($row['team_paid'] !== 'Yes')>No</option>
                                </select>
                            </td>
                            <td class="text-end">
                                <span class="tc-tracker-margin-badge tc-tracker-margin" data-margin-color="{{ $row['margin_color'] }}">
                                    ${{ number_format((float) $row['margin'], 2) }}
                                </span>
                            </td>
                            <td class="text-center" data-label="Details">
                                <button type="button" class="btn btn-sm btn-light tc-tracker-toggle" data-tracker-toggle="{{ $detailId }}"
                                    aria-expanded="false" aria-controls="tc-tracker-detail-{{ $detailId }}">
                                    <i data-feather="chevron-down" class="tc-tracker-toggle__icon" aria-hidden="true"></i>
                                    <span class="visually-hidden">Toggle details</span>
                                </button>
                            </td>
                        </tr>
                        <tr class="tc-tracker-detail-row d-none" id="tc-tracker-detail-{{ $detailId }}" data-tracker-detail="{{ $detailId }}">
                            <td colspan="7" class="p-0">
                                <div class="tc-tracker-detail-panel">
                                    <div class="row g-3">
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">QuickBooks invoice</label>
                                            <div class="tc-tracker-field-value">{{ $row['quickbooks_number'] }}</div>
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Vendor SC quotes</label>
                                            <input type="text" class="form-control form-control-sm tc-tracker-field" name="vendor_sc_q" value="{{ $row['vendor_sc_q'] }}">
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Vendor</label>
                                            <input type="text" class="form-control form-control-sm tc-tracker-field" name="vendor" value="{{ $row['vendor'] }}">
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Vendor sale order #</label>
                                            <input type="text" class="form-control form-control-sm tc-tracker-field" name="vendor_sale_order" value="{{ $row['vendor_sale_order'] }}">
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Vendor price</label>
                                            <input type="text" class="form-control form-control-sm tc-tracker-field tc-tracker-vendor-amount" name="vendor_amount" value="{{ $row['vendor_amount'] }}">
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Customer paid</label>
                                            <div class="tc-tracker-field-value">${{ number_format((float) $row['customer_paid_amount'], 2) }}</div>
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Subtotal</label>
                                            <div class="tc-tracker-field-value">$<span class="tc-tracker-subtotal-display">{{ number_format((float) $row['sub_total'], 2) }}</span></div>
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Discount</label>
                                            <div class="tc-tracker-field-value text-muted">—</div>
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Fuel</label>
                                            <div class="tc-tracker-field-value">$<span class="tc-tracker-fuel-display">{{ number_format((float) $row['fuel_charges_display'], 2) }}</span></div>
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">ASBL</label>
                                            <div class="tc-tracker-field-value">${{ number_format((float) $row['assemble_cabinetry_charged'], 2) }}</div>
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Tax</label>
                                            <div class="tc-tracker-field-value">$<span class="tc-tracker-tax-display">{{ is_numeric($row['tax_display']) ? number_format((float) $row['tax_display'], 2) : $row['tax_display'] }}</span></div>
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Miscellaneous</label>
                                            <input type="text" class="form-control form-control-sm tc-tracker-field tc-tracker-misc" name="miscellaneous" value="{{ $row['miscellaneous_input'] ?: '' }}" placeholder="0.00">
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Ship</label>
                                            <input type="text" class="form-control form-control-sm tc-tracker-field tc-tracker-ship" name="shipping" value="{{ $row['shipping_input'] ?: '' }}" placeholder="0.00">
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">Delivery</label>
                                            <input type="text" class="form-control form-control-sm tc-tracker-field tc-tracker-delivery" name="delivery" value="{{ $row['delivery_input'] ?: '' }}" placeholder="0.00">
                                        </div>
                                        <div class="col-6 col-md-4 col-lg-3">
                                            <label class="tc-tracker-field-label">CC charge</label>
                                            <div class="tc-tracker-field-value">${{ number_format((float) $row['credit_card_charges'], 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">No tracker rows yet. Place orders or add stock checks / quotes.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        @if ($trackerRows->total() > 0)
            <div class="card-footer py-2">{{ $trackerRows->withQueryString()->links() }}</div>
        @endif
    </div>
</div>
