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
        // $this->call(TenantSeeder::class);
        // User::factory(25)->create();
        $this->call(PermissionTableSeeder::class);
        $user = User::create([
            'name' => 'Team Cabinets',
            'email' => 'super-user@demo.com',
            'username' => 'Pinnacle Super User',
            'password' => Hash::make('password'),
            'is_super_user' => 1,
            'country_id' => 233,
            'state_id' => State::inRandomOrder()->first()->id,
            'address' => '915 Doyle Road Suite 303 -225',
            'city_name' => 'Deltona',
            'county_name' => 'Volusia County',
            'tenant_id' => Tenant::inRandomOrder()->first()->id,
        ]);
        // $this->call(ImportSQLSeeder::class);
        // $this->call(CreateAdminUserSeeder::class);
        // $this->call(CountrySeeder::class);
        // $this->call(ProductCatalogSeeder::class);
        // $this->call(ProductSectionSeeder::class);
        // $this->call(ProductSeeder::class);
        // $this->call(TaxValueSeeder::class);
        // $this->call(DoorColorsSeeder::class);

    }
}
