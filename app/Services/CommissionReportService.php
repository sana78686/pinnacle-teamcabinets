<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Collection;

class CommissionReportService
{
    public function __construct(
        protected OrderWorkspaceCheckoutService $checkout,
    ) {}

    /**
     * Build grouped commission report rows (CI commission_report_formatted_data shape).
     *
     * @param  array{rep_id?: int|string, parent_id?: int|string, from?: string, to?: string, state?: int}  $filters
     * @return array<int, array<string, mixed>>
     */
    public function formattedData(array $filters = []): array
    {
        $query = Order::query()
            ->with('user')
            ->where('state', $filters['state'] ?? 1);

        if (! empty($filters['rep_id'])) {
            $query->where('rep_id', $filters['rep_id']);
        }
        if (! empty($filters['parent_id'])) {
            $query->where('parent_id', $filters['parent_id']);
        }
        if (! empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }
        if (! empty($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        $orders = $query->orderByDesc('id')->get();
        $result = [];

        foreach ($orders as $order) {
            $doorLines = $this->doorLinesForOrder($order);
            if ($doorLines === []) {
                continue;
            }

            $customer = $order->user;
            $result[] = [
                'order_id' => $order->id,
                'invoice_number' => (string) $order->id,
                'job_name' => $order->job_name,
                'invoice_date' => $order->created_at?->format('Y-m-d') ?? '',
                'customer_name' => $customer?->name,
                'order_by' => $customer?->name,
                'rep_id' => $order->rep_id,
                'parent_id' => $order->parent_id,
                'door_lines' => $doorLines,
            ];
        }

        return $result;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function doorLinesForOrder(Order $order): array
    {
        $rooms = $order->rooms;
        if (! is_array($rooms) || $rooms === []) {
            return [];
        }

        $products = $this->flattenCiRoomProducts($rooms);
        if ($products === []) {
            return [];
        }

        $byDoorStyle = [];
        foreach ($products as $product) {
            $doorStyle = (string) ($product['product_cabinets_color'] ?? 'N/A');
            if ($doorStyle === '') {
                $doorStyle = 'N/A';
            }

            if (! isset($byDoorStyle[$doorStyle])) {
                $byDoorStyle[$doorStyle] = [
                    'door_style' => $doorStyle,
                    'quantity' => 0,
                    'list_price' => 0.0,
                    'user_door_price' => 0.0,
                    'parent_door_price' => 0.0,
                    'rep_door_price' => 0.0,
                    'user_door_factor' => (float) ($product['user_door_factor'] ?? 0),
                    'parent_door_factor' => (float) ($product['parent_door_factor'] ?? 0),
                    'rep_door_factor' => (float) ($product['representative_door_factor'] ?? 0),
                ];
            }

            $qty = max(1, (int) ($product['product_quantity'] ?? 1));
            $actual = (float) ($product['product_actual_price'] ?? 0);
            $userFactor = (float) ($product['user_door_factor'] ?? 0);
            $parentUnit = (float) ($product['parent_door_price'] ?? 0);
            $repUnit = (float) ($product['representative_door_price'] ?? 0);

            $byDoorStyle[$doorStyle]['quantity'] += $qty;
            $byDoorStyle[$doorStyle]['list_price'] += $actual * $qty;
            $byDoorStyle[$doorStyle]['user_door_price'] += $actual * $qty * $userFactor;
            $byDoorStyle[$doorStyle]['parent_door_price'] += $parentUnit * $qty;
            $byDoorStyle[$doorStyle]['rep_door_price'] += $repUnit * $qty;
        }

        foreach ($byDoorStyle as &$line) {
            $line['aff_commission'] = $line['user_door_price'] - $line['parent_door_price'];
            $line['rep_commission'] = $line['parent_door_price'] - $line['rep_door_price'];
        }
        unset($line);

        return array_values($byDoorStyle);
    }

    /**
     * Transpose CI room JSON (parallel arrays) into flat product rows.
     *
     * @param  array<mixed>  $rooms
     * @return array<int, array<string, mixed>>
     */
    protected function flattenCiRoomProducts(array $rooms): array
    {
        if ($this->isCiRoomMap($rooms)) {
            return $this->flattenCiRoomMap($rooms);
        }

        $modern = $this->checkout->normalizeRoomsFromStorage($rooms);
        $products = [];
        foreach ($modern as $room) {
            foreach ($room['products'] ?? [] as $line) {
                $qty = max(1, (int) ($line['quantity'] ?? 1));
                $actual = (float) ($line['cost1'] ?? $line['cost'] ?? 0);
                $products[] = [
                    'product_cabinets_color' => $line['product_color'] ?? '',
                    'product_quantity' => $qty,
                    'product_actual_price' => $actual,
                    'user_door_factor' => $line['user_door_factor'] ?? 0,
                    'parent_door_factor' => $line['parent_door_factor'] ?? 0,
                    'representative_door_factor' => $line['representative_door_factor'] ?? 0,
                    'parent_door_price' => $line['parent_door_price'] ?? 0,
                    'representative_door_price' => $line['representative_door_price'] ?? 0,
                ];
            }
        }

        return $products;
    }

    /**
     * @param  array<string, array<string, mixed>>  $rooms
     * @return array<int, array<string, mixed>>
     */
    protected function flattenCiRoomMap(array $rooms): array
    {
        $products = [];

        foreach ($rooms as $roomData) {
            if (! is_array($roomData)) {
                continue;
            }

            $skus = $roomData['product_sku'] ?? [];
            if (! is_array($skus) || $skus === []) {
                continue;
            }

            $count = count($skus);
            for ($i = 0; $i < $count; $i++) {
                $products[] = [
                    'product_cabinets_color' => (string) ($roomData['product_cabinets_color'][$i] ?? ''),
                    'product_quantity' => max(1, (int) ($roomData['product_quantity'][$i] ?? 1)),
                    'product_actual_price' => (float) ($roomData['product_actual_price'][$i] ?? 0),
                    'user_door_factor' => $roomData['user_door_factor'][$i] ?? 0,
                    'parent_door_factor' => $roomData['parent_door_factor'][$i] ?? 0,
                    'representative_door_factor' => $roomData['representative_door_factor'][$i] ?? 0,
                    'parent_door_price' => (float) ($roomData['parent_door_price'][$i] ?? 0),
                    'representative_door_price' => (float) ($roomData['representative_door_price'][$i] ?? 0),
                ];
            }
        }

        return $products;
    }

    /**
     * @param  array<mixed>  $rooms
     */
    protected function isCiRoomMap(array $rooms): bool
    {
        if (array_is_list($rooms)) {
            return false;
        }

        foreach ($rooms as $val) {
            if (is_array($val) && isset($val['product_sku']) && is_array($val['product_sku'])) {
                return true;
            }
        }

        return false;
    }
}
