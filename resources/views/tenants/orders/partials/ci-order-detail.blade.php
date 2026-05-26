@php
    $printMode = $printMode ?? false;
    $backUrl = $backUrl ?? route('tenant_order_list');
    $colSpan = ($showAssembleColumn ?? false) ? 9 : 8;
    $extraCol = ($showAssembleColumn ?? false) ? 1 : 0;
    $groupedRooms = [];
    foreach ($roomRows ?? [] as $row) {
        $groupedRooms[$row['room_name']][] = $row;
    }
@endphp

<div class="ci-order-detail {{ $printMode ? 'ci-order-detail--print' : '' }}">
    @if (! $printMode)
        <h2 class="ci-order-detail__title">View Order Details</h2>
        <div class="ci-order-detail__back">
            <a href="{{ $backUrl }}" class="btn btn-info btn-sm text-white">
                <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
            </a>
            <a href="{{ route('tenant_order_workspace_print_page', $orderId) }}" class="btn btn-light btn-sm" target="_blank" rel="noopener">
                <i class="fa fa-print" aria-hidden="true"></i> Print
            </a>
        </div>
    @endif

    <div class="table-responsive">
        <div class="ci-order-detail__border">
            <div class="row g-0">
                <div class="col-md-6 ci-order-detail__bill">
                    <div class="ci-order-detail__box-title"><b>Bill To :</b></div>
                    <div class="ci-order-detail__line">Name : {{ $bill['name'] ?? '—' }}</div>
                    <div class="ci-order-detail__line">Address : {{ $bill['address'] ?? '—' }}</div>
                    <div class="ci-order-detail__line">Email : {{ $bill['email'] ?? '—' }}</div>
                    <div class="ci-order-detail__line">Phone : {{ $bill['phone'] ?? '—' }}</div>
                </div>
                <div class="col-md-6 ci-order-detail__ship">
                    <div class="row g-0">
                        <div class="col-9">
                            <div class="ci-order-detail__box-title"><b>Ship To :</b></div>
                            <div class="ci-order-detail__line">Name : {{ $ship['name'] ?? '—' }}</div>
                            <div class="ci-order-detail__line">Address : {{ $ship['address'] ?? '—' }}</div>
                            <div class="ci-order-detail__line">Email : {{ $ship['email'] ?? '—' }}</div>
                            <div class="ci-order-detail__line">Phone : {{ $ship['phone'] ?? '—' }}</div>
                        </div>
                        <div class="col-3">
                            <div class="ci-order-detail__box-title"><b>Order #:</b> {{ $orderId }}</div>
                            @if (! empty($sourceBadge))
                                <div class="ci-order-detail__box-title">
                                    <b>{{ $sourceBadge['label'] }}</b> {{ $sourceBadge['id'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="ci-order-detail__meta">
                <div><b>Company Name</b> : {{ $companyName ?? 'N/A' }}</div>
                <div><b>Job Name</b> : {{ $jobName ?? '—' }}</div>
            </div>

            <div class="ci-order-detail__table-wrap">
                <table class="table table-bordered custom_cart_cls ci-order-detail__table mb-0">
                    <thead>
                        <tr>
                            <th>Double Check Work</th>
                            <th>Cabinet Section</th>
                            <th>Cabinet Name</th>
                            <th>Cabinet Description</th>
                            <th>Weight</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                            <th>Quantity</th>
                            @if ($showAssembleColumn)
                                <th>Assemble Cost</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($groupedRooms as $roomName => $lines)
                            <tr>
                                <th colspan="{{ $colSpan }}">{{ $roomName }}</th>
                            </tr>
                            @foreach ($lines as $line)
                                <tr>
                                    <td class="ci-order-detail__checks">
                                        <label class="container_chk_lbl">
                                            <input type="checkbox" @checked($line['checkbox1']) disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="container_chk_lbl_01">
                                            <input type="checkbox" @checked($line['checkbox2']) disabled>
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td>{{ $line['section'] }}</td>
                                    <td>{{ $line['sku'] }}</td>
                                    <td>{{ $line['description'] }}</td>
                                    <td>{{ $line['weight'] }}</td>
                                    <td>${{ number_format($line['unit_price'], 2) }}</td>
                                    <td>${{ number_format($line['line_total'], 2) }}</td>
                                    <td>{{ $line['quantity'] }}</td>
                                    @if ($showAssembleColumn)
                                        <td>
                                            @if ($line['assemble_cost'] > 0)
                                                ${{ number_format($line['assemble_cost'], 2) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="{{ $colSpan }}" class="text-center text-muted">No line items</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3">Sub Total</th>
                            <td></td>
                            <td>{{ $cartWeight }}</td>
                            <td></td>
                            <td>${{ number_format($subTotal, 2) }}</td>
                            <td></td>
                            @if ($showAssembleColumn)
                                <td>${{ number_format($assemblyCharges, 2) }}</td>
                            @endif
                        </tr>
                        <tr>
                            <th colspan="3">Fuel Charges ({{ $fuelPercent }}%)</th>
                            <td></td>
                            <td>-</td>
                            <td></td>
                            <td>
                                @if ($fuelCharges > 0)
                                    ${{ number_format($fuelCharges, 2) }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td></td>
                            @if ($showAssembleColumn)
                                <td></td>
                            @endif
                        </tr>
                        @if ($assemblyCharges > 0)
                            <tr>
                                <th colspan="3">Cabinetry Assembly Cost</th>
                                <td></td>
                                <td>-</td>
                                <td></td>
                                <td>${{ number_format($assemblyCharges, 2) }}</td>
                                <td></td>
                                @if ($showAssembleColumn)
                                    <td></td>
                                @endif
                            </tr>
                        @endif
                        <tr>
                            <th colspan="3">Sales Tax ({{ $salesTaxPercent }}%)</th>
                            <td></td>
                            <td>-</td>
                            <td></td>
                            <td>${{ number_format($salesTax, 2) }}</td>
                            <td></td>
                            @if ($showAssembleColumn)
                                <td></td>
                            @endif
                        </tr>
                        @foreach ($shippingLines as $shipLine)
                            <tr>
                                <th colspan="3">{{ $shipLine['label'] }}</th>
                                <td></td>
                                <td>-</td>
                                <td></td>
                                <td>
                                    @if (isset($shipLine['display']))
                                        {!! $shipLine['display'] === 'TBD' ? '<b>TBD</b>' : e($shipLine['display']) !!}
                                    @elseif (($shipLine['amount'] ?? 0) > 0)
                                        ${{ number_format($shipLine['amount'], 2) }}
                                    @else
                                        —
                                    @endif
                                </td>
                                <td></td>
                                @if ($showAssembleColumn)
                                    <td></td>
                                @endif
                            </tr>
                        @endforeach
                        @if ($paymentMethod === 'Credit Card' && $creditCardCharges > 0)
                            <tr>
                                <th colspan="3">Credit Card Charges({{ $creditCardPercent }}%)</th>
                                <td></td>
                                <td>-</td>
                                <td></td>
                                <td>${{ number_format($creditCardCharges, 2) }}</td>
                                <td></td>
                                @if ($showAssembleColumn)
                                    <td></td>
                                @endif
                            </tr>
                        @endif
                        @if ($paymentMethod === 'ACH' && $achCharges > 0)
                            <tr>
                                <th colspan="3">ACH Charges</th>
                                <td></td>
                                <td>-</td>
                                <td></td>
                                <td>${{ number_format($achCharges, 2) }}</td>
                                <td></td>
                                @if ($showAssembleColumn)
                                    <td></td>
                                @endif
                            </tr>
                        @endif
                        @if ($paymentMethod === 'Debit Card' && $debitCardCharges > 0)
                            <tr>
                                <th colspan="3">Debit Card Charges</th>
                                <td></td>
                                <td>-</td>
                                <td></td>
                                <td>${{ number_format($debitCardCharges, 2) }}</td>
                                <td></td>
                                @if ($showAssembleColumn)
                                    <td></td>
                                @endif
                            </tr>
                        @endif
                        <tr>
                            <th colspan="3">Grand Total</th>
                            <td></td>
                            <td>{{ $cartWeight }}</td>
                            <td></td>
                            <td>${{ number_format($grandTotal, 2) }}</td>
                            <td></td>
                            @if ($showAssembleColumn)
                                <td></td>
                            @endif
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="ci-order-detail__footer-line"><b>Comment</b> : {{ $comment !== '' ? $comment : '' }}</div>
            <div class="ci-order-detail__footer-line"><b>Payment Method</b> : {{ $paymentMethod }}</div>
        </div>
    </div>

    @if ($printMode)
        <div class="ci-order-detail__print-actions d-print-none mt-3">
            <button type="button" class="btn btn-primary btn-sm" onclick="window.print()">Print</button>
            <button type="button" class="btn btn-light btn-sm" onclick="window.close()">Close</button>
        </div>
    @endif
</div>
