<?php

namespace Database\Seeders;

use App\Models\ProductSection;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $names = [
            'Tall Cabinet',
            'Wall Cabinet',
        ];
        foreach ($names as $cabinets_name) {
            ProductSection::create([
                'cabinets_name' => $cabinets_name,
                'tenant_id' => 'tenant1',
            ]);
        }
        foreach ($names as $cabinets_name) {
            ProductSection::create([
                'cabinets_name' => $cabinets_name,
                'tenant_id' => 'razorlighting.com',
            ]);
        }
    }
}
