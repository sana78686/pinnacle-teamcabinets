<?php

namespace App\Services;

use App\Models\SalesTaxCounty;
use Illuminate\Support\Facades\Schema;

class SalesTaxCountiesService
{
    public function ensureFloridaDefaults(): void
    {
        if (! Schema::hasTable('sales_tax_counties')) {
            return;
        }

        if (SalesTaxCounty::query()->exists()) {
            return;
        }

        $stateId = (int) config('florida_sales_tax_counties.state_id', 9);

        foreach (config('florida_sales_tax_counties.counties', []) as $row) {
            SalesTaxCounty::query()->create([
                'counties' => $row['counties'],
                'state_id' => $stateId,
                'tax' => (float) $row['tax'],
            ]);
        }
    }

    public function countyCount(): int
    {
        if (! Schema::hasTable('sales_tax_counties')) {
            return 0;
        }

        return SalesTaxCounty::query()->count();
    }
}
