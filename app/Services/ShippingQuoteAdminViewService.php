<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ShippingQuote;
use App\Models\User;

class ShippingQuoteAdminViewService
{
    public function __construct(
        protected OrderWorkspaceCheckoutService $checkout,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function viewData(ShippingQuote $record): array
    {
        $record->loadMissing(['user.country', 'user.state']);
        $user = $record->user;
        $addresses = $user ? $this->checkout->billShipAddresses($user) : $this->emptyAddresses();
        $lines = $this->buildLineItems($record->rooms ?? []);
        $totals = $this->totalsFromRecord($record);
        $palletUnit = app(TaxValuesService::class)->getFloat('pallet_cost', OrderWorkspaceShippingService::PALLET_COST);

        return array_merge($addresses, $totals, [
            'record' => $record,
            'quoteName' => $this->quoteDisplayName($record),
            'companyName' => $user?->company_name ?: 'N/A',
            'lines' => $lines,
            'palletUnitCost' => $palletUnit,
            'deliveryLabel' => $this->deliveryLabel($record),
            'unloadLabel' => $this->unloadLabel($record),
            'listRoute' => 'tenant_shipping_quotes_index',
            'updateRoute' => route('tenant_shipping_quotes_update_costs', $record->id),
        ]);
    }

    /**
     * @param  array{total_pallets: int, delivery_cost: float, liftgate_cost: float, unload_cost: float, miscellaneous_cost: float}  $input
     */
    public function applyAdminShippingUpdate(ShippingQuote $record, array $input): ShippingQuote
    {
        $palletUnit = app(TaxValuesService::class)->getFloat('pallet_cost', OrderWorkspaceShippingService::PALLET_COST);
        $totalPallets = max(1, (int) $input['total_pallets']);
        $palletsCost = round($totalPallets * $palletUnit, 2);
        $deliveryCost = round((float) $input['delivery_cost'], 2);
        $liftgateCost = round((float) $input['liftgate_cost'], 2);
        $unloadCost = round((float) $input['unload_cost'], 2);
        $miscCost = round((float) $input['miscellaneous_cost'], 2);

        $shippingCost = round($deliveryCost + $liftgateCost + $unloadCost + $palletsCost + $miscCost, 2);
        $subTotal = (float) ($record->sub_total_cost ?? 0);
        $assemble = (float) ($record->sub_total_assemble_cost ?? 0);
        $grandTotal = round($subTotal + $assemble + $shippingCost, 2);

        $attrs = [
            'pallets_cost' => (string) $palletsCost,
            'delivery_cost' => (string) $deliveryCost,
            'liftgate_cost' => (string) $liftgateCost,
            'unload_cost' => (string) $unloadCost,
            'miscellaneous_cost' => (string) $miscCost,
            'shipping_cost' => (string) $shippingCost,
            'grand_total_cost' => (string) $grandTotal,
            'shipping_status' => 'yes',
        ];

        if (\Illuminate\Support\Facades\Schema::hasColumn($record->getTable(), 'total_pallets')) {
            $attrs['total_pallets'] = $totalPallets;
        }

        $record->update($attrs);

        return $record->fresh();
    }

    /**
     * @param  array<int, array<string, mixed>>  $rooms
     * @return array<int, array<string, mixed>>
     */
    protected function buildLineItems(array $rooms): array
    {
        $productIds = [];
        foreach ($rooms as $room) {
            foreach ($room['products'] ?? [] as $line) {
                if (! empty($line['product_id'])) {
                    $productIds[] = (int) $line['product_id'];
                }
            }
        }

        $products = Product::query()
            ->whereIn('id', array_unique($productIds))
            ->get()
            ->keyBy('id');

        $lines = [];
        foreach ($rooms as $room) {
            foreach ($room['products'] ?? [] as $line) {
                $qty = max(1, (int) ($line['quantity'] ?? 1));
                $unit = (float) ($line['cost'] ?? 0);
                $weight = (float) ($line['weight'] ?? 0);
                $assemble = (float) ($line['assemble_cost'] ?? 0);
                $product = $products->get((int) ($line['product_id'] ?? 0));

                if ($unit <= 0 && $product) {
                    $unit = (float) preg_replace('/[^\d.]/', '', (string) $product->cost);
                }
                if ($weight <= 0 && $product) {
                    $weight = (float) preg_replace('/[^\d.]/', '', (string) $product->weight);
                }
                if ($assemble <= 0 && $product) {
                    $assemble = (float) preg_replace('/[^\d.]/', '', (string) $product->assemble_cost);
                }

                $lines[] = [
                    'room_name' => $room['room_name'] ?? '—',
                    'sku' => $line['sku'] ?? $product?->sku ?? '—',
                    'cabinet_name' => $line['label'] ?? $product?->label ?? '—',
                    'description' => $product?->description ?? $line['label'] ?? '—',
                    'weight' => $weight,
                    'unit_price' => $unit,
                    'line_total' => round($unit * $qty, 2),
                    'quantity' => $qty,
                    'assemble_cost' => round($assemble * $qty, 2),
                    'check_yellow' => ! empty($line['checkbox_val1']),
                    'check_green' => ! empty($line['checkbox_val2']),
                ];
            }
        }

        return $lines;
    }

    /**
     * @return array<string, float|int|string>
     */
    protected function totalsFromRecord(ShippingQuote $record): array
    {
        $palletUnit = app(TaxValuesService::class)->getFloat('pallet_cost', OrderWorkspaceShippingService::PALLET_COST);
        $palletsCost = (float) ($record->pallets_cost ?? 0);
        $storedPallets = 0;
        if (\Illuminate\Support\Facades\Schema::hasColumn($record->getTable(), 'total_pallets')) {
            $storedPallets = (int) ($record->total_pallets ?? 0);
        }
        $totalPallets = $storedPallets > 0
            ? $storedPallets
            : ($palletUnit > 0 && $palletsCost > 0 ? max(1, (int) round($palletsCost / $palletUnit)) : 1);

        $subTotalPrice = (float) ($record->sub_total_cost ?? 0);
        $subTotalWeight = (float) ($record->sub_total_weight ?? 0);
        $subTotalAssemble = (float) ($record->sub_total_assemble_cost ?? 0);
        $deliveryCost = (float) ($record->delivery_cost ?? 0);
        $liftgateCost = (float) ($record->liftgate_cost ?? 0);
        $unloadCost = (float) ($record->unload_cost ?? 0);
        $miscCost = (float) ($record->miscellaneous_cost ?? 0);
        $shippingCost = (float) ($record->shipping_cost ?? 0);
        if ($shippingCost <= 0) {
            $shippingCost = $deliveryCost + $liftgateCost + $unloadCost + $palletsCost + $miscCost;
        }
        $grandTotal = (float) ($record->grand_total_cost ?? ($subTotalPrice + $subTotalAssemble + $shippingCost));

        return [
            'sub_total_weight' => $subTotalWeight,
            'sub_total_price' => $subTotalPrice,
            'sub_total_assemble' => $subTotalAssemble,
            'total_pallets' => $totalPallets,
            'pallets_cost' => $palletsCost,
            'delivery_cost' => $deliveryCost,
            'liftgate_cost' => $liftgateCost,
            'unload_cost' => $unloadCost,
            'miscellaneous_cost' => $miscCost,
            'shipping_cost' => $shippingCost,
            'grand_total' => $grandTotal,
        ];
    }

    protected function quoteDisplayName(ShippingQuote $record): string
    {
        if (! empty($record->quote_name)) {
            return $record->quote_name;
        }

        $comment = (string) ($record->comment ?? '');
        if (preg_match('/^Shipping quote:\s*(.+?)(?:\n|$)/i', $comment, $m)) {
            return trim($m[1]);
        }
        if (preg_match('/^Quote:\s*(.+?)(?:\n|$)/', $comment, $m)) {
            return trim($m[1]);
        }

        return $record->job_name ?? '—';
    }

    protected function deliveryLabel(ShippingQuote $record): string
    {
        return (float) ($record->delivery_cost ?? 0) > 0 ? 'Commercial' : 'Residential';
    }

    protected function unloadLabel(ShippingQuote $record): string
    {
        return (float) ($record->unload_cost ?? 0) > 0 ? 'By Forklift' : 'By Hand';
    }

    /**
     * @return array<string, string>
     */
    protected function emptyAddresses(): array
    {
        return [
            'bill_to_name' => '—',
            'bill_to_address' => '',
            'bill_to_email' => '',
            'bill_to_phone' => '',
            'bill_to_city' => '',
            'bill_to_county' => '',
            'bill_to_state' => '',
            'bill_to_zipcode' => '',
            'bill_to_country' => '',
            'ship_to_name' => '—',
            'ship_to_address' => '',
            'ship_to_email' => '',
            'ship_to_phone' => '',
            'ship_to_city' => '',
            'ship_to_county' => '',
            'ship_to_state' => '',
            'ship_to_zipcode' => '',
            'ship_to_country' => '',
        ];
    }

}
