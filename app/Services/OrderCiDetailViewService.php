<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\ProductSection;
use App\Models\TaxValues;
use Illuminate\Support\Str;

class OrderCiDetailViewService
{
    public function __construct(
        protected OrderWorkspaceService $workspace,
        protected OrderAdminListService $orderList,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function build(Order $order): array
    {
        $order->loadMissing(['user']);

        $bill = $this->partyFromOrder($order, 'bill_to');
        $ship = $this->partyFromOrder($order, 'ship_to');
        $rooms = $this->buildRoomRows($order);
        $subTotal = array_sum(array_map(fn (array $line) => (float) $line['line_total'], $rooms));
        $assemblyCharges = $this->assemblyCharges($order);
        $fuelCharges = (float) ($order->fuel_charges ?? 0);
        $fuelPercent = trim((string) ($order->fuel_charges_pertcentage ?? $order->fuel_tax ?? ''));
        $salesTaxPercent = trim((string) ($order->sales_tax ?? ''));
        $salesTax = (float) ($order->tax ?? 0);
        $cartWeight = $this->formatCartWeight($order);

        $grandTotal = (float) ($order->order_amount ?? $order->grand_total_cost ?? 0);
        if ($grandTotal <= 0) {
            $grandTotal = $subTotal
                + $salesTax
                + (float) ($order->shipping_cost ?? 0)
                + $assemblyCharges
                + (float) ($order->credit_card_charges ?? 0)
                + (float) ($order->ach_charges ?? 0)
                + (float) ($order->debit_card_charges ?? 0)
                + $fuelCharges;
        }

        $badges = $this->orderList->sourceBadgesForOrderIds([$order->id]);
        $sourceBadge = $badges[$order->id] ?? null;

        return [
            'order' => $order,
            'orderId' => $order->id,
            'sourceBadge' => $sourceBadge,
            'bill' => $bill,
            'ship' => $ship,
            'companyName' => filled($order->user?->company_name) ? $order->user->company_name : 'N/A',
            'jobName' => $this->jobName($order),
            'roomRows' => $rooms,
            'showAssembleColumn' => $assemblyCharges > 0 || ($order->assemble_cabinets_check ?? '') === 'yes',
            'subTotal' => $subTotal,
            'cartWeight' => $cartWeight,
            'fuelCharges' => $fuelCharges,
            'fuelPercent' => $fuelPercent !== '' ? $fuelPercent : '0',
            'assemblyCharges' => $assemblyCharges,
            'salesTaxPercent' => $salesTaxPercent !== '' ? $salesTaxPercent : '0',
            'salesTax' => $salesTax,
            'shippingLines' => $this->shippingLines($order),
            'creditCardCharges' => (float) ($order->credit_card_charges ?? 0),
            'creditCardPercent' => $this->creditCardPercent($order),
            'achCharges' => (float) ($order->ach_charges ?? 0),
            'debitCardCharges' => (float) ($order->debit_card_charges ?? 0),
            'paymentMethod' => $this->paymentMethod($order),
            'grandTotal' => $grandTotal,
            'comment' => $this->orderComment($order),
        ];
    }

    /**
     * @return array{name: string, address: string, email: string, phone: string}
     */
    protected function partyFromOrder(Order $order, string $prefix): array
    {
        $user = $order->user;
        $fallbackAddress = $user ? $this->workspace->formatUserAddress($user) : '—';

        return [
            'name' => $this->firstStoredValue($order, "{$prefix}_name")
                ?? $user?->name
                ?? $order->user_email
                ?? '—',
            'address' => $this->formattedPartyAddress($order, $prefix) ?? $fallbackAddress,
            'email' => $this->firstStoredValue($order, "{$prefix}_email")
                ?? $user?->email
                ?? $order->user_email
                ?? '—',
            'phone' => $this->firstStoredValue($order, "{$prefix}_phone")
                ?? $user?->phone
                ?? $order->user_phone
                ?? '—',
        ];
    }

    protected function formattedPartyAddress(Order $order, string $prefix): ?string
    {
        $street = $this->firstStoredValue($order, "{$prefix}_address");
        if ($street === null) {
            return null;
        }

        $parts = array_filter([
            $street,
            $this->firstStoredValue($order, "{$prefix}_city"),
            $this->firstStoredValue($order, "{$prefix}_county"),
            $this->firstStoredValue($order, "{$prefix}_state"),
            $this->firstStoredValue($order, "{$prefix}_zipcode"),
            $this->firstStoredValue($order, "{$prefix}_country"),
        ], fn (?string $part) => $part !== null && $part !== '');

        return $parts !== [] ? implode(', ', $parts) : null;
    }

    protected function firstStoredValue(Order $order, string $column): ?string
    {
        if (! isset($order->{$column})) {
            return null;
        }

        return $this->decodeCiStoredValue($order->{$column});
    }

    protected function decodeCiStoredValue(mixed $raw): ?string
    {
        if ($raw === null || $raw === '') {
            return null;
        }

        if (! is_string($raw)) {
            return trim((string) $raw) !== '' ? trim((string) $raw) : null;
        }

        $trim = trim($raw);
        if ($trim === '') {
            return null;
        }

        if ($trim[0] === '[' || $trim[0] === '{') {
            $decoded = json_decode($trim, true);
            if (is_array($decoded)) {
                if (array_is_list($decoded)) {
                    return isset($decoded[0]) ? trim((string) $decoded[0]) : null;
                }

                return isset($decoded['0'])
                    ? trim((string) $decoded['0'])
                    : (is_string(reset($decoded)) ? trim((string) reset($decoded)) : null);
            }
        }

        return $trim;
    }

    protected function orderComment(Order $order): string
    {
        foreach (['comment', 'order_comment'] as $column) {
            $value = $this->firstStoredValue($order, $column);
            if ($value !== null && $value !== '') {
                return $value;
            }
        }

        return '';
    }

    protected function jobName(Order $order): string
    {
        $job = $order->job_name;
        if (is_array($job)) {
            return implode(', ', $job);
        }

        return (string) ($job ?? '—');
    }

    protected function formatCartWeight(Order $order): string
    {
        $weight = $order->sub_total_weight ?? '0';
        if (is_array($weight)) {
            $weight = '0';
        }
        $weight = str_ireplace(['lbs', 'lbl', '"', '[', ']'], '', (string) $weight);
        $weight = trim($weight);

        return $weight !== '' ? $weight.' lbs' : '0 lbs';
    }

    protected function assemblyCharges(Order $order): float
    {
        if (isset($order->assemble_cabinetry_charged) && is_numeric($order->assemble_cabinetry_charged)) {
            return (float) $order->assemble_cabinetry_charged;
        }

        return (float) ($order->sub_total_assemble_cost ?? 0);
    }

    protected function paymentMethod(Order $order): string
    {
        $type = trim((string) ($order->order_payment_type ?? ''));

        return $type !== '' ? $type : '—';
    }

    protected function creditCardPercent(Order $order): string
    {
        if (isset($order->credit_card_charges_pertcentage) && $order->credit_card_charges_pertcentage !== '') {
            return (string) $order->credit_card_charges_pertcentage;
        }

        $row = TaxValues::query()->where('option_key', 'credit_card_charges')->first();

        return (string) ($row->option_value ?? '0');
    }

    /**
     * @return array<int, array{label: string, amount: float}>
     */
    protected function shippingLines(Order $order): array
    {
        $decoded = $this->decodeShippingChargesArr($order);
        $isShippingQuote = (int) ($order->is_shipping_quote ?? 0) === 1;

        if ($decoded !== []) {
            $lines = [];
            if ($isShippingQuote) {
                $lines[] = ['label' => 'Shipping Charges', 'amount' => 0, 'display' => ''];
            }
            foreach ($decoded as $label => $amount) {
                if ((float) $amount > 0) {
                    $lines[] = ['label' => (string) $label, 'amount' => (float) $amount];
                }
            }
            if ($lines !== []) {
                return $lines;
            }
        }

        $breakdown = $this->shippingBreakdownFromColumns($order);
        if ($breakdown !== []) {
            return array_merge(
                [['label' => 'Shipping Charges', 'amount' => 0, 'display' => '']],
                $breakdown,
            );
        }

        $shipping = $order->shipping_cost ?? null;

        return [[
            'label' => 'Shipping Charges',
            'amount' => is_numeric($shipping) ? (float) $shipping : 0,
            'display' => $this->shippingDisplay($shipping),
        ]];
    }

    /**
     * @return array<string, float>
     */
    protected function decodeShippingChargesArr(Order $order): array
    {
        if (empty($order->shipping_charges_arr)) {
            return [];
        }

        $decoded = is_string($order->shipping_charges_arr)
            ? json_decode($order->shipping_charges_arr, true)
            : $order->shipping_charges_arr;

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @return array<int, array{label: string, amount: float}>
     */
    protected function shippingBreakdownFromColumns(Order $order): array
    {
        $lines = [];

        $pallets = (float) ($order->pallets_cost ?? 0);
        if ($pallets > 0) {
            $count = (int) ($order->total_pallets ?? 1);
            $lines[] = ['label' => 'Pallets(Total Pallets = '.$count.')', 'amount' => $pallets];
        }

        $delivery = (float) ($order->delivery_cost ?? 0);
        if ($delivery > 0) {
            $deliveryType = strtolower((string) ($order->delivery_type ?? ''));
            $label = $deliveryType === 'commercial'
                ? 'Delivery Charges(Commercial)'
                : 'Delivery Charges(Residential)';
            $lines[] = ['label' => $label, 'amount' => $delivery];
        }

        $liftgate = (float) ($order->liftgate_cost ?? 0);
        if ($liftgate > 0) {
            $lines[] = ['label' => 'Liftgate Charges', 'amount' => $liftgate];
        }

        $unload = (float) ($order->unload_cost ?? 0);
        if ($unload > 0) {
            $unloadType = strtolower((string) ($order->unload_type ?? ''));
            $label = str_contains($unloadType, 'hand')
                ? 'Unload Charges(By Hand)'
                : 'Unload Charges(By Forklift)';
            $lines[] = ['label' => $label, 'amount' => $unload];
        }

        $misc = (float) ($order->miscellaneous_cost ?? $order->miscellneous_charges ?? 0);
        if ($misc > 0) {
            $lines[] = ['label' => 'Miscellneous Charges', 'amount' => $misc];
        }

        return $lines;
    }

    protected function shippingDisplay(mixed $shipping): string
    {
        if ($shipping === null || $shipping === '') {
            return '—';
        }

        if (is_numeric($shipping)) {
            return '$'.number_format((float) $shipping, 2);
        }

        if (Str::contains((string) $shipping, 'email', true) || Str::contains((string) $shipping, 'phone', true)) {
            return 'TBD';
        }

        return (string) $shipping;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    protected function buildRoomRows(Order $order): array
    {
        $rooms = $order->rooms ?? [];
        if (is_string($rooms)) {
            $rooms = json_decode($rooms, true) ?? [];
        }

        if (! is_array($rooms) || $rooms === []) {
            return [];
        }

        $sections = ProductSection::query()->pluck('cabinets_name', 'id');

        $rows = [];
        $first = reset($rooms);

        if (is_array($first) && array_key_exists('room_name', $first)) {
            foreach ($rooms as $room) {
                $roomName = (string) ($room['room_name'] ?? 'Room');
                foreach ($this->linesFromWorkspaceRoom($room, $sections) as $line) {
                    $rows[] = array_merge(['room_name' => $roomName], $line);
                }
            }

            return $rows;
        }

        foreach ($rooms as $roomName => $roomData) {
            $roomData = is_array($roomData) ? $roomData : (array) $roomData;
            foreach ($this->linesFromCiRoom($roomName, $roomData, $sections) as $line) {
                $rows[] = array_merge(['room_name' => (string) $roomName], $line);
            }
        }

        return $rows;
    }

    /**
     * @param  array<string, mixed>  $room
     * @param  \Illuminate\Support\Collection<int, string>  $sections
     * @return array<int, array<string, mixed>>
     */
    protected function linesFromWorkspaceRoom(array $room, $sections): array
    {
        $lines = [];
        foreach ($room['products'] ?? [] as $line) {
            $line = is_array($line) ? $line : (array) $line;
            $product = ! empty($line['product_id'])
                ? Product::query()->find($line['product_id'])
                : null;

            $sku = $line['sku'] ?? $product?->sku ?? '—';
            $qty = max(1, (int) ($line['quantity'] ?? 1));
            $unit = (float) ($line['cost'] ?? $product?->cost ?? 0);
            $weight = (float) ($line['weight'] ?? $product?->weight ?? 0);
            $sectionId = (int) ($product?->product_section_id ?? 0);
            $description = $line['description']
                ?? $line['label']
                ?? trim(($product?->doorColor?->product_label ?? '').' - '.$sku.' - '.($product?->label ?? ''));

            $lines[] = [
                'checkbox1' => ! empty($line['checkbox_val1']),
                'checkbox2' => ! empty($line['checkbox_val2']),
                'section' => $sections[$sectionId] ?? '—',
                'sku' => $sku,
                'description' => $description !== '' ? $description : '—',
                'weight' => number_format($weight, 0).' lbs',
                'unit_price' => $unit,
                'line_total' => $unit * $qty,
                'quantity' => $qty,
                'assemble_cost' => (float) ($line['assemble_cost'] ?? $product?->assemble_cost ?? 0),
            ];
        }

        return $lines;
    }

    /**
     * @param  array<string, mixed>  $roomData
     * @param  \Illuminate\Support\Collection<int, string>  $sections
     * @return array<int, array<string, mixed>>
     */
    protected function linesFromCiRoom(string $roomName, array $roomData, $sections): array
    {
        $skus = $roomData['product_sku'] ?? [];
        if (! is_array($skus)) {
            return [];
        }

        $count = count($skus);
        $lines = [];

        for ($i = 0; $i < $count; $i++) {
            $sku = $skus[$i] ?? '';
            $product = $sku !== '' ? Product::query()->where('sku', $sku)->first() : null;
            $sectionId = (int) ($roomData['product_cabinets_id'][$i] ?? $product?->product_section_id ?? 0);
            $qty = max(1, (int) ($roomData['product_quantity'][$i] ?? 1));
            $unit = (float) ($roomData['product_cost'][$i] ?? 0);
            $lineTotal = (float) ($roomData['product_tot_price'][$i] ?? ($unit * $qty));
            $weight = (float) ($roomData['product_weight'][$i] ?? 0);
            $description = $roomData['product_cabinets_description'][$i]
                ?? $roomData['product_details'][$i]
                ?? ($product?->label ?? '—');

            $lines[] = [
                'checkbox1' => (int) ($roomData['checkbox_val1'][$i] ?? 0) === 1,
                'checkbox2' => (int) ($roomData['checkbox_val2'][$i] ?? 0) === 1,
                'section' => $sections[$sectionId] ?? '—',
                'sku' => $sku,
                'description' => is_string($description) ? str_replace(['%39%', '%34%'], ["'", '"'], $description) : '—',
                'weight' => number_format($weight, 0).' lbs',
                'unit_price' => $unit,
                'line_total' => $lineTotal,
                'quantity' => $qty,
                'assemble_cost' => (float) ($roomData['product_assemble_cost'][$i] ?? 0),
            ];
        }

        return $lines;
    }
}
