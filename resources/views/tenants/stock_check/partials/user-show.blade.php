@php
    $record = $stock_check_request ?? $record;
    $hasAssemble = $assembleYes ?? false;
    $colSpan = $hasAssemble ? 9 : 8;
    $notesLocked = $notesLocked ?? ($isApproved ?? false);
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
@endphp

<div class="content-wrapper tc-stock-check-user" style="min-height: 348px;">
    <section class="content p-2 m-2" style="padding-top:30px;">
        @include('partial.message')
        <div id="sc-user-status-msg" class="alert py-2 mb-3" style="display:none;" role="status"></div>

        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" style="float:left;padding: 8px 0;">
                    <div class="col-md-4 custom_order_bill_form_cls">
                        <div class="box-header" style="padding-left:0 !important;">
                            <h3 class="box-title"><b>Bill To :</b></h3>
                        </div>
                        <div class="form-group">Name : {{ $bill_to_name ?? $billName ?? '—' }}</div>
                        <div class="form-group">Address : {{ $billAddress }}</div>
                        <div class="form-group">Email : {{ $bill_to_email ?? ($record->user_email ?? '—') }}</div>
                        <div class="form-group">Phone : {{ $bill_to_phone ?? ($record->user_phone ?? '—') }}</div>
                    </div>
                    <div class="col-md-4 custom_order_bill_form_cls">
                        <div class="box-header" style="padding-left:0 !important;">
                            <h3 class="box-title"><b>Ship To :</b></h3>
                        </div>
                        <div class="form-group">Name : {{ $ship_to_name ?? $billName ?? '—' }}</div>
                        <div class="form-group">Address : {{ $shipAddress }}</div>
                        <div class="form-group">Email : {{ $ship_to_email ?? ($record->user_email ?? '—') }}</div>
                        <div class="form-group">Phone : {{ $ship_to_phone ?? ($record->user_phone ?? '—') }}</div>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-lg-12" style="padding-left:0;padding-right:0;">
                    <div class="box box-primary custom_order_product_description_cls" style="float:left;padding:5px;margin-bottom:0;">
                        <div class="job_name_cls" style="padding:5px 10px 5px 0;">
                            <b>Job Name</b> : {{ $record->job_name ?? '—' }}
                        </div>

                        <form action="{{ $itemNotesRoute ?? '#' }}" id="sc-item-notes-form" method="post">
                            @csrf
                            <input type="hidden" name="stock_check_id" value="{{ $record->id }}">
                            <table class="table table-bordered custom_cart_cls mb-0">
                                <thead>
                                    <tr>
                                        <th>Double Check Work</th>
                                        <th>Cabinet Name</th>
                                        <th>Cabinet Description</th>
                                        <th>Weight</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                        <th>Quantity</th>
                                        @if ($hasAssemble)<th>Assemble Cost</th>@endif
                                        <th>Item Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $lastRoom = null; @endphp
                                    @forelse ($lines as $lineIndex => $line)
                                        @if ($lastRoom !== ($line['room_name'] ?? ''))
                                            @php $lastRoom = $line['room_name'] ?? ''; @endphp
                                            <tr><th colspan="{{ $colSpan }}">{{ $lastRoom }}</th></tr>
                                        @endif
                                        <tr>
                                            <td class="tc-sq-admin__checks">
                                                <span class="tc-sq-check tc-sq-check--yellow{{ ! empty($line['check_yellow']) ? ' is-on' : '' }}"></span>
                                                <span class="tc-sq-check tc-sq-check--green{{ ! empty($line['check_green']) ? ' is-on' : '' }}"></span>
                                            </td>
                                            <td>{{ $line['sku'] ?: $line['cabinet_name'] }}</td>
                                            <td>{{ $line['description'] }}</td>
                                            <td>{{ rtrim(rtrim(number_format($line['weight'], 2), '0'), '.') }} lbs</td>
                                            <td>${{ number_format($line['unit_price'], 2) }}</td>
                                            <td>${{ number_format($line['line_total'], 2) }}</td>
                                            <td>{{ $line['quantity'] }}</td>
                                            @if ($hasAssemble)
                                                <td>
                                                    @if (($line['assemble_cost'] ?? 0) > 0)
                                                        ${{ number_format($line['assemble_cost'], 2) }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                            @endif
                                            <td>
                                                <textarea style="width:100%; min-width:100%;" class="product_note"
                                                    name="line_notes[{{ $lineIndex }}]" rows="2"
                                                    @if ($notesLocked) disabled @endif>{{ $line['note'] ?? '' }}</textarea>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="{{ $colSpan }}" class="text-center text-muted">No line items found.</td></tr>
                                    @endforelse
                                </tbody>
                                <tfoot>
                                    @include('tenants.stock_check.partials.summary-footer', [
                                        'assembleYes' => $hasAssemble,
                                        'showShippingBreakdown' => $showUserShipping ?? false,
                                        'showSimpleShipping' => $showSimpleShipping ?? false,
                                        'totalLabel' => 'Total',
                                    ])
                                </tfoot>
                            </table>
                        </form>

                        @if (filled($record->comment))
                            <div class="order_name_cls" style="padding:5px 55px 5px 0;">
                                <b>Comment</b> :
                                <p class="order_comment_para_cls mb-0">{{ $record->comment }}</p>
                            </div>
                        @endif

                        <div class="clearfix mt-2">
                            @if ($isApproved ?? false)
                                <p class="text-success mb-2">This stock check request has been approved.</p>
                            @else
                                <button type="button" class="btn btn-primary approve_stock_check float-end m-1"
                                    id="sc-btn-update-notes">Update Item Notes</button>
                                <a href="{{ $editRoute ?? route('tenant_stock_check_edit', $record->id) }}"
                                    class="btn btn-primary approve_stock_check float-end m-1">Edit Stock Check</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .note_charges { color: red; font-size: 12px; }
    .tc-stock-check-user .tc-sq-admin__checks { white-space: nowrap; }
</style>
