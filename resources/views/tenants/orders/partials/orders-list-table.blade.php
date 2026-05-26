@php
    use App\Services\OrderAdminListService;

    $listService = app(OrderAdminListService::class);
    $sourceBadges = $sourceBadges ?? [];
    $isAdmin = auth()->user()?->isAdmin() ?? false;
@endphp

<div class="pt-0 card-body">
    <div class="table-responsive table-sm tc-admin-datatable">
        <table class="table p-0 m-0 display table-striped table-bordered table-sm tc-orders-list-table mb-0">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Customer Type</th>
                    <th scope="col">Customer Email</th>
                    <th scope="col">Job Name</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Order Weight</th>
                    <th scope="col">Order Amount</th>
                    <th scope="col">Order Status</th>
                    <th scope="col">Transaction ID</th>
                    <th scope="col">Order Date</th>
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($records as $order)
                    @php($badge = $sourceBadges[$order->id] ?? null)
                    <tr class="{{ tenant_admin_unviewed_row_class($order) }}">
                        <td>
                            {{ $order->id }}
                            @if ($badge)
                                <br><small class="text-muted">{{ $badge['label'] }}: {{ $badge['id'] }}</small>
                            @endif
                        </td>
                        <td>{{ $listService->customerName($order) }}</td>
                        <td>{{ $listService->customerType($order) }}</td>
                        <td>{{ $listService->customerEmail($order) }}</td>
                        <td>{{ $listService->jobName($order) }}</td>
                        <td>{{ $listService->companyName($order) }}</td>
                        <td>{{ $listService->formatWeight($order) }}</td>
                        <td>{{ $listService->formatAmount($order) }}</td>
                        <td class="tc-orders-list-table__status">
                            @if ($isAdmin)
                                <select class="form-select form-select-sm tc-order-status-select {{ $listService->statusSelectClass((string) ($order->status ?? 'PENDING')) }}"
                                    data-order-status-select data-order-id="{{ $order->id }}"
                                    aria-label="Order status for order {{ $order->id }}">
                                    @foreach (OrderAdminListService::ORDER_STATUSES as $statusOption)
                                        <option value="{{ $statusOption }}_{{ $order->id }}"
                                            @selected(strtoupper((string) ($order->status ?? 'PENDING')) === $statusOption)>
                                            {{ $statusOption }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                {{ strtoupper((string) ($order->status ?? 'PENDING')) }}
                            @endif
                        </td>
                        <td>{{ $order->transaction_pro_id ?: '—' }}</td>
                        <td>{{ $listService->formatCiDate($order->created_at) }}</td>
                        <td class="text-nowrap tc-admin-datatable__actions">
                            <a href="{{ route('tenant_order_show', $order->id) }}">View</a> ||
                            <a href="{{ route('tenant_order_warehouse_pick', $order->id) }}">Pick List</a> ||
                            @if ($isAdmin)
                                <a href="{{ route('tenant_order_send_quickbooks', $order->id) }}">Send-QB</a> ||
                            @endif
                            <a href="{{ route('tenant_order_workspace_print_page', $order->id) }}" target="_blank"
                                rel="noopener">Print</a> ||
                            <form action="{{ route('tenant_order_destroy', $order->id) }}" method="POST"
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this order record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link btn-sm p-0 align-baseline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    @include('partials.tc-admin-datatable-empty', [
                        'colspan' => 12,
                        'icon' => 'icofont-file-document',
                        'message' => 'No orders found.',
                    ])
                @endforelse
            </tbody>
        </table>
    </div>

    @include('partials.tenant-pagination', ['paginator' => $records])
</div>
