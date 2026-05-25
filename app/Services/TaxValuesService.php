<?php

namespace App\Services;

use App\Models\TaxValues;
use Illuminate\Support\Facades\Auth;

class TaxValuesService
{
    /** @return array<string, array{label: string, default: string}> */
    public static function paymentFeeKeys(): array
    {
        return [
            'fuel_charges_value' => ['label' => 'Fuel surcharge (%)', 'default' => '2'],
            'credit_card_charges' => ['label' => 'Credit card charges (%)', 'default' => '3'],
            'debit_card_charges' => ['label' => 'Debit card charges (%)', 'default' => '0.5'],
            'ach_pay_charges' => ['label' => 'ACH charges ($)', 'default' => '10.00'],
            'sales_tax_percentage' => ['label' => 'Fallback sales tax (%) — used when county lookup is unavailable', 'default' => '0'],
        ];
    }

    /** @return array<string, array{label: string, default: string}> */
    public static function shippingFeeKeys(): array
    {
        return [
            'commercial_delivery_charge' => ['label' => 'Commercial delivery charge ($)', 'default' => '75'],
            'liftgate_charge' => ['label' => 'Liftgate charge ($)', 'default' => '150'],
            'unload_charge' => ['label' => 'Unload charge ($) — waived for residential by-hand', 'default' => '150'],
            'pallet_cost' => ['label' => 'Pallet cost ($ per pallet)', 'default' => '30'],
            'shipping_light_threshold' => ['label' => 'Cart weight light threshold (lbs) — surcharge below/equal', 'default' => '50'],
            'shipping_heavy_threshold' => ['label' => 'Cart weight heavy threshold (lbs) — reference', 'default' => '150'],
            'shipping_light_surcharge' => ['label' => 'Weight-based light shipping surcharge ($)', 'default' => '75'],
            'shipping_heavy_surcharge' => ['label' => 'Weight-based heavy shipping surcharge ($)', 'default' => '150'],
        ];
    }

    /** @return array<string, array{label: string, default: string}> */
    public static function paytraceKeys(): array
    {
        return [
            'paytrace_username' => ['label' => 'Paytrace API username', 'default' => ''],
            'paytrace_password' => ['label' => 'Paytrace API password', 'default' => ''],
        ];
    }

    /** @return array<string, array{label: string, default: string}> */
    public static function feeKeys(): array
    {
        return array_merge(
            self::paymentFeeKeys(),
            self::shippingFeeKeys(),
            self::paytraceKeys()
        );
    }

    public function ensureDefaults(): void
    {
        $tenantId = tenant('id');
        if (! $tenantId) {
            return;
        }

        foreach (self::feeKeys() as $key => $meta) {
            TaxValues::query()->firstOrCreate(
                ['tenant_id' => $tenantId, 'option_key' => $key],
                [
                    'option_value' => $meta['default'],
                    'field_label' => $meta['label'],
                ]
            );
        }

        app(SalesTaxCountiesService::class)->ensureFloridaDefaults();
    }

    public function get(string $key, ?string $default = null): ?string
    {
        $row = TaxValues::query()->where('option_key', $key)->first();
        $metaDefault = self::feeKeys()[$key]['default'] ?? null;

        return $row?->option_value ?? $default ?? $metaDefault;
    }

    public function getFloat(string $key, float $fallback = 0.0): float
    {
        $raw = $this->get($key);
        if ($raw === null || $raw === '') {
            return $fallback;
        }

        return (float) $raw;
    }

    public function set(string $key, string $value, ?string $label = null): void
    {
        $tenantId = tenant('id');
        $meta = self::feeKeys()[$key] ?? ['label' => $label ?? $key, 'default' => ''];

        TaxValues::query()->updateOrCreate(
            ['tenant_id' => $tenantId, 'option_key' => $key],
            [
                'option_value' => $value,
                'field_label' => $label ?? $meta['label'],
                'updated_by' => Auth::id(),
            ]
        );
    }

    public function feesConfigured(): bool
    {
        foreach (['fuel_charges_value', 'credit_card_charges', 'debit_card_charges', 'ach_pay_charges'] as $key) {
            $val = $this->get($key);
            if ($val === null || $val === '') {
                return false;
            }
        }

        return true;
    }
}
