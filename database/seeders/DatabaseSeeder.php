<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(TenantSeeder::class);
        // User::factory(25)->create();
        $this->call(PermissionTableSeeder::class);
        $this->call(ImportSQLSeeder::class);
        $this->call(CreateAdminUserSeeder::class);
        // $this->call(CountrySeeder::class);
        // $this->call(ProductCatalogSeeder::class);
        // $this->call(ProductSectionSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(TaxValueSeeder::class);
        $this->call(DoorColorsSeeder::class);

    }
}
