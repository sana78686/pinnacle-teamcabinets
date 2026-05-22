<?php

namespace App\Services;

/**
 * CI Admin::insert_order_val shipping fee rules (commercial +$75, liftgate +$150, unload $150 / $0).
 */
class OrderWorkspaceShippingService
{
    public const PALLET_COST = 30.0;

    /**
     * @param  array{delivery_type?: string, liftgate?: string, unload_type?: string}  $options
     * @return array{
     *   delivery_type: int,
     *   is_liftgate_required: int,
     *   unload_type: int,
     *   delivery_cost: float,
     *   liftgate_cost: float,
     *   unload_cost: float,
     *   total_pallets: int,
     *   pallets_cost: float,
     *   shipping_cost: float,
     *   is_shipping_required: int
     * }
     */
    public function calculate(array $options, bool $shippingRequired = true): array
    {
        if (! $shippingRequired) {
            return [
                'delivery_type' => 0,
                'is_liftgate_required' => 0,
                'unload_type' => 0,
                'delivery_cost' => 0.0,
                'liftgate_cost' => 0.0,
                'unload_cost' => 0.0,
                'total_pallets' => 1,
                'pallets_cost' => 0.0,
                'shipping_cost' => 0.0,
                'is_shipping_required' => 0,
            ];
        }

        $deliveryTypeStr = (string) ($options['delivery_type'] ?? '');
        $liftgateStr = (string) ($options['liftgate'] ?? '');
        $unloadStr = (string) ($options['unload_type'] ?? '');

        $taxValues = app(TaxValuesService::class);
        $commercialCharge = $taxValues->getFloat('commercial_delivery_charge', 75.0);
        $liftgateCharge = $taxValues->getFloat('liftgate_charge', 150.0);
        $unloadChargeDefault = $taxValues->getFloat('unload_charge', 150.0);
        $palletUnitCost = $taxValues->getFloat('pallet_cost', self::PALLET_COST);

        $deliveryCost = $deliveryTypeStr === 'commercial' ? $commercialCharge : 0.0;
        $liftgateCost = $liftgateStr === 'yes' ? $liftgateCharge : 0.0;
        $unloadCost = $unloadChargeDefault;
        if ($deliveryTypeStr !== 'commercial' && $unloadStr === 'by_hand') {
            $unloadCost = 0.0;
        }

        $pallets = 1;
        $palletsCost = $pallets * $palletUnitCost;
        $shippingCost = $deliveryCost + $liftgateCost + $unloadCost + $palletsCost;

        return [
            'delivery_type' => $deliveryTypeStr === 'commercial' ? 1 : 2,
            'is_liftgate_required' => $liftgateStr === 'yes' ? 1 : 0,
            'unload_type' => $unloadStr === 'by_hand' ? 1 : 2,
            'delivery_cost' => $deliveryCost,
            'liftgate_cost' => $liftgateCost,
            'unload_cost' => $unloadCost,
            'total_pallets' => $pallets,
            'pallets_cost' => $palletsCost,
            'shipping_cost' => $shippingCost,
            'is_shipping_required' => 1,
        ];
    }

    /**
     * @return array<string, float>
     */
    public function chargesBreakdown(array $costs): array
    {
        $lines = [];
        if (($costs['delivery_cost'] ?? 0) > 0) {
            $label = ($costs['delivery_type'] ?? 0) == 1 ? 'Delivery Charges(Commercial)' : 'Delivery Charges(Residential)';
            $lines[$label] = (float) $costs['delivery_cost'];
        }
        if (($costs['liftgate_cost'] ?? 0) > 0) {
            $lines['Liftgate Charges'] = (float) $costs['liftgate_cost'];
        }
        if (($costs['unload_cost'] ?? 0) > 0) {
            $label = ($costs['unload_type'] ?? 0) == 1 ? 'Unload Charges(By Hand)' : 'Unload Charges(By Forklift)';
            $lines[$label] = (float) $costs['unload_cost'];
        }
        if (($costs['pallets_cost'] ?? 0) > 0) {
            $lines['Pallets(Total Pallets = '.($costs['total_pallets'] ?? 1).')'] = (float) $costs['pallets_cost'];
        }

        return $lines;
    }
}
