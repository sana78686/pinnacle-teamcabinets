<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CatalogSalesAnalyticsService
{
    public function __construct(
        protected OrderWorkspaceCheckoutService $checkout,
    ) {}

    /**
     * CI dashboard2: sales totals grouped by catalog for total / quarter / month / week.
     *
     * @return array<string, array<string, float>>
     */
    public function catalogSalesByPeriod(): array
    {
        $now = Carbon::now();

        $ranges = [
            'total' => [null, null],
            'quarter' => [$now->copy()->startOfQuarter(), $now],
            'month' => [$now->copy()->startOfMonth(), $now],
            'week' => [$now->copy()->startOfWeek(), $now],
        ];

        $result = [];

        foreach ($ranges as $label => [$from, $to]) {
            $query = Order::query()->where('state', 1);
            if ($from !== null && $to !== null) {
                $query->whereBetween('created_at', [$from, $to]);
            }

            $result[$label] = $this->aggregateCatalogTotals($query->get(['id', 'rooms']));
        }

        return $result;
    }

    /**
     * @return array<string, float>
     */
    protected function aggregateCatalogTotals(Collection $orders): array
    {
        $totals = [];

        foreach ($orders as $order) {
            $rooms = $order->rooms;
            if (! is_array($rooms) || $rooms === []) {
                continue;
            }

            foreach ($this->salesLinesFromRooms($rooms) as $line) {
                $catalog = $line['catalog'] !== '' ? $line['catalog'] : 'Unknown';
                $totals[$catalog] = ($totals[$catalog] ?? 0.0) + $line['amount'];
            }
        }

        arsort($totals);

        return $totals;
    }

    /**
     * @param  array<mixed>  $rooms
     * @return list<array{catalog: string, amount: float}>
     */
    protected function salesLinesFromRooms(array $rooms): array
    {
        if ($this->isCiRoomMap($rooms)) {
            return $this->linesFromCiRoomMap($rooms);
        }

        $lines = [];
        $normalized = $this->checkout->normalizeRoomsFromStorage($rooms);

        foreach ($normalized as $room) {
            foreach ($room['products'] ?? [] as $product) {
                if (! is_array($product)) {
                    continue;
                }

                $qty = max(1, (int) ($product['quantity'] ?? 1));
                $lineTotal = (float) ($product['line_total'] ?? 0);
                if ($lineTotal <= 0) {
                    $unit = (float) ($product['cost1'] ?? $product['cost'] ?? 0);
                    $lineTotal = $unit * $qty;
                }

                $lines[] = [
                    'catalog' => (string) ($product['catalog_name'] ?? $product['sel_catalogue_name'] ?? 'Unknown'),
                    'amount' => round($lineTotal, 2),
                ];
            }
        }

        return $lines;
    }

    /**
     * @param  array<string, array<string, mixed>>  $rooms
     * @return list<array{catalog: string, amount: float}>
     */
    protected function linesFromCiRoomMap(array $rooms): array
    {
        $lines = [];

        foreach ($rooms as $roomData) {
            if (! is_array($roomData)) {
                continue;
            }

            $skus = $roomData['product_sku'] ?? [];
            if (! is_array($skus) || $skus === []) {
                continue;
            }

            $catalogs = $roomData['sel_catalogue_name'] ?? [];
            $count = count($skus);

            for ($i = 0; $i < $count; $i++) {
                $qty = max(1, (int) ($roomData['product_quantity'][$i] ?? 1));
                $lineTotal = (float) preg_replace(
                    '/[^\d.]/',
                    '',
                    (string) ($roomData['product_tot_price'][$i] ?? '')
                );

                if ($lineTotal <= 0) {
                    $actual = (float) ($roomData['product_actual_price'][$i] ?? $roomData['product_cost'][$i] ?? 0);
                    $lineTotal = $actual * $qty;
                }

                $catalog = 'Unknown';
                if (is_array($catalogs) && isset($catalogs[$i])) {
                    $catalog = trim((string) $catalogs[$i]);
                }

                $lines[] = [
                    'catalog' => $catalog !== '' ? $catalog : 'Unknown',
                    'amount' => round($lineTotal, 2),
                ];
            }
        }

        return $lines;
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
