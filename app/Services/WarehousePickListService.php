<?php

namespace App\Services;

use App\Models\Order;

class WarehousePickListService
{
    public function __construct(
        protected OrderWorkspaceCheckoutService $checkout,
    ) {}

    /**
     * Room-by-room lines for warehouse pick list (CI list_warehouse_pick.php).
     *
     * @return array<int, array{room_name: string, lines: array<int, array{sku: string, description: string, qty: int|string, color: string}>}>
     */
    public function roomsForOrder(Order $order): array
    {
        $rooms = $order->rooms;
        if (is_string($rooms)) {
            $rooms = json_decode($rooms, true);
        }
        if (! is_array($rooms) || $rooms === []) {
            return [];
        }

        if ($this->isCiRoomMap($rooms)) {
            return $this->fromCiRoomMap($rooms);
        }

        $normalized = $this->checkout->normalizeRoomsFromStorage($rooms);
        $result = [];
        foreach ($normalized as $room) {
            $lines = [];
            foreach ($room['products'] ?? [] as $line) {
                $lines[] = [
                    'sku' => (string) ($line['sku'] ?? ''),
                    'description' => (string) ($line['product_details'] ?? $line['label'] ?? ''),
                    'qty' => max(1, (int) ($line['quantity'] ?? 1)),
                    'color' => (string) ($line['product_color'] ?? ''),
                ];
            }
            if ($lines !== []) {
                $result[] = [
                    'room_name' => (string) ($room['room_name'] ?? 'Room'),
                    'lines' => $lines,
                ];
            }
        }

        return $result;
    }

    /**
     * @param  array<string, array<string, mixed>>  $rooms
     * @return array<int, array{room_name: string, lines: array<int, array<string, mixed>>}>
     */
    protected function fromCiRoomMap(array $rooms): array
    {
        $result = [];

        foreach ($rooms as $roomName => $roomData) {
            if (! is_array($roomData)) {
                continue;
            }

            $skus = $roomData['product_sku'] ?? [];
            if (! is_array($skus) || $skus === []) {
                continue;
            }

            $lines = [];
            $count = count($skus);
            for ($i = 0; $i < $count; $i++) {
                $desc = $roomData['product_cabinets_description'][$i]
                    ?? $roomData['product_details'][$i]
                    ?? $roomData['product_name'][$i]
                    ?? '';
                $lines[] = [
                    'sku' => (string) ($roomData['product_sku'][$i] ?? ''),
                    'description' => (string) $desc,
                    'qty' => max(1, (int) ($roomData['product_quantity'][$i] ?? 1)),
                    'color' => (string) ($roomData['product_cabinets_color'][$i] ?? ''),
                ];
            }

            $result[] = [
                'room_name' => (string) $roomName,
                'lines' => $lines,
            ];
        }

        return $result;
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
