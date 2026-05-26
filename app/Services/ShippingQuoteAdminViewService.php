<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\ShippingQuote;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ShippingQuoteAdminViewService
{
    public function __construct(
        protected OrderWorkspaceCheckoutService $checkout,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function viewData(ShippingQuote $record, bool $forAdmin = false): array
    {
        $record->loadMissing(['user.country', 'user.state']);
        $user = $record->user;
        $addresses = $user ? $this->checkout->billShipAddresses($user) : $this->emptyAddresses();
        $lines = $this->buildLineItems($record->rooms ?? []);
        $shippingUpdated = $this->isShippingUpdated($record);
        $showShippingCharges = $forAdmin || $shippingUpdated;
        $totals = $this->totalsFromRecord($record, $showShippingCharges);
        $palletUnit = app(TaxValuesService::class)->getFloat('pallet_cost', OrderWorkspaceShippingService::PALLET_COST);

        $assembleYes = in_array($record->assemble_cabinets_check ?? '', ['yes', '1', 1], true);

        return array_merge($addresses, $totals, [
            'record' => $record,
            'quoteName' => $this->quoteDisplayName($record),
            'companyName' => $user?->company_name ?: 'N/A',
            'lines' => $lines,
            'assembleYes' => $assembleYes,
            'isShippingQuote' => true,
            'palletUnitCost' => $palletUnit,
            'deliveryLabel' => $this->deliveryLabel($record),
            'unloadLabel' => $this->unloadLabel($record),
            'listRoute' => 'tenant_shipping_quotes_index',
            'updateRoute' => route('tenant_shipping_quotes_update_costs', $record->id),
            'showAdminForm' => $forAdmin,
            'showShippingCharges' => $showShippingCharges,
            'isShippingUpdated' => $shippingUpdated,
        ]);
    }

    public function isShippingUpdated(ShippingQuote $record): bool
    {
        if (Schema::hasColumn($record->getTable(), 'is_shipping_updated')) {
            return (bool) $record->is_shipping_updated;
        }

        return (float) ($record->shipping_cost ?? 0) > 0;
    }

    public function canProceedToCheckout(ShippingQuote $record): bool
    {
        return $record->shipping_status === 'yes'
            && $this->isShippingUpdated($record)
            && (float) ($record->shipping_cost ?? 0) > 0
            && (float) ($record->grand_total_cost ?? 0) > 0;
    }

    /**
     * @return array{payload: array<string, mixed>, cartData: array<string, mixed>}
     */
    public function buildCheckoutSession(ShippingQuote $record, User $user): array
    {
        if (! $this->canProceedToCheckout($record)) {
            throw new \InvalidArgumentException('Shipping quote is not ready for checkout.');
        }

        $record->loadMissing(['user.country', 'user.state']);
        $assembleYes = in_array($record->assemble_cabinets_check, ['yes', '1', 1], true);
        $shippingCost = (float) ($record->shipping_cost ?? 0);
        $subTotal = (float) ($record->sub_total_cost ?? 0);
        $assembleTotal = (float) ($record->sub_total_assemble_cost ?? 0);
        $weight = (float) ($record->sub_total_weight ?? 0);

        $payload = [
            'job_name' => $record->job_name,
            'rooms' => $record->rooms ?? [],
            'assemble' => $assembleYes ? 'yes' : 'no',
            'shipping_status' => 'yes',
            'comment' => $record->comment,
            'quote_name' => $record->quote_name,
            'user' => $user,
            'totals' => [
                'sub_total_cost' => $subTotal,
                'sub_total_weight' => $weight,
                'sub_total_assemble_cost' => $assembleTotal,
                'grand_total_cost' => (float) ($record->grand_total_cost ?? 0),
            ],
            'shipping_cost' => $shippingCost,
            'product_catalog_id' => $record->product_catalog_id,
            'door_color_id' => $record->door_color_id,
            'product_img_src' => $record->product_img_src,
            'product_img_name' => $record->product_img_name,
            'shipping_quote_id' => $record->id,
            'delivery_cost' => (float) ($record->delivery_cost ?? 0),
            'liftgate_cost' => (float) ($record->liftgate_cost ?? 0),
            'unload_cost' => (float) ($record->unload_cost ?? 0),
            'pallets_cost' => (float) ($record->pallets_cost ?? 0),
            'miscellaneous_cost' => (float) ($record->miscellaneous_cost ?? 0),
        ];

        $catalogName = $record->product_catalog_id
            ? (ProductCatalog::query()->whereKey($record->product_catalog_id)->value('name') ?? '')
            : '';

        $roomRequest = Request::create('/', 'GET', [
            'product_img_name' => $record->product_img_name,
            'catalogue_name' => $catalogName,
            'catalog_id' => $record->product_catalog_id,
        ]);

        $cartData = array_merge($this->checkout->billShipAddresses($user), [
            'user_id' => $user->id,
            'job_name' => $record->job_name,
            'order_comment' => $record->comment ?? '',
            'is_assemble' => $assembleYes ? 1 : 2,
            'assemble_cabinets_check' => $assembleYes ? 'yes' : 'no',
            'room_data' => json_encode($this->checkout->buildCiRoomData($record->rooms ?? [], $roomRequest, $user)),
            'cart_product_weight' => number_format($weight, 2).' lbs',
            'all_cart_total' => number_format($subTotal, 2, '.', ''),
            'catalogue' => $record->product_catalog_id,
            'product_img_src' => $record->product_img_src ?? '',
            'product_img_name' => $record->product_img_name ?? '',
            'is_shipping_quote' => 1,
            'order_shipping_cost' => $shippingCost,
            'shipping_charges_arr' => json_encode($this->shippingChargesBreakdown($record)),
            'shipping_quote_id' => $record->id,
            'stock_check_shipping_type' => 0,
        ]);

        return ['payload' => $payload, 'cartData' => $cartData];
    }

    /**
     * @return array<string, float>
     */
    protected function shippingChargesBreakdown(ShippingQuote $record): array
    {
        $lines = [];
        $pallets = (float) ($record->pallets_cost ?? 0);
        if ($pallets > 0) {
            $count = (int) ($record->total_pallets ?? 1);
            $lines['Pallets(Total Pallets = '.$count.')'] = $pallets;
        }
        $delivery = (float) ($record->delivery_cost ?? 0);
        if ($delivery > 0) {
            $lines[$this->deliveryLabel($record) === 'Commercial'
                ? 'Delivery Charges(Commercial)'
                : 'Delivery Charges(Residential)'] = $delivery;
        }
        $liftgate = (float) ($record->liftgate_cost ?? 0);
        if ($liftgate > 0) {
            $lines['Liftgate Charges'] = $liftgate;
        }
        $unload = (float) ($record->unload_cost ?? 0);
        if ($unload > 0) {
            $label = $this->unloadLabel($record) === 'By Hand'
                ? 'Unload Charges(By Hand)'
                : 'Unload Charges(By Forklift)';
            $lines[$label] = $unload;
        }
        $misc = (float) ($record->miscellaneous_cost ?? 0);
        if ($misc > 0) {
            $lines['Miscellneous Charges'] = $misc;
        }

        return $lines;
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

        if (Schema::hasColumn($record->getTable(), 'total_pallets')) {
            $attrs['total_pallets'] = $totalPallets;
        }

        if (Schema::hasColumn($record->getTable(), 'is_shipping_updated')) {
            $attrs['is_shipping_updated'] = true;
        }

        if (Schema::hasColumn($record->getTable(), 'user_viewed_at')) {
            $attrs['user_viewed_at'] = null;
        }

        $record->update($attrs);

        $record = $record->fresh();
        $user = $record->user;
        if ($user) {
            try {
                TenantNotificationService::shippingQuoteRespondedForUser($record, $user);
            } catch (\Throwable) {
                // Panel notification is optional; header alert still applies.
            }
        }

        return $record;
    }

    /**
     * @param  array<int, array<string, mixed>>  $rooms
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
                $lineTotal = (float) ($line['line_total'] ?? 0);
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
                if ($lineTotal <= 0) {
                    $lineTotal = round($unit * $qty, 2);
                }

                $sku = $line['sku'] ?? $product?->sku ?? '—';
                $description = $line['description'] ?? $line['label'] ?? $product?->description ?? $sku;
                $lines[] = [
                    'room_name' => $room['room_name'] ?? '—',
                    'sku' => $sku,
                    'cabinet_name' => $sku,
                    'description' => $description,
                    'weight' => $weight,
                    'unit_price' => $unit,
                    'line_total' => $lineTotal,
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
    protected function totalsFromRecord(ShippingQuote $record, bool $includeShipping = true): array
    {
        $palletUnit = app(TaxValuesService::class)->getFloat('pallet_cost', OrderWorkspaceShippingService::PALLET_COST);
        $palletsCost = (float) ($record->pallets_cost ?? 0);
        $storedPallets = 0;
        if (Schema::hasColumn($record->getTable(), 'total_pallets')) {
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

        if (! $includeShipping) {
            $shippingCost = 0.0;
            $palletsCost = 0.0;
            $deliveryCost = 0.0;
            $liftgateCost = 0.0;
            $unloadCost = 0.0;
            $miscCost = 0.0;
        }

        $grandTotal = round($subTotalPrice + $subTotalAssemble + ($includeShipping ? $shippingCost : 0.0), 2);

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
        if (Schema::hasColumn($record->getTable(), 'unload_type')) {
            return (int) $record->unload_type === 1 ? 'By Hand' : 'By Forklift';
        }

        $unload = (float) ($record->unload_cost ?? 0);
        if ($unload <= 0) {
            return 'By Hand';
        }

        // CI: residential + by_hand => $0; residential + forklift => $150;
        // commercial + either unload method => $150 (by_hand still billed on commercial).
        return (float) ($record->delivery_cost ?? 0) > 0 ? 'By Hand' : 'By Forklift';
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
