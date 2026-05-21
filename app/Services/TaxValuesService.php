<?php

namespace App\Services;

use App\Models\TaxValues;
use Illuminate\Support\Facades\Auth;

class TaxValuesService
{
    /** @return array<string, array{label: string, default: string}> */
    public static function feeKeys(): array
    {
        return [
            'fuel_charges_value' => ['label' => 'Fuel surcharge (%)', 'default' => '0'],
            'credit_card_charges' => ['label' => 'Credit card charges (%)', 'default' => '3'],
            'debit_card_charges' => ['label' => 'Debit card charges (%)', 'default' => '0.5'],
            'ach_pay_charges' => ['label' => 'ACH charges ($)', 'default' => '10.00'],
            'sales_tax_percentage' => ['label' => 'Fallback sales tax (%) — used when QuickBooks tax is unavailable', 'default' => '0'],
        ];
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
    }

    public function get(string $key, ?string $default = null): ?string
    {
        $row = TaxValues::query()->where('option_key', $key)->first();

        return $row?->option_value ?? $default;
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
