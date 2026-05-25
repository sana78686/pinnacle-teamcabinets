<?php

namespace App\Services;

use App\Models\ManageEmailsContent;
use App\Models\Product;
use App\Models\StockCheckRequest;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class StockCheckAdminViewService
{
    public function __construct(
        protected OrderWorkspaceCheckoutService $checkout,
        protected OrderWorkspaceNotificationService $notifications,
        protected TenantEmailService $emails,
        protected TaxValuesService $taxValues,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function viewData(StockCheckRequest $record, array $rooms, bool $viewingOrgData = false): array
    {
        $record->loadMissing(['user.country', 'user.state']);
        $user = $record->user;
        $addresses = $user ? $this->checkout->billShipAddresses($user) : $this->emptyAddresses();
        $assembleYes = in_array($record->assemble_cabinets_check, ['yes', '1', 1], true);
        $totals = $this->totalsFromRecord($record, $assembleYes);
        $isShippingRequired = $this->isShippingRequired($record);

        return array_merge($addresses, $totals, [
            'stock_check_request' => $record,
            'record' => $record,
            'rooms' => $rooms,
            'viewingOrgData' => $viewingOrgData,
            'lines' => $this->buildLineItems($rooms),
            'companyName' => $user?->company_name ?: 'N/A',
            'billName' => $record->billToName(),
            'assembleYes' => $assembleYes,
            'isShippingRequired' => $isShippingRequired,
            'isApproved' => $record->isApproved(),
            'showAdminForm' => ! $record->isApproved(),
            'deliveryLabel' => $this->deliveryLabel($record),
            'unloadLabel' => $this->unloadLabel($record),
            'palletUnitCost' => $this->taxValues->getFloat('pallet_cost', OrderWorkspaceShippingService::PALLET_COST),
            'fuelPercent' => $totals['fuel_percent'],
            'updateRoute' => route('tenant_stock_check_update', $record->id),
            'warehouseEmailRoute' => route('tenant_stock_check_warehouse_email', $record->id),
            'editRoute' => route('tenant_stock_check_edit', $record->id),
            'listRoute' => route('tenant_stock_check_index'),
            'pageTitle' => 'View Stock Check Request',
        ]);
    }

    public function isShippingRequired(StockCheckRequest $record): bool
    {
        if ($record->shipping_status === 'yes') {
            return true;
        }

        return (float) ($record->pallets_cost ?? 0) > 0
            || (float) ($record->delivery_cost ?? 0) > 0
            || (float) ($record->liftgate_cost ?? 0) > 0
            || (float) ($record->unload_cost ?? 0) > 0
            || (float) ($record->miscellaneous_cost ?? 0) > 0;
    }

    public function sendWarehouseEmail(StockCheckRequest $record, string $email): bool
    {
        $email = trim($email);
        if ($email === '') {
            return false;
        }

        $record->loadMissing(['user.country', 'user.state']);
        $lines = $this->buildLineItems($record->normalizedRooms());

        try {
            $this->emails->send(
                ManageEmailsContent::SLUG_STOCK_WAREHOUSE,
                $email,
                ['ID' => (string) $record->id],
                'stock_check_warehouse',
                [
                    'lines' => $lines,
                    'sub_total_weight' => $record->sub_total_weight,
                ]
            );

            return true;
        } catch (\Throwable $e) {
            Log::warning('Stock check warehouse email failed: '.$e->getMessage());

            return false;
        }
    }

    /**
     * @param  array{total_pallets: int, delivery_cost: float, liftgate_cost: float, unload_cost: float, miscellaneous_cost: float}  $input
     */
    public function applyDetailedShippingUpdate(StockCheckRequest $record, array $input): StockCheckRequest
    {
        $palletUnit = $this->taxValues->getFloat('pallet_cost', OrderWorkspaceShippingService::PALLET_COST);
        $totalPallets = max(1, (int) $input['total_pallets']);
        $palletsCost = round($totalPallets * $palletUnit, 2);
        $deliveryCost = round((float) $input['delivery_cost'], 2);
        $liftgateCost = round((float) $input['liftgate_cost'], 2);
        $unloadCost = round((float) $input['unload_cost'], 2);
        $miscCost = round((float) $input['miscellaneous_cost'], 2);
        $shippingCost = round($deliveryCost + $liftgateCost + $unloadCost + $palletsCost + $miscCost, 2);

        $assembleYes = in_array($record->assemble_cabinets_check, ['yes', '1', 1], true);
        $totals = $this->totalsFromRecord($record, $assembleYes);
        $grandTotal = round(
            (float) $totals['sub_total_price']
            + (float) $totals['sub_total_assemble']
            + (float) $totals['fuel_charges']
            + $shippingCost,
            2
        );

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

        if (Schema::hasColumn($record->getTable(), 'total_pallets')) {
            $attrs['total_pallets'] = $totalPallets;
        }

        $record->update($attrs);

        return $this->finalizeApproval($record->fresh(['user.country', 'user.state']));
    }

    public function applySimpleShippingUpdate(StockCheckRequest $record, float $shippingCharges): StockCheckRequest
    {
        $assembleYes = in_array($record->assemble_cabinets_check, ['yes', '1', 1], true);
        $totals = $this->totalsFromRecord($record, $assembleYes);
        $shippingCost = round($shippingCharges, 2);
        $grandTotal = round(
            (float) $totals['sub_total_price']
            + (float) $totals['sub_total_assemble']
            + (float) $totals['fuel_charges']
            + $shippingCost,
            2
        );

        $record->update([
            'shipping_cost' => (string) $shippingCost,
            'grand_total_cost' => (string) $grandTotal,
            'shipping_status' => 'yes',
        ]);

        return $this->finalizeApproval($record->fresh(['user.country', 'user.state']));
    }

    protected function finalizeApproval(StockCheckRequest $record): StockCheckRequest
    {
        $attrs = [];
        if (Schema::hasColumn($record->getTable(), 'is_approved')) {
            $attrs['is_approved'] = true;
        }
        if (Schema::hasColumn($record->getTable(), 'completion_date')) {
            $attrs['completion_date'] = now();
        }
        if ($attrs !== []) {
            $record->update($attrs);
            $record = $record->fresh(['user.country', 'user.state']);
        }

        $user = $record->user;
        if ($user) {
            try {
                TenantNotificationService::stockCheckApprovedForUser(
                    $record,
                    $user,
                    $this->isShippingRequired($record)
                );
            } catch (\Throwable $e) {
                Log::warning('Stock check approval panel notification failed: '.$e->getMessage());
            }
        }

        if ($user?->email) {
            try {
                $emailData = $this->buildWarehouseEmailData($record, $user);
                $emailData['is_updated'] = 1;
                $emailData['is_shipping_required'] = $this->isShippingRequired($record) ? 1 : 0;

                $this->emails->send(
                    ManageEmailsContent::SLUG_STOCK_USER,
                    $user->email,
                    ['USERNAME' => $record->billToName()],
                    'stock_check_workspace',
                    ['email_data' => $emailData]
                );
            } catch (\Throwable $e) {
                Log::warning('Stock check approval email failed: '.$e->getMessage());
            }
        }

        return $record;
    }

    /**
     * @return array<string, mixed>
     */
    public function buildWarehouseEmailData(StockCheckRequest $record, User $user): array
    {
        $shippingCosts = [
            'shipping_cost' => (float) ($record->shipping_cost ?? 0),
            'delivery_cost' => (float) ($record->delivery_cost ?? 0),
            'liftgate_cost' => (float) ($record->liftgate_cost ?? 0),
            'unload_cost' => (float) ($record->unload_cost ?? 0),
            'total_pallets' => (int) ($record->total_pallets ?? 1),
            'delivery_type' => 0,
            'unload_type' => 0,
        ];

        $data = $this->notifications->stockCheckEmailData($record, $user, $shippingCosts, (int) $record->id);
        $data['is_updated'] = $record->isApproved() ? 1 : 0;

        return $data;
    }

    /**
     * @return array<string, float|int|string>
     */
    protected function totalsFromRecord(StockCheckRequest $record, bool $assembleYes): array
    {
        $palletUnit = $this->taxValues->getFloat('pallet_cost', OrderWorkspaceShippingService::PALLET_COST);
        $palletsCost = (float) ($record->pallets_cost ?? 0);
        $storedPallets = Schema::hasColumn($record->getTable(), 'total_pallets')
            ? (int) ($record->total_pallets ?? 0)
            : 0;
        $subTotalWeight = (float) ($record->sub_total_weight ?? 0);
        $subTotalPrice = (float) ($record->sub_total_cost ?? 0);
        $subTotalAssemble = $assembleYes ? (float) ($record->sub_total_assemble_cost ?? 0) : 0.0;

        if ($storedPallets > 0) {
            $totalPallets = $storedPallets;
        } elseif ($palletsCost > 0 && $palletUnit > 0) {
            $totalPallets = max(1, (int) round($palletsCost / $palletUnit));
        } elseif ($subTotalWeight > 0) {
            $totalPallets = max(1, (int) ceil($subTotalWeight / 800));
        } else {
            $totalPallets = 1;
        }

        if ($palletsCost <= 0 && $this->isShippingRequired($record)) {
            $palletsCost = round($totalPallets * $palletUnit, 2);
        }

        $deliveryCost = (float) ($record->delivery_cost ?? 0);
        $liftgateCost = (float) ($record->liftgate_cost ?? 0);
        $unloadCost = (float) ($record->unload_cost ?? 0);
        $miscCost = (float) ($record->miscellaneous_cost ?? 0);
        $fuelPercent = (float) ($record->fuel_tax ?? $this->taxValues->getFloat('fuel_charges_value', 2));
        $fuelCharges = round(($subTotalPrice * $fuelPercent) / 100, 2);

        $shippingCost = round($deliveryCost + $liftgateCost + $unloadCost + $palletsCost + $miscCost, 2);

        $storedShipping = (float) ($record->shipping_cost ?? 0);
        if ($storedShipping > $shippingCost) {
            $shippingCost = $storedShipping;
        }

        $grandTotal = round($subTotalPrice + $subTotalAssemble + $fuelCharges + $shippingCost, 2);

        $storedGrand = (float) ($record->grand_total_cost ?? 0);
        if ($storedGrand > $grandTotal) {
            $grandTotal = $storedGrand;
        }

        return [
            'sub_total_weight' => $subTotalWeight,
            'sub_total_price' => $subTotalPrice,
            'sub_total_assemble' => $subTotalAssemble,
            'fuel_percent' => $fuelPercent,
            'fuel_charges' => $fuelCharges,
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

    protected function deliveryLabel(StockCheckRequest $record): string
    {
        return (float) ($record->delivery_cost ?? 0) > 0 ? 'Commercial' : 'Residential';
    }

    protected function unloadLabel(StockCheckRequest $record): string
    {
        return (float) ($record->unload_cost ?? 0) > 0 ? 'By Forklift' : 'By Hand';
    }

    /**
     * @param  array<int, mixed>  $rooms
     * @return array<int, array<string, mixed>>
     */
    protected function buildLineItems(array $rooms): array
    {
        $rooms = $this->checkout->normalizeRoomsFromStorage($rooms);
        $productIds = [];

        foreach ($rooms as $room) {
            foreach ($room['products'] ?? [] as $line) {
                if (! empty($line['product_id'])) {
                    $productIds[] = (int) $line['product_id'];
                }
            }
        }

        $products = Product::query()
            ->with('doorColor')
            ->whereIn('id', array_unique($productIds))
            ->get()
            ->keyBy('id');

        $lines = [];
        foreach ($rooms as $room) {
            foreach ($room['products'] ?? [] as $line) {
                $product = $products->get((int) ($line['product_id'] ?? 0));
                $qty = max(1, (int) ($line['quantity'] ?? 1));
                $unitCost = (float) preg_replace('/[^\d.]/', '', (string) ($line['cost'] ?? $product?->cost ?? 0));
                $listPrice = (float) preg_replace('/[^\d.]/', '', (string) ($line['cost1'] ?? $line['product_actual_price'] ?? $product?->cost ?? $unitCost));
                $unitWeight = (float) preg_replace('/[^\d.]/', '', (string) ($line['weight'] ?? $product?->weight ?? 0));
                $assembleUnit = (float) preg_replace('/[^\d.]/', '', (string) ($line['assemble_cost'] ?? $product?->assemble_cost ?? 0));
                $lineTotal = (float) ($line['line_total'] ?? 0);
                if ($lineTotal <= 0 || $lineTotal < $unitCost - 0.001 || abs($lineTotal - $qty) < 0.001) {
                    $lineTotal = round($unitCost * $qty, 2);
                }

                $sku = $product?->sku ?? ($line['sku'] ?? '');
                $description = trim((string) ($line['description'] ?? $line['label'] ?? ''));
                if ($description === '' && $product) {
                    $description = trim($sku.' — '.($product->doorColor?->product_label ?? ''));
                }

                $lines[] = [
                    'room_name' => $room['room_name'] ?? 'Room',
                    'sku' => $sku,
                    'cabinet_name' => $line['label'] ?? $product?->label ?? $sku,
                    'description' => $description,
                    'quantity' => $qty,
                    'weight' => $unitWeight,
                    'total_weight' => round($unitWeight * $qty, 2),
                    'unit_price' => $unitCost,
                    'list_price' => $listPrice,
                    'line_total' => $lineTotal,
                    'assemble_cost' => round($assembleUnit * $qty, 2),
                    'check_yellow' => ! empty($line['checkbox_val1']),
                    'check_green' => ! empty($line['checkbox_val2']),
                    'note' => (string) ($line['note'] ?? $line['product_note'] ?? ''),
                ];
            }
        }

        return $lines;
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
