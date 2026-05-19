<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DoorColorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('door_colors')->insert([
        //     ['product_catalog_id' => 1, 'product_label' => 'Shaker White','tenant_id' => Tenant::inRandomOrder()->first()->id,],
        //     ['product_catalog_id' => 2, 'product_label' => 'Charleston White', 'tenant_id' => Tenant::inRandomOrder()->first()->id,],
        //     ['product_catalog_id' => 2, 'product_label' => 'Shaker Gray', 'tenant_id' => Tenant::inRandomOrder()->first()->id,],
        //     ['product_catalog_id' => 2, 'product_label' => 'Shaker White', 'tenant_id' => Tenant::inRandomOrder()->first()->id,],
        //     ['product_catalog_id' => 2, 'product_label' => 'Shaker Espresso', 'tenant_id' => Tenant::inRandomOrder()->first()->id,],
        //     ['product_catalog_id' => 2, 'product_label' => 'Navy Blue', 'tenant_id' => Tenant::inRandomOrder()->first()->id,],
        //     ['product_catalog_id' => 2, 'product_label' => 'Aspen White', 'tenant_id' => Tenant::inRandomOrder()->first()->id,],
        // ]);


        $id = Auth::id();
         DB::table('door_colors')->insert([
            ['product_catalog_id' => 3, 'product_label' => 'Shaker White','tenant_id' => $id,],
            ['product_catalog_id' => 3, 'product_label' => 'Charleston White', 'tenant_id' => $id,],
            ['product_catalog_id' => 3, 'product_label' => 'Shaker Gray', 'tenant_id' => $id,],
            ['product_catalog_id' => 4, 'product_label' => 'Shaker White', 'tenant_id' => $id,],
            ['product_catalog_id' => 4, 'product_label' => 'Shaker Espresso', 'tenant_id' => $id,],
            ['product_catalog_id' => 4, 'product_label' => 'Navy Blue', 'tenant_id' => $id,],
            ['product_catalog_id' => 4, 'product_label' => 'Aspen White', 'tenant_id' => $id,],
        ]);
    }
}
