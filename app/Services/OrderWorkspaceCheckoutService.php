<?php

namespace App\Services;

use App\Models\Product;
use App\Models\SalesTaxCounty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class OrderWorkspaceCheckoutService
{
    public function __construct(
        protected OrderWorkspaceService $workspace,
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
        $roomData = $this->buildCiRoomData($payload['rooms'] ?? [], $request);

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
     * @return array{fuel_percent: float, credit_card_percent: float, debit_card_percent: float, ach_charge: float}
     */
    public function paymentFeeConfig(): array
    {
        return [
            'fuel_percent' => (float) (tax_value('fuel_charges_value', 0) ?? 0),
            'credit_card_percent' => (float) (tax_value('credit_card_charges', 0) ?? 0),
            'debit_card_percent' => (float) (tax_value('debit_card_charges', 0) ?? 0),
            'ach_charge' => (float) (tax_value('ach_pay_charges', 0) ?? 0),
        ];
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

        $cardPercent = 0.0;
        $achCharge = 0.0;
        $method = strtolower($paymentMethod);

        if (str_contains($method, 'credit')) {
            $cardPercent = $fees['credit_card_percent'];
        } elseif (str_contains($method, 'debit')) {
            $cardPercent = $fees['debit_card_percent'];
        } elseif ($method === 'ach') {
            $achCharge = $fees['ach_charge'];
        }

        $cardChargeAmount = $cardPercent > 0 ? round($prePayment * ($cardPercent / 100), 2) : 0.0;
        $grandTotal = round($prePayment + $cardChargeAmount + $achCharge, 2);

        return [
            'fuel_percent' => $fees['fuel_percent'],
            'fuel_amount' => $fuelAmount,
            'sales_tax_percent' => $salesTaxPercent,
            'sales_tax_amount' => $salesTaxAmount,
            'credit_card_percent' => $cardPercent,
            'credit_card_charges' => $cardChargeAmount,
            'ach_charges' => $achCharge,
            'amount_before_tax' => round($subTotal + $assembleTotal + $fuelAmount + $shippingCost, 2),
            'grand_total' => $grandTotal,
        ];
    }

    /**
     * @param  array<int, array{room_name: string, products: array}>  $rooms
     * @return array<string, array<string, array<int, mixed>>>
     */
    public function buildCiRoomData(array $rooms, Request $request): array
    {
        $doorColor = (string) $request->input('product_img_name', '');
        $catalogName = (string) $request->input('catalogue_name', '');

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

            foreach ($room['products'] ?? [] as $line) {
                $product = Product::with('doorColor')->find($line['product_id'] ?? 0);
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
                $desc = trim(($product->sku ?? '').' — '.$color.' — '.($product->label ?? ''));

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
                $actualPrices[] = number_format($rawCost, 2, '.', '');
                $details[] = $line['product_details'] ?? $product->value_1 ?? $product->description ?? '';
                $assembleCosts[] = (float) ($line['assemble_cost'] ?? preg_replace('/[^\d.]/', '', (string) $product->assemble_cost));
                $cb1[] = ! empty($line['checkbox_val1']) ? '1' : '0';
                $cb2[] = ! empty($line['checkbox_val2']) ? '1' : '0';
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
                'sel_catalogue_name' => array_fill(0, count($skus), $catalogName),
                'parent_door_price' => array_fill(0, count($skus), '0'),
                'parent_door_factor' => array_fill(0, count($skus), ''),
                'representative_door_price' => array_fill(0, count($skus), ''),
                'representative_door_factor' => array_fill(0, count($skus), ''),
                'user_door_factor' => array_fill(0, count($skus), ''),
                'product_note' => array_fill(0, count($skus), ''),
            ];
        }

        return $ciRooms;
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
