<?php

namespace App\Services;

use App\Models\PointFactorDefault;
use App\Models\TaxValues;
use Illuminate\Support\Facades\File;

class TeamCabinetsTenantDefaultsService
{
    public function targetTenantId(): string
    {
        return (string) config('team_cabinets_tenant.tenant_id', 'team-cabinets');
    }

    public function isTargetTenant(): bool
    {
        return tenant('id') === $this->targetTenantId();
    }

    public function apply(): array
    {
        $applied = ['taxes' => 0, 'terms' => 0, 'point_factors' => 0];

        foreach (config('team_cabinets_tenant.taxes', []) as $key => $value) {
            $meta = TaxValuesService::feeKeys()[$key] ?? ['label' => $key, 'default' => $value];
            TaxValues::query()->updateOrCreate(
                ['tenant_id' => tenant('id'), 'option_key' => $key],
                [
                    'option_value' => (string) $value,
                    'field_label' => $meta['label'],
                ]
            );
            $applied['taxes']++;
        }

        foreach (config('team_cabinets_tenant.terms_files', []) as $key => $filename) {
            $path = database_path('seeders/data/'.$filename);
            if (! File::isFile($path)) {
                continue;
            }
            TaxValues::query()->updateOrCreate(
                ['tenant_id' => tenant('id'), 'option_key' => $key],
                [
                    'option_value' => File::get($path),
                    'field_label' => $key === 'ship_quote_terms_and_condition'
                        ? 'Ship Quote Terms And Conditions'
                        : 'Terms And Conditions',
                ]
            );
            $applied['terms']++;
        }

        $applied['point_factors'] = app(PointFactorDefaultsService::class)->syncFromCiConfig();

        app(SalesTaxCountiesService::class)->ensureFloridaDefaults();

        app(ManageOtherPageContentService::class)->ensureDefaults();
        app(StorefrontPageService::class)->ensureDefaults();
        $orderCatalog = app(TeamCabinetsOrderCatalogService::class)->apply();
        $applied['order_catalogs'] = $orderCatalog['catalogs'] ?? 0;
        $applied['order_products'] = $orderCatalog['products'] ?? 0;

        return $applied;
    }
}
