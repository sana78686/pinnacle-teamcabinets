<?php

namespace Database\Seeders;

use App\Models\ProductCatalog;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCatalogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'ARTSTAR',
            'TEAM CABINETS',
            'ASPEN',
            'TEAM-SEMI',
            'Semi Custom',
        ];
        // ProductCatalog::create([
        //     ['name' => 'ARTSTAR', 'image' => 'Artstar_Catalog_2.jpg', 'pdf' => 'Artstar_Catalog_with_Specs.pdf', 'status' => 1],
        //     ['name' => 'TEAM CABINETS', 'image' => 'Team_Cabinets_Catalog1.jpg', 'pdf' => '2021_Team_Cabinets_Catalog.pdf', 'status' => 1],
        //     ['name' => 'ASPEN', 'image' => 'Aspen_White_Raised_Panel-AW1.jpg', 'status' => 1],
        //     ['name' => 'TEAM-SEMI', 'image' => 'Semi-Beige_Raised_Panel.jpg', 'status' => 1],
        //     ['name' => 'Semi Custom', 'image' => 'essex_truffle_sddr.jpg', 'status' => 1],

        // ]);
        foreach ($names as $name) {
            ProductCatalog::create([
                'name' => $name,
                'tenant_id' => 'tenant1',
                // 'tenant_id' => Tenant::inRandomOrder()->first()->id,
            ]);
        }
        foreach ($names as $name) {
            ProductCatalog::create([
                'name' => $name,
                'tenant_id' => 'razorlighting.com',
                // 'tenant_id' => Tenant::inRandomOrder()->first()->id,
            ]);
        }
    }
}
