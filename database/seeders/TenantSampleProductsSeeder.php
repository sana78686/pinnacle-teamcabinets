<?php

namespace Database\Seeders;

use App\Models\DoorColors;
use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\ProductSection;
use App\Models\Tenant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Resets and seeds ~30 real CI-style products for one tenant (shared DB).
 *
 * Run for the current / chosen tenant only:
 *   php artisan tenants:seed --tenants=team-cabinets --class=TenantSampleProductsSeeder --force
 *
 * Replace team-cabinets with your tenant id from the tenants table.
 */
class TenantSampleProductsSeeder extends Seeder
{
    private const TEAM_CABINETS_ROWS = 20;

    private const ARTSTAR_ROWS = 10;

    public function run(): void
    {
        if (tenant()) {
            $this->seedForCurrentTenant((string) tenant('id'));

            return;
        }

        $tenantId = $this->resolveTenantId();
        $tenant = Tenant::query()->find($tenantId);

        if (! $tenant) {
            $this->command?->error("Tenant [{$tenantId}] not found. Use --tenants=your-tenant-id on the command.");

            return;
        }

        $tenant->run(fn () => $this->seedForCurrentTenant((string) tenant('id')));
    }

    private function seedForCurrentTenant(string $tenantId): void
    {
        $this->resetTenantCatalogData($tenantId);

        $rows = array_merge(
            $this->readCsvRows(public_path('team_cabinets_old_data/TEAM CABINETS--20250220.csv'), self::TEAM_CABINETS_ROWS),
            $this->readCsvRows(public_path('team_cabinets_old_data/ARTSTAR--20250220.csv'), self::ARTSTAR_ROWS),
        );

        if ($rows === []) {
            $this->command?->error('No CSV rows loaded. Ensure public/team_cabinets_old_data/*.csv exist.');

            return;
        }

        $stats = $this->seedRows($tenantId, $rows);

        $this->command?->info(sprintf(
            'Tenant [%s]: %d catalogs, %d sections, %d door colors (styles), %d products.',
            $tenantId,
            $stats['catalogs'],
            $stats['sections'],
            $stats['door_colors'],
            $stats['products'],
        ));
    }

    /**
     * Initial tenant lookup only; inside run() use tenant('id') from --tenants=….
     */
    private function resolveTenantId(): string
    {
        if (filled(env('TENANT_ID'))) {
            return (string) env('TENANT_ID');
        }

        return (string) config('team_cabinets_tenant.tenant_id', 'team-cabinets');
    }

    private function resetTenantCatalogData(string $tenantId): void
    {
        DB::table('cart_products')
            ->whereIn('product_id', function ($query) use ($tenantId) {
                $query->select('id')
                    ->from('products')
                    ->where('tenant_id', $tenantId);
            })
            ->delete();

        Product::withoutGlobalScopes()
            ->where('tenant_id', $tenantId)
            ->forceDelete();

        DoorColors::withoutGlobalScopes()
            ->where('tenant_id', $tenantId)
            ->forceDelete();

        ProductSection::withoutGlobalScopes()
            ->where('tenant_id', $tenantId)
            ->forceDelete();

        ProductCatalog::withoutGlobalScopes()
            ->where('tenant_id', $tenantId)
            ->forceDelete();

        $this->command?->warn("Cleared existing catalogs, sections, door colors, and products for tenant [{$tenantId}].");
    }

    /**
     * @return list<array<string, string>>
     */
    private function readCsvRows(string $path, int $limit): array
    {
        if (! is_file($path)) {
            $this->command?->warn("CSV not found: {$path}");

            return [];
        }

        $handle = fopen($path, 'r');

        if ($handle === false) {
            return [];
        }

        $header = fgetcsv($handle);

        if ($header === false) {
            fclose($handle);

            return [];
        }

        $rows = [];

        while (($row = fgetcsv($handle)) !== false && count($rows) < $limit) {
            if (count($row) !== count($header)) {
                continue;
            }

            $rows[] = array_combine($header, $row);
        }

        fclose($handle);

        return $rows;
    }

    /**
     * @param  list<array<string, string>>  $rows
     * @return array{catalogs: int, sections: int, door_colors: int, products: int}
     */
    private function seedRows(string $tenantId, array $rows): array
    {
        $catalogIds = [];
        $sectionIds = [];
        $doorColorIds = [];
        $productCount = 0;

        foreach ($rows as $row) {
            $catalogName = trim((string) ($row['Catalog'] ?? ''));
            $sectionName = trim((string) ($row['Cabinet_section'] ?? ''));
            $doorLabel = trim((string) ($row['Cabinet_color'] ?? 'No Color'));

            if ($catalogName === '' || $sectionName === '') {
                continue;
            }

            $catalogKey = $catalogName;
            if (! isset($catalogIds[$catalogKey])) {
                $catalog = ProductCatalog::create([
                    'name' => $catalogName,
                    'status' => 1,
                    'tenant_id' => $tenantId,
                ]);
                $catalogIds[$catalogKey] = $catalog->id;
            }

            $sectionKey = $catalogName.'|'.$sectionName;
            if (! isset($sectionIds[$sectionKey])) {
                $section = ProductSection::create([
                    'cabinets_name' => $sectionName,
                    'tenant_id' => $tenantId,
                ]);
                $sectionIds[$sectionKey] = $section->id;
            }

            $doorKey = $catalogIds[$catalogKey].'|'.$doorLabel;
            if (! isset($doorColorIds[$doorKey])) {
                $doorColor = DoorColors::create([
                    'tenant_id' => $tenantId,
                    'product_catalog_id' => $catalogIds[$catalogKey],
                    'product_label' => $doorLabel,
                    'status' => 1,
                ]);
                $doorColorIds[$doorKey] = $doorColor->id;
            }

            Product::create([
                'tenant_id' => $tenantId,
                'product_catalog_id' => $catalogIds[$catalogKey],
                'product_section_id' => $sectionIds[$sectionKey],
                'door_color_id' => $doorColorIds[$doorKey],
                'label' => $row['Cabinet_label'] ?? 'No Label',
                'sku' => $row['SKU'] ?? 'N/A',
                'weight' => $row['Weight'] ?? '0',
                'cost' => $row['Cost'] ?? '0',
                'qty' => $row['Quantity'] ?? '0',
                'image' => 'uploads/products/'.($row['Image'] ?? ''),
                'description' => $row['Details'] ?? '',
                'assemble_cost' => $row['Assemble_cost'] ?? '0',
            ]);

            $productCount++;
        }

        return [
            'catalogs' => count($catalogIds),
            'sections' => count($sectionIds),
            'door_colors' => count($doorColorIds),
            'products' => $productCount,
        ];
    }
}
