<?php

namespace App\Services;

use App\Models\Order;
use App\Services\AdminRecordViewService;
use App\Models\OrderEnhancedDetail;
use App\Models\Quote;
use App\Models\StockCheckRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class TenantOrderTrackerService
{
    public function fuelChargePercent(): float
    {
        return (float) (tax_value('fuel_charges_value', 0) ?? 0);
    }

    /** @return array<int, string> */
    public function stockCheckStatuses(): array
    {
        return config('order_tracker.stock_check_statuses', []);
    }

    /** @return Collection<int, array<string, mixed>> */
    public function trackerRows(): Collection
    {
        if (! Schema::hasTable('order_enhanced_details')) {
            return collect();
        }

        $rows = collect();
        $rows = $rows->merge($this->rowsFromOrders());
        $rows = $rows->merge($this->rowsFromQuotes());
        $rows = $rows->merge($this->rowsFromStockChecks());

        return $rows->sortByDesc('created_at')->values();
    }

    public function updateRow(array $payload): void
    {
        if (! Schema::hasTable('order_enhanced_details')) {
            return;
        }

        $orderId = (int) ($payload['order_id'] ?? 0);
        $scId = (int) ($payload['sc_id'] ?? 0);
        $mqId = (int) ($payload['mq_id'] ?? 0);

        $detail = $this->findDetail($orderId, $scId, $mqId);

        $allowed = [
            'stock_check_status', 'vendor_sc_q', 'vendor', 'customer_paid', 'team_paid',
            'vendor_sale_order', 'vendor_amount', 'miscellaneous', 'shipping', 'delivery',
            'tax', 'fuel_charges', 'sub_total',
        ];

        $data = [];
        foreach ($allowed as $key) {
            if (array_key_exists($key, $payload)) {
                $data[$key] = $payload[$key];
            }
        }

        if ($detail) {
            $detail->update($data);

            return;
        }

        OrderEnhancedDetail::query()->create(array_merge([
            'tenant_id' => tenant('id'),
            'order_id' => $orderId,
            'sc_id' => $scId,
            'mq_id' => $mqId,
            'state' => 1,
        ], $data));
    }

    /** @return array{margin: float, color: string} */
    public function calculateMargin(array $row): array
    {
        $subTotal = (float) ($row['sub_total'] ?? 0);
        $tax = is_numeric($row['tax_display'] ?? null) ? (float) $row['tax_display'] : 0;
        $shipping = (float) ($row['shipping_input'] ?? 0);
        $assembly = (float) ($row['assemble_cabinetry_charged'] ?? 0);
        $cc = (float) ($row['credit_card_charges'] ?? 0);
        $fuel = (float) ($row['fuel_charges_display'] ?? 0);
        $misc = (float) ($row['miscellaneous_input'] ?? 0);
        $delivery = (float) ($row['delivery_input'] ?? 0);

        $margin = $subTotal - ($tax + $shipping + $cc + $fuel + $assembly + $misc + $delivery);
        $pct = $subTotal != 0.0 ? ($margin / $subTotal) * 100 : 0;

        return [
            'margin' => $margin,
            'color' => $pct >= 20 ? 'green' : 'red',
        ];
    }

    protected function findDetail(int $orderId, int $scId, int $mqId): ?OrderEnhancedDetail
    {
        $q = OrderEnhancedDetail::query()->where('state', 1);

        if ($orderId > 0) {
            return $q->where('order_id', $orderId)->first();
        }
        if ($scId > 0) {
            return $q->where('sc_id', $scId)->first();
        }
        if ($mqId > 0) {
            return $q->where('mq_id', $mqId)->first();
        }

        return null;
    }

    /** @return Collection<int, array<string, mixed>> */
    protected function rowsFromOrders(): Collection
    {
        $orders = Order::query()
            ->with('user.roles')
            ->latest('id')
            ->limit(500)
            ->get();

        $details = OrderEnhancedDetail::query()
            ->whereIn('order_id', $orders->pluck('id'))
            ->where('state', 1)
            ->get()
            ->keyBy('order_id');

        return $orders->map(fn (Order $order) => $this->mapOrderRow($order, $details->get($order->id)));
    }

    /** @return Collection<int, array<string, mixed>> */
    protected function rowsFromQuotes(): Collection
    {
        return Quote::query()
            ->with('user.roles')
            ->latest('id')
            ->limit(100)
            ->get()
            ->map(function (Quote $quote) {
                $detail = OrderEnhancedDetail::query()
                    ->where('mq_id', $quote->id)
                    ->where('state', 1)
                    ->first();

                return $this->mapWorkspaceRow(
                    source: 'quote',
                    orderNumber: 'N/A',
                    scId: 0,
                    mqId: $quote->id,
                    jobName: $quote->job_name,
                    customer: $quote->user?->name ?? $quote->user_email ?? '—',
                    createdAt: $quote->created_at,
                    detail: $detail,
                    order: null,
                    workspace: $quote,
                );
            });
    }

    /** @return Collection<int, array<string, mixed>> */
    protected function rowsFromStockChecks(): Collection
    {
        return StockCheckRequest::query()
            ->with('user.roles')
            ->latest('id')
            ->limit(100)
            ->get()
            ->map(function (StockCheckRequest $stock) {
                $detail = OrderEnhancedDetail::query()
                    ->where('sc_id', $stock->id)
                    ->where('state', 1)
                    ->first();

                return $this->mapWorkspaceRow(
                    source: 'stock_check',
                    orderNumber: 'N/A',
                    scId: $stock->id,
                    mqId: 0,
                    jobName: $stock->job_name,
                    customer: $stock->user?->name ?? $stock->user_email ?? '—',
                    createdAt: $stock->created_at,
                    detail: $detail,
                    order: null,
                    workspace: $stock,
                );
            });
    }

    protected function mapOrderRow(Order $order, ?OrderEnhancedDetail $detail): array
    {
        $scId = 0;
        if (Schema::hasTable('stock_check_requests') && Schema::hasColumn('stock_check_requests', 'order_id')) {
            $scId = (int) StockCheckRequest::query()->where('order_id', $order->id)->value('id');
        }

        return $this->mapWorkspaceRow(
            source: 'order',
            orderNumber: (string) $order->id,
            scId: $scId,
            mqId: 0,
            jobName: $order->job_name,
            customer: $order->user?->name ?? $order->user_email ?? '—',
            createdAt: $order->created_at,
            detail: $detail,
            order: $order,
            workspace: $order,
        );
    }

    /**
     * @param  Order|Quote|StockCheckRequest|null  $workspace
     * @return array<string, mixed>
     */
    protected function mapWorkspaceRow(
        string $source,
        string $orderNumber,
        int $scId,
        int $mqId,
        ?string $jobName,
        string $customer,
        $createdAt,
        ?OrderEnhancedDetail $detail,
        ?Order $order,
        $workspace,
    ): array {
        $subTotal = $this->resolveSubTotal($order, $workspace, $detail);
        $tax = $this->resolveTax($order, $workspace, $detail);
        $fuel = $detail?->fuel_charges ?? ($order?->fuel_charges ?? $workspace->fuel_charges ?? 0);
        $shipping = $detail?->shipping ?? ($order?->shipping_cost ?? $workspace->shipping_cost ?? '');
        $assemble = (float) ($order?->sub_total_assemble_cost ?? $workspace->sub_total_assemble_cost ?? 0);
        $cc = (float) ($order?->credit_card_charges ?? 0) + (float) ($order?->ach_charges ?? 0);
        $customerPaid = (float) ($order?->order_amount ?? $order?->grand_total_cost ?? $workspace->grand_total_cost ?? 0);
        $qb = $order?->quickbook_invoice_id ?? $order?->quickbooks_number ?? '';

        $displayRef = match ($source) {
            'order' => '#'.$orderNumber,
            'stock_check' => 'SC#'.$scId,
            'quote' => 'Quote #'.$mqId,
            default => $orderNumber,
        };

        $typeLabel = match ($source) {
            'order' => 'Order',
            'stock_check' => 'Stock check',
            'quote' => 'Quote',
            default => 'Record',
        };

        $row = [
            'source' => $source,
            'type_label' => $typeLabel,
            'display_ref' => $displayRef,
            'order_number' => $orderNumber,
            'order_id' => $order?->id ?? 0,
            'sc_id' => $scId ?: ($detail?->sc_id ?? 0),
            'mq_id' => $mqId ?: ($detail?->mq_id ?? 0),
            'stock_check_status' => (int) ($detail?->stock_check_status ?? 1),
            'created_at' => $createdAt?->format('M j, Y g:i A') ?? '—',
            'customer' => $customer,
            'job_name' => $jobName ?? '—',
            'quickbooks_number' => $qb ?: '—',
            'vendor_sc_q' => $detail?->vendor_sc_q ?? '',
            'vendor' => $detail?->vendor ?? '',
            'customer_paid' => $detail?->customer_paid ?? 'No',
            'team_paid' => $detail?->team_paid ?? 'No',
            'vendor_sale_order' => $detail?->vendor_sale_order ?? '',
            'vendor_amount' => $detail?->vendor_amount ?? '',
            'customer_paid_amount' => $customerPaid,
            'sub_total' => $subTotal,
            'tax_display' => $tax,
            'fuel_charges_display' => is_numeric($fuel) ? (float) $fuel : 0,
            'assemble_cabinetry_charged' => $assemble,
            'credit_card_charges' => $cc,
            'miscellaneous_input' => is_numeric($detail?->miscellaneous ?? null) ? (float) $detail->miscellaneous : 0,
            'shipping_input' => is_numeric($shipping) ? (float) $shipping : 0,
            'delivery_input' => is_numeric($detail?->delivery ?? null) ? (float) $detail->delivery : 0,
            'order_show_url' => $order ? route('tenant_order_show', $order->id) : null,
            'sc_show_url' => $scId > 0 ? route('tenant_stock_check_show', $scId) : null,
        ];

        $margin = $this->calculateMargin($row);
        $row['margin'] = $margin['margin'];
        $row['margin_color'] = $margin['color'];

        $row['is_unviewed'] = $workspace
            && app(AdminRecordViewService::class)->isUnviewed($workspace);

        $row['mark_viewed_type'] = match ($source) {
            'order' => 'order',
            'quote' => 'quote',
            'stock_check' => 'stock_check',
            default => null,
        };
        $row['mark_viewed_id'] = $workspace?->id ?? 0;

        return $row;
    }

    protected function resolveSubTotal(?Order $order, $workspace, ?OrderEnhancedDetail $detail): float
    {
        if ($detail?->sub_total !== null && $detail->sub_total !== '' && is_numeric($detail->sub_total)) {
            return (float) $detail->sub_total;
        }

        return (float) ($order?->sub_total_cost ?? $workspace->sub_total_cost ?? 0);
    }

    protected function resolveTax(?Order $order, $workspace, ?OrderEnhancedDetail $detail): float|string
    {
        if ($detail?->tax !== null && $detail->tax !== '' && is_numeric($detail->tax)) {
            return (float) $detail->tax;
        }

        $tax = $order?->tax ?? $workspace->tax ?? null;
        if ($tax === 'Exempted' || $tax === null || $tax === '') {
            return 0;
        }

        return is_numeric($tax) ? (float) $tax : 0;
    }
}
