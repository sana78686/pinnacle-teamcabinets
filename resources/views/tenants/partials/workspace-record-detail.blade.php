@php
    $record = $record ?? null;
    $rooms = $rooms ?? [];
    $recordLabel = $recordLabel ?? 'Record';
    $recordName = $recordName ?? ($quoteName ?? null);
    $catalogLabel = $catalogLabel ?? '—';
    $doorLabel = $doorLabel ?? '—';
    $billName = $billName ?? ($record->user?->name ?? $record->user_email ?? '—');
    $shipName = $shipName ?? $billName;
    $listRoute = $listRoute ?? null;
    $editRoute = $editRoute ?? null;
    $nameRowLabel = $nameRowLabel ?? ($recordLabel.' name');
@endphp

<div class="container-fluid tc-workspace-detail">
    <div class="tc-workspace-detail__actions mb-3">
        @if ($listRoute)
            <a href="{{ route($listRoute) }}" class="btn btn-light btn-sm"><i class="fa fa-arrow-left"></i> Back to list</a>
        @endif
        @if ($editRoute && $record)
            <a href="{{ route($editRoute, $record->id) }}" class="btn btn-primary btn-sm">Edit in order workspace</a>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-6 mb-3">
            <table class="table table-bordered table-sm mb-0 tc-workspace-detail__table">
                <thead class="table-secondary">
                    <tr><th colspan="2">{{ $recordLabel }} information</th></tr>
                </thead>
                <tbody>
                    <tr><th>{{ $nameRowLabel }}</th><td>{{ $recordName ?? '—' }}</td></tr>
                    <tr><th>Bill name</th><td>{{ $billName }}</td></tr>
                    <tr><th>Ship name</th><td>{{ $shipName }}</td></tr>
                    <tr><th>Job name</th><td>{{ $record->job_name ?? '—' }}</td></tr>
                    <tr><th>Date</th><td>{{ $record->created_at?->format('M j, Y g:i A') ?? '—' }}</td></tr>
                    <tr><th>Assemble</th><td>{{ ucfirst($record->assemble_cabinets_check ?? '—') }}</td></tr>
                    <tr><th>Shipping</th><td>{{ ucfirst($record->shipping_status ?? '—') }}</td></tr>
                    <tr><th>Total</th><td>${{ number_format((float) ($record->grand_total_cost ?? 0), 2) }}</td></tr>
                    <tr><th>Weight</th><td>{{ $record->sub_total_weight ?? '0' }} lbs</td></tr>
                    @if (! empty($record->shipping_cost) && (float) $record->shipping_cost > 0)
                        <tr><th>Shipping cost</th><td>${{ number_format((float) $record->shipping_cost, 2) }}</td></tr>
                    @endif
                </tbody>
            </table>
        </div>

        <div class="col-lg-4 col-md-6 mb-3">
            <table class="table table-bordered table-sm mb-0 tc-workspace-detail__table">
                <thead class="table-secondary">
                    <tr><th colspan="2">Product catalog information</th></tr>
                </thead>
                <tbody>
                    <tr><th>Catalog</th><td>{{ $catalogLabel }}</td></tr>
                    <tr><th>Door style</th><td>{{ $doorLabel }}</td></tr>
                    <tr><th>Customer</th><td>{{ $record->user?->name ?? $record->user_email ?? '—' }}</td></tr>
                    <tr><th>Email</th><td>{{ $record->user_email ?? $record->user?->email ?? '—' }}</td></tr>
                    <tr><th>Phone</th><td>{{ $record->user_phone ?? $record->user?->phone ?? '—' }}</td></tr>
                    <tr><th>Address</th><td>{{ $record->user_address ?? '—' }}</td></tr>
                </tbody>
            </table>
        </div>

        @if (! empty($record->comment))
            <div class="col-lg-4 col-md-12 mb-3">
                <div class="tc-workspace-detail__comment border rounded p-3 bg-light h-100">
                    <strong>Comment</strong>
                    <p class="mb-0 mt-2">{{ $record->comment }}</p>
                </div>
            </div>
        @endif
    </div>

    <div class="table-responsive tc-admin-datatable">
        <table class="table table-bordered table-sm mb-0">
            <thead class="table-secondary">
                <tr>
                    <th>Room</th>
                    <th>SKU</th>
                    <th>Description</th>
                    <th class="text-end">Qty</th>
                    <th class="text-end">Unit</th>
                    <th class="text-end">Line total</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rooms as $room)
                    @foreach ($room['products'] ?? [] as $line)
                        <tr>
                            <td>{{ $room['room_name'] ?? '—' }}</td>
                            <td>{{ $line['sku'] ?? '—' }}</td>
                            <td>{{ $line['label'] ?? $line['description'] ?? '—' }}</td>
                            <td class="text-end">{{ $line['quantity'] ?? 1 }}</td>
                            <td class="text-end">${{ number_format((float) ($line['cost'] ?? 0), 2) }}</td>
                            <td class="text-end">${{ number_format((float) ($line['cost'] ?? 0) * (int) ($line['quantity'] ?? 1), 2) }}</td>
                        </tr>
                    @endforeach
                @empty
                    <tr><td colspan="6" class="text-center text-muted">No line items.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
