<?php

namespace App\Services;

use App\Models\DoorColors;
use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\ProductSection;

class TeamCabinetsOrderCatalogService
{
    public function apply(): array
    {
        if (! tenant('id')) {
            return ['catalogs' => 0, 'doors' => 0, 'sections' => 0, 'products' => 0];
        }

        $counts = ['catalogs' => 0, 'doors' => 0, 'sections' => 0, 'products' => 0];
        $tenantId = tenant('id');

        foreach (config('team_cabinets_order_catalog.catalogs', []) as $catalogDef) {
            $catalog = ProductCatalog::query()->updateOrCreate(
                ['tenant_id' => $tenantId, 'name' => $catalogDef['name']],
                [
                    'image' => $catalogDef['image'] ?? null,
                    'pdf' => $catalogDef['pdf'] ?? null,
                    'status' => 1,
                ]
            );
            $counts['catalogs']++;

            foreach ($catalogDef['doors'] ?? [] as $doorDef) {
                DoorColors::query()->updateOrCreate(
                    [
                        'tenant_id' => $tenantId,
                        'product_catalog_id' => $catalog->id,
                        'product_label' => $doorDef['label'],
                    ],
                    [
                        'image' => $doorDef['image'] ?? null,
                        'status' => 1,
                    ]
                );
                $counts['doors']++;
            }
        }

        $sectionsByName = [];
        foreach (config('team_cabinets_order_catalog.sections', []) as $sectionName) {
            $section = ProductSection::query()->updateOrCreate(
                ['tenant_id' => $tenantId, 'cabinets_name' => $sectionName],
                ['assemble_price' => '0']
            );
            $sectionsByName[$sectionName] = $section;
            $counts['sections']++;
        }

        $catalogs = ProductCatalog::query()->where('tenant_id', $tenantId)->get();
        $doors = DoorColors::query()->where('tenant_id', $tenantId)->where('status', 1)->get();

        foreach (config('team_cabinets_order_catalog.sample_products', []) as $sectionName => $products) {
            $section = $sectionsByName[$sectionName] ?? null;
            if (! $section) {
                continue;
            }

            foreach ($catalogs as $catalog) {
                foreach ($doors->where('product_catalog_id', $catalog->id) as $door) {
                    foreach ($products as $productDef) {
                        Product::query()->updateOrCreate(
                            [
                                'tenant_id' => $tenantId,
                                'sku' => $productDef['sku'],
                                'product_catalog_id' => $catalog->id,
                                'door_color_id' => $door->id,
                            ],
                            [
                                'product_section_id' => $section->id,
                                'label' => $productDef['label'],
                                'description' => $productDef['description'] ?? '',
                                'weight' => $productDef['weight'] ?? '0',
                                'cost' => $productDef['cost'] ?? '0',
                                'assemble_cost' => $productDef['assemble_cost'] ?? '0',
                                'qty' => $productDef['qty'] ?? '999',
                            ]
                        );
                        $counts['products']++;
                    }
                }
            }
        }

        return $counts;
    }
}
