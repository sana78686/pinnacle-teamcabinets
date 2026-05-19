<?php

namespace Database\Seeders;

use App\Models\DoorColors;
use App\Models\ProductCatalog;
use App\Models\ProductSection;
use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Reader as ExcelReader;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = [
            // public_path('team_cabinets_old_data/ARTSTAR--20250220.csv'),
            public_path('team_cabinets_old_data/TEAM CABINETS--20250220.csv'),
            // public_path('team_cabinets_old_data/Semi Custom--20250221.csv'),
            // public_path('team_cabinets_old_data/ARTSTAR--20250220.csv'),
        ];

        foreach ($files as $filePath)
        {
            if (!file_exists($filePath)) {
                $this->command->error("File not found: $filePath");
                continue;
            }
            // $filePath = public_path('team_cabinets_old_data/ARTSTAR--20250220.csv');

            // Read the CSV file using Maatwebsite\Excel
            $data = Excel::toArray([], $filePath)[0]; // Get the first sheet data

            $header = array_shift($data); // Extract the first row as header

            foreach ($data as $row) {
                $rowData = array_combine($header, $row);

                // Get or create ProductCatalog
                $catalog = ProductCatalog::firstOrCreate(
                    ['name' => $rowData['Catalog']],
                    ['created_at' => now(), 'updated_at' => now(),
                    'tenant_id' => 'tenant1',
                    // 'tenant_id' => 'razorlighting.com',
                    ]
                );

                // Get or create ProductSection
                $section = ProductSection::firstOrCreate(
                    ['cabinets_name' => $rowData['Cabinet_section']],
                    ['created_at' => now(), 'updated_at' => now(),
                    'tenant_id' => 'tenant1',
                    // 'tenant_id' => 'razorlighting.com',
                    ]
                );


                // Assign a random tenant
                $tenant = Tenant::inRandomOrder()->first();

                // Ensure the door color exists only once per tenant and catalog
                $doorColor = DoorColors::firstOrCreate(
                    [
                        'tenant_id' => 'tenant1',
                        // 'tenant_id' => 'razorlighting.com',

                        'product_catalog_id' => $catalog->id,
                        'product_label' => $rowData['Cabinet_color'] ?? 'No Color',
                    ],
                    ['status' => 1, 'created_at' => now(), 'updated_at' => now()]
                );
                // Insert product
                DB::table('products')->insert([
                    'product_catalog_id' => $catalog->id,
                    'product_section_id' => $section->id,
                    'door_color_id' => $doorColor->id,
                    'label' => $rowData['Cabinet_label'] ?? 'No Label',
                    'sku' => $rowData['SKU'] ?? 'N/A',
                    'weight' => $rowData['Weight'] ?? 0,
                    'cost' => $rowData['Cost'] ?? 0,
                    'qty' => $rowData['Quantity'] ?? 0,
                    'image' => 'uploads/products/' . ($rowData['Image'] ?? ''),
                    'description' => $rowData['Details'] ?? '',
                    'assemble_cost' => $rowData['Assemble_cost'] ?? '',
                    'created_at' => now(),
                    'updated_at' => now(),
                    'tenant_id' => 'tenant1',
                    // 'tenant_id' => 'razorlighting.com',

                    // 'tenant_id' => Tenant::inRandomOrder()->first()->id,
                ]);
            }

            $this->command->info("Seeded: " . basename($filePath));
        }

        $this->command->info("All products seeded successfully!");
    }
}
