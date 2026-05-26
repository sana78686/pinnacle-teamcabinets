<?php

namespace App\Services;

use App\Models\Product;
use App\Models\SalesTaxCounty;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class OrderWorkspaceCheckoutService
{
    public function __construct(
        protected OrderWorkspaceService $workspace,
        protected OrderPricingService $pricing,
    ) {}

    /**
     * Build CI-style session cart_data for cart_checkout_product.
     *
     * @param  array<string, mixed>  $payload  From OrderWorkspaceService::parsePayload
     */
    public function buildSessionCartData(array $payload, Request $request): array
    {
        $user = $payload['user'];
        $user->loadMissing(['country', 'state']);

        $addresses = $this->billShipAddresses($user);
        $assembleYes = ($payload['assemble'] ?? 'no') === 'yes';
        $roomData = $this->buildCiRoomData($payload['rooms'] ?? [], $request, $user);

        $totals = $payload['totals'];
        $catalogId = $request->input('catalog_id');

        return array_merge($addresses, [
            'user_id' => $user->id,
            'job_name' => $payload['job_name'],
            'order_comment' => $payload['comment'] ?? '',
            'is_assemble' => $assembleYes ? 1 : 2,
            'assemble_cabinets_check' => $assembleYes ? 'yes' : 'no',
            'room_data' => json_encode($roomData),
            'cart_product_weight' => number_format($totals['sub_total_weight'], 2).' lbs',
            'all_cart_total' => number_format($totals['sub_total_cost'], 2, '.', ''),
            'catalogue' => $catalogId,
            'product_img_src' => $request->input('product_img_src', ''),
            'product_img_name' => $request->input('product_img_name', ''),
            'product_description_val' => '',
            'rep_id' => $request->input('cus_rep_id', ''),
            'parent_id' => $request->input('cus_parent_id', ''),
            'affiliate_id' => $request->input('affiliate_id', ''),
            'is_shipping_quote' => 0,
            'order_shipping_cost' => 0,
            'shipping_charges_arr' => json_encode([]),
            'stock_check_shipping_type' => 0,
        ]);
    }

    /**
     * CI cart_checkout_product / taxcal — Florida county table, else site_config fallback.
     */
    public function salesTaxPercent(User $user): float
    {
        if ((int) ($user->is_taxable_user ?? 0) === 1) {
            return 0.0;
        }

        $stateName = strtolower((string) ($user->state?->name ?? $user->state_name ?? ''));

        if ($stateName === 'florida' || $stateName === 'fl') {
            $county = trim((string) ($user->county_name ?? ''));
            if ($county !== '' && Schema::hasTable('sales_tax_counties')) {
                $row = SalesTaxCounty::query()->where('counties', $county)->first();
                if ($row && (float) $row->tax > 0) {
                    return (float) $row->tax;
                }
            }

            return 7.0;
        }

        return (float) (tax_value('sales_tax_percentage', 0) ?? 0);
    }

    /**
     * CI getPaymentCharges() — tenant tax_values (legacy site_config keys).
     *
     * @return array{fuel_percent: float, credit_card_percent: float, debit_card_flat: float, ach_charge: float}
     */
    public function paymentFeeConfig(): array
    {
        return [
            'fuel_percent' => (float) (tax_value('fuel_charges_value', 0) ?? 0),
            'credit_card_percent' => (float) (tax_value('credit_card_charges', 0) ?? 0),
            'debit_card_flat' => (float) (tax_value('debit_card_charges', 0) ?? 0),
            'ach_charge' => (float) (tax_value('ach_pay_charges', 0) ?? 0),
        ];
    }

    /**
     * @return array<int, string>
     */
    public function usStateOptions(): array
    {
        if (! Schema::hasTable('states')) {
            return ['Florida', 'Alabama', 'Georgia'];
        }

        return State::query()
            ->where('country_id', 233)
            ->orderBy('name')
            ->pluck('name')
            ->all();
    }

    /**
     * @return array<int, string>
     */
    public function floridaCountyOptions(): array
    {
        if (! Schema::hasTable('sales_tax_counties')) {
            return [];
        }

        return SalesTaxCounty::query()
            ->orderBy('counties')
            ->pluck('counties')
            ->all();
    }

    public function salesTaxPercentForLocation(string $state, string $county, User $user): float
    {
        if ((int) ($user->is_taxable_user ?? 0) === 1) {
            return 0.0;
        }

        $county = trim($county);
        if ($county !== '' && Schema::hasTable('sales_tax_counties')) {
            // CI behavior: if a managed county exists, prefer it (even if state text isn't Florida).
            $row = SalesTaxCounty::query()
                ->whereRaw('LOWER(counties) = ?', [strtolower($county)])
                ->first();
            if ($row && (float) $row->tax > 0) {
                return (float) $row->tax;
            }
        }

        $stateNorm = strtolower(trim($state));

        if ($stateNorm === 'florida' || $stateNorm === 'fl') {
            return 7.0;
        }

        return (float) (tax_value('sales_tax_percentage', 0) ?? 0);
    }

    /**
     * CI "You save" amounts vs credit-card fee baseline.
     *
     * @return array{credit: float, debit: float, ach: float, cash: float}
     */
    public function paymentSavings(
        float $subTotal,
        float $assembleTotal,
        float $salesTaxPercent,
        float $shippingCost = 0.0,
    ): array {
        $fees = $this->paymentFeeConfig();
        $fuelAmount = round($subTotal * ($fees['fuel_percent'] / 100), 2);
        $salesTaxAmount = round($subTotal * ($salesTaxPercent / 100), 2);
        $prePayment = $subTotal + $assembleTotal + $fuelAmount + $salesTaxAmount + $shippingCost;
        $creditFee = $fees['credit_card_percent'] > 0
            ? round($prePayment * ($fees['credit_card_percent'] / 100), 2)
            : 0.0;

        return [
            'credit' => 0.0,
            'debit' => max(0, round($creditFee - $fees['debit_card_flat'], 2)),
            'ach' => max(0, round($creditFee - $fees['ach_charge'], 2)),
            'cash' => $creditFee,
        ];
    }

    /**
     * CI checkout weight surcharge: +light or +heavy based on cart weight (lbs).
     */
    public function weightShippingSurcharge(float $cartWeight): float
    {
        if ($cartWeight <= 0) {
            return 0.0;
        }

        $tax = app(TaxValuesService::class);
        $lightThreshold = $tax->getFloat('shipping_light_threshold', 50.0);
        $lightSurcharge = $tax->getFloat(
            'shipping_light_surcharge',
            $tax->getFloat('commercial_delivery_charge', 75.0)
        );
        $heavySurcharge = $tax->getFloat(
            'shipping_heavy_surcharge',
            $tax->getFloat('liftgate_charge', 150.0)
        );

        if ($cartWeight <= $lightThreshold) {
            return $lightSurcharge;
        }

        return $heavySurcharge;
    }

    public function applyWeightShippingSurcharge(float $cartWeight, float $baseShipping): float
    {
        return round($baseShipping + $this->weightShippingSurcharge($cartWeight), 2);
    }

    public function resolvePaymentLabel(string $creditOrNot, ?string $cashMethod = null): string
    {
        return match ($creditOrNot) {
            'by_credit_card' => 'Credit Card',
            'by_debit_card' => 'Debit Card',
            'pay_ach' => 'ACH',
            'not_credit_card_and_ach' => match (strtolower((string) $cashMethod)) {
                'wire transfer', 'wire' => 'Wire Transfer',
                default => 'Cash',
            },
            default => 'Check',
        };
    }

    /**
     * @return array<string, mixed>
     */
    public function validateCheckout(Request $request): array
    {
        $paymentType = (string) $request->input('credit_or_not_credit_card', 'by_credit_card');

        $rules = [
            'credit_or_not_credit_card' => ['required', Rule::in([
                'by_credit_card', 'by_debit_card', 'pay_ach', 'not_credit_card_and_ach',
            ])],
            'bill_to_name' => 'required|string|max:255',
            'bill_to_address' => 'required|string|max:500',
            'bill_to_city' => 'required|string|max:120',
            'bill_to_state' => 'required|string|max:120',
            'bill_to_county' => 'required|string|max:120',
            'bill_to_country' => 'required|string|max:120',
            'bill_to_zip' => 'required|string|max:20',
            'bill_to_email' => 'required|email|max:255',
            'bill_to_phone' => 'required|string|max:40',
            'ship_to_name' => 'required|string|max:255',
            'ship_to_address' => 'required|string|max:500',
            'ship_city' => 'required|string|max:120',
            'ship_state' => 'required|string|max:120',
            'ship_county' => 'required|string|max:120',
            'ship_country' => 'required|string|max:120',
            'ship_zip' => 'required|string|max:20',
            'ship_to_email' => 'required|email|max:255',
            'ship_to_phone' => 'required|string|max:40',
            'updated_sales_tax' => 'nullable|numeric|min:0|max:100',
            'custom_all_cart_total' => 'nullable|numeric|min:0',
        ];

        if ($paymentType === 'by_credit_card') {
            $rules += [
                'checkout_fname' => 'required|string|max:120',
                'checkout_lname' => 'required|string|max:120',
                'checkout_address' => 'required|string|max:500',
                'checkout_city' => 'required|string|max:120',
                'checkout_state' => 'required|string|max:120',
                'checkout_zipcode' => 'required|string|max:20',
                'card_number' => 'required|string|max:24',
                'expiry_date' => ['required', 'regex:/^\d{2}\/\d{2}$/'],
                'cvv_number' => 'required|string|max:8',
                'membership_agree' => 'accepted',
            ];
        } elseif ($paymentType === 'by_debit_card') {
            $rules += [
                'debit_checkout_fname' => 'required|string|max:120',
                'debit_checkout_lname' => 'required|string|max:120',
                'debit_checkout_address' => 'required|string|max:500',
                'debit_checkout_city' => 'required|string|max:120',
                'debit_checkout_state' => 'required|string|max:120',
                'debit_checkout_zipcode' => 'required|string|max:20',
                'debit_card_number' => 'required|string|max:24',
                'debit_expiry_date' => ['required', 'regex:/^\d{2}\/\d{2}$/'],
                'debit_cvv_number' => 'required|string|max:8',
                'membership_agree' => 'accepted',
            ];
        } elseif ($paymentType === 'pay_ach') {
            $rules += [
                'ach_checkout_fname' => 'required|string|max:120',
                'ach_checkout_lname' => 'required|string|max:120',
                'ach_checkout_address' => 'required|string|max:500',
                'ach_checkout_city' => 'required|string|max:120',
                'ach_checkout_state' => 'required|string|max:120',
                'ach_checkout_zipcode' => 'required|string|max:20',
                'account_number' => 'required|string|max:30',
                'route_number' => 'required|string|max:15',
            ];
        } else {
            $rules['payment_method'] = ['required', Rule::in(['cash', 'wire transfer', 'wire'])];
        }

        return $request->validate($rules);
    }

    /**
     * CI order_data_insert total breakdown.
     *
     * @return array<string, float>
     */
    public function calculateCheckoutTotals(
        float $subTotal,
        float $assembleTotal,
        float $salesTaxPercent,
        string $paymentMethod,
        float $shippingCost = 0.0,
    ): array {
        $fees = $this->paymentFeeConfig();
        $fuelAmount = round($subTotal * ($fees['fuel_percent'] / 100), 2);
        $salesTaxAmount = round($subTotal * ($salesTaxPercent / 100), 2);

        $prePayment = $subTotal + $assembleTotal + $fuelAmount + $salesTaxAmount + $shippingCost;

        $cardChargeAmount = 0.0;
        $debitChargeAmount = 0.0;
        $achCharge = 0.0;
        $cardPercent = 0.0;
        $method = strtolower(trim($paymentMethod));

        if (in_array($method, ['credit card', 'credit', 'by_credit_card'], true)) {
            $cardPercent = $fees['credit_card_percent'];
            $cardChargeAmount = $cardPercent > 0 ? round($prePayment * ($cardPercent / 100), 2) : 0.0;
        } elseif (in_array($method, ['debit card', 'debit', 'by_debit_card'], true)) {
            $debitChargeAmount = $fees['debit_card_flat'];
        } elseif (in_array($method, ['ach', 'pay_ach'], true)) {
            $achCharge = $fees['ach_charge'];
        }

        $grandTotal = round($prePayment + $cardChargeAmount + $debitChargeAmount + $achCharge, 2);

        return [
            'fuel_percent' => $fees['fuel_percent'],
            'fuel_amount' => $fuelAmount,
            'sales_tax_percent' => $salesTaxPercent,
            'sales_tax_amount' => $salesTaxAmount,
            'credit_card_percent' => $cardPercent,
            'credit_card_charges' => $cardChargeAmount,
            'debit_card_charges' => $debitChargeAmount,
            'ach_charges' => $achCharge,
            'amount_before_tax' => round($subTotal + $assembleTotal + $fuelAmount + $shippingCost, 2),
            'grand_total' => $grandTotal,
            'payment_fee' => $cardChargeAmount + $debitChargeAmount + $achCharge,
        ];
    }

    /**
     * Sum line assemble amounts from CI-style room_data JSON.
     *
     * @param  array<string, array<string, mixed>>  $ciRooms
     */
    public function sumAssembleFromCiRoomMap(array $ciRooms): float
    {
        $total = 0.0;

        foreach ($ciRooms as $room) {
            if (! is_array($room)) {
                continue;
            }
            foreach ($room['product_assemble_cost'] ?? [] as $cost) {
                $total += (float) $cost;
            }
        }

        return round($total, 2);
    }

    /**
     * @param  array<int, array{room_name: string, products: array}>  $rooms
     * @return array<string, array<string, array<int, mixed>>>
     */
    public function buildCiRoomData(array $rooms, Request $request, ?User $user = null): array
    {
        $doorColor = (string) $request->input('product_img_name', '');
        $catalogName = (string) $request->input('catalogue_name', '');
        $catalogId = (int) $request->input('catalog_id', 0);
        $user = $user ?? $request->user();
        $chain = $user ? $this->pricing->userChain($user) : ['acting' => null, 'parent' => null, 'representative' => null];

        $ciRooms = [];
        foreach ($rooms as $room) {
            $roomName = $room['room_name'] ?? 'Room';
            $skus = [];
            $weights = [];
            $costs = [];
            $qtys = [];
            $names = [];
            $ids = [];
            $cabinetIds = [];
            $colors = [];
            $descriptions = [];
            $totPrices = [];
            $actualPrices = [];
            $details = [];
            $assembleCosts = [];
            $cb1 = [];
            $cb2 = [];
            $parentDoorPrices = [];
            $parentDoorFactors = [];
            $repDoorPrices = [];
            $repDoorFactors = [];
            $userDoorPrices = [];
            $userDoorFactors = [];
            $catalogNames = [];

            foreach ($room['products'] ?? [] as $line) {
                $product = Product::with(['doorColor', 'productCatalog'])->find($line['product_id'] ?? 0);
                if (! $product) {
                    continue;
                }
                $qty = max(1, (int) ($line['quantity'] ?? 1));
                $unitCost = (float) ($line['cost'] ?? 0);
                if ($unitCost <= 0) {
                    $unitCost = (float) preg_replace('/[^\d.]/', '', (string) $product->cost);
                }
                $rawCost = (float) ($line['cost1'] ?? $unitCost);
                $unitWeight = (float) ($line['weight'] ?? 0);
                if ($unitWeight <= 0) {
                    $unitWeight = (float) preg_replace('/[^\d.]/', '', (string) $product->weight);
                }
                $color = $product->doorColor?->product_label ?? $doorColor;
                $doorStyle = (string) ($line['product_cabinets_color'] ?? $line['door_style'] ?? $color);
                $desc = trim(($product->sku ?? '').' — '.$color.' — '.($product->label ?? ''));
                $lineCatalogId = $catalogId > 0 ? $catalogId : (int) ($product->product_catalog_id ?? $product->productCatalog?->id ?? 0);
                $doorId = (int) ($product->door_color_id ?? $product->doorColor?->id ?? 0);
                $basePrice = (float) ($line['product_actual_price'] ?? $line['product_cost'] ?? $rawCost);

                $userFactor = 0.0;
                $parentFactor = 0.0;
                $repFactor = 0.0;
                $userUnitPrice = 0.0;
                $parentUnitPrice = 0.0;
                $repUnitPrice = 0.0;
                $lineCatalogName = $catalogName;

                if ($user && $lineCatalogId > 0 && $doorId > 0) {
                    $context = $this->pricing->contextFor($user, $lineCatalogId, $doorId);
                    $userFactor = (float) ($context['user_door_point'] ?? $context['door_factor'] ?? 0);
                    $parentFactor = (float) ($context['parent_door_point'] ?? 0);
                    $repFactor = (float) ($context['representative_door_point'] ?? 0);
                    $lineCatalogName = (string) ($context['catalog_key'] ?? $catalogName);
                } elseif ($user) {
                    $lineCatalogName = $catalogName !== '' ? $catalogName : (string) ($line['catalog_name'] ?? '');
                    $userFactor = $this->getDoorFactor($user, $lineCatalogName, $doorStyle);
                    $parentFactor = $chain['parent']
                        ? $this->getDoorFactor($chain['parent'], $lineCatalogName, $doorStyle)
                        : 0.0;
                    $repFactor = $chain['representative']
                        ? $this->getDoorFactor($chain['representative'], $lineCatalogName, $doorStyle)
                        : 0.0;
                }

                if ($basePrice > 0) {
                    $userUnitPrice = $userFactor > 0 ? round($basePrice * $userFactor, 2) : 0.0;
                    $parentUnitPrice = $parentFactor > 0 ? round($basePrice * $parentFactor, 2) : 0.0;
                    $repUnitPrice = $repFactor > 0 ? round($basePrice * $repFactor, 2) : 0.0;
                }

                $skus[] = $product->sku;
                $weights[] = $unitWeight;
                $costs[] = $unitCost;
                $qtys[] = $qty;
                $names[] = $product->label;
                $ids[] = (string) $product->id;
                $cabinetIds[] = (string) $product->product_section_id;
                $colors[] = $color;
                $descriptions[] = $desc;
                $totPrices[] = number_format($unitCost * $qty, 2, '.', '');
                $actualPrices[] = number_format($basePrice > 0 ? $basePrice : $rawCost, 2, '.', '');
                $details[] = $line['product_details'] ?? $product->value_1 ?? $product->description ?? '';
                $assembleCosts[] = (float) ($line['assemble_cost'] ?? preg_replace('/[^\d.]/', '', (string) $product->assemble_cost));
                $cb1[] = ! empty($line['checkbox_val1']) ? '1' : '0';
                $cb2[] = ! empty($line['checkbox_val2']) ? '1' : '0';
                $userDoorPrices[] = $userUnitPrice > 0 ? (string) $userUnitPrice : '0';
                $parentDoorPrices[] = $parentUnitPrice > 0 ? (string) $parentUnitPrice : '0';
                $parentDoorFactors[] = $parentFactor > 0 ? (string) $parentFactor : '';
                $repDoorPrices[] = $repUnitPrice > 0 ? (string) $repUnitPrice : '';
                $repDoorFactors[] = $repFactor > 0 ? (string) $repFactor : '';
                $userDoorFactors[] = $userFactor > 0 ? (string) $userFactor : '';
                $catalogNames[] = $lineCatalogName !== '' ? $lineCatalogName : $catalogName;
            }

            if ($skus === []) {
                continue;
            }

            $ciRooms[$roomName] = [
                'checkbox_val1' => $cb1,
                'checkbox_val2' => $cb2,
                'product_sku' => $skus,
                'product_weight' => $weights,
                'product_quantity' => $qtys,
                'product_cost' => $costs,
                'product_count_cost' => $costs,
                'product_cabinets_id' => $cabinetIds,
                'product_name' => $names,
                'product_ids' => $ids,
                'product_cabinets_color' => $colors,
                'product_tot_quantity' => $qtys,
                'product_tot_price' => $totPrices,
                'product_actual_price' => $actualPrices,
                'product_details' => $details,
                'add_pro_ids_room_wise' => $ids,
                'product_cabinets_description' => $descriptions,
                'product_assemble_cost' => $assembleCosts,
                'sel_catalogue_name' => $catalogNames,
                'user_door_price' => $userDoorPrices,
                'parent_door_price' => $parentDoorPrices,
                'parent_door_factor' => $parentDoorFactors,
                'representative_door_price' => $repDoorPrices,
                'representative_door_factor' => $repDoorFactors,
                'user_door_factor' => $userDoorFactors,
                'product_note' => array_fill(0, count($skus), ''),
            ];
        }

        return $ciRooms;
    }

    private function getDoorFactor(?User $user, string $catalogName, string $doorStyle): float
    {
        if (! $user) {
            return 0.0;
        }

        $dpf = is_array($user->door_point_factor)
            ? $user->door_point_factor
            : json_decode($user->door_point_factor ?? '{}', true);

        if (! is_array($dpf)) {
            $dpf = [];
        }

        return (float) ($dpf[$catalogName][$doorStyle] ?? $user->point_factor ?? 0);
    }

    /**
     * Normalize workspace rooms from modern or legacy CI JSON into [{room_name, products: [...]}].
     *
     * @param  array<mixed>  $rooms
     * @return array<int, array{room_name: string, products: array<int, array<string, mixed>>}>
     */
    public function normalizeRoomsFromStorage(array $rooms): array
    {
        if ($rooms === []) {
            return [];
        }

        if ($this->isCiRoomMap($rooms)) {
            return $this->ciRoomMapToModern($rooms);
        }

        $normalized = [];
        foreach ($rooms as $room) {
            if (! is_array($room)) {
                continue;
            }
            if (isset($room['product_sku']) && is_array($room['product_sku'])) {
                $roomName = (string) ($room['room_name'] ?? 'Room');
                $normalized = array_merge($normalized, $this->ciRoomMapToModern([$roomName => $room]));

                continue;
            }
            $products = $room['products'] ?? [];
            if (! is_array($products) || $products === []) {
                continue;
            }
            $normalized[] = [
                'room_name' => (string) ($room['room_name'] ?? 'Room'),
                'products' => $products,
            ];
        }

        return $normalized;
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

    /**
     * @param  array<string, array<string, mixed>>  $rooms
     * @return array<int, array{room_name: string, products: array<int, array<string, mixed>>}>
     */
    protected function ciRoomMapToModern(array $rooms): array
    {
        $out = [];

        foreach ($rooms as $roomName => $val) {
            if (! is_array($val)) {
                continue;
            }
            $skus = $val['product_sku'] ?? [];
            if (! is_array($skus) || $skus === []) {
                continue;
            }

            $products = [];
            $count = count($skus);
            for ($i = 0; $i < $count; $i++) {
                $qty = max(1, (int) ($val['product_quantity'][$i] ?? 1));
                $unit = (float) ($val['product_cost'][$i] ?? 0);
                $totPrice = (float) preg_replace('/[^\d.]/', '', (string) ($val['product_tot_price'][$i] ?? ''));
                $productId = (int) ($val['product_ids'][$i] ?? $val['add_pro_ids_room_wise'][$i] ?? 0);

                $actual = (float) preg_replace('/[^\d.]/', '', (string) ($val['product_actual_price'][$i] ?? $val['product_count_cost'][$i] ?? ''));
                $lineTotal = $totPrice > 0 ? $totPrice : round($unit * $qty, 2);
                if ($lineTotal <= 0 || abs($lineTotal - $qty) < 0.001) {
                    $lineTotal = round($unit * $qty, 2);
                }

                $products[] = [
                    'product_id' => $productId > 0 ? $productId : null,
                    'sku' => (string) ($skus[$i] ?? ''),
                    'label' => (string) ($val['product_name'][$i] ?? ''),
                    'quantity' => $qty,
                    'weight' => (float) ($val['product_weight'][$i] ?? 0),
                    'cost' => $unit,
                    'cost1' => $actual > 0 ? $actual : $unit,
                    'line_total' => $lineTotal,
                    'description' => (string) ($val['product_cabinets_description'][$i] ?? $val['product_name'][$i] ?? $skus[$i] ?? ''),
                    'assemble_cost' => (float) ($val['product_assemble_cost'][$i] ?? 0),
                    'note' => (string) ($val['product_note'][$i] ?? ''),
                    'checkbox_val1' => ($val['checkbox_val1'][$i] ?? '0') === '1' || ($val['checkbox_val1'][$i] ?? 0) == 1,
                    'checkbox_val2' => ($val['checkbox_val2'][$i] ?? '0') === '1' || ($val['checkbox_val2'][$i] ?? 0) == 1,
                ];
            }

            if ($products !== []) {
                $out[] = [
                    'room_name' => (string) $roomName,
                    'products' => $products,
                ];
            }
        }

        return $out;
    }

    /**
     * @return array<string, string>
     */
    public function billShipAddresses(User $user): array
    {
        $billName = trim((string) ($user->name ?? ''));
        if ($billName === '') {
            $billName = 'Customer';
        }

        $country = $user->country?->name ?? '';
        $state = $user->state?->name ?? '';

        return [
            'bill_to_name' => $billName,
            'bill_to_address' => $user->address ?? '',
            'bill_to_email' => $user->email ?? '',
            'bill_to_phone' => $user->phone ?? '',
            'bill_to_city' => $user->city_name ?? '',
            'bill_to_county' => $user->county_name ?? '',
            'bill_to_state' => $state,
            'bill_to_zipcode' => $user->zip_code ?? '',
            'bill_to_country' => $country,
            'ship_to_name' => $billName,
            'ship_to_address' => $user->address ?? '',
            'ship_to_email' => $user->email ?? '',
            'ship_to_phone' => $user->phone ?? '',
            'ship_to_city' => $user->city_name ?? '',
            'ship_to_county' => $user->county_name ?? '',
            'ship_to_state' => $state,
            'ship_to_zipcode' => $user->zip_code ?? '',
            'ship_to_country' => $country,
        ];
    }
}
