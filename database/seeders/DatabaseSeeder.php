<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // After migrate:fresh, central migrations include tenant tables (2026_05_*).
        // Legacy tenant-folder migrations: php artisan migrate:tenant-schema
        // Do not use tenants:migrate-fresh on a shared database — it wipes all tables.

        // CI email templates (OTP, orders, registration, etc.)
        $this->call(ManageEmailsContentSeeder::class);

        // Permissions, then tenant roles (Admin, Dealer, Representative, …)
        $this->call(PermissionTableSeeder::class);
        $this->call(TenantRoleSeeder::class);

        // US country (233) + states — fast. Full world: php artisan geo:import-world
        $this->call(UsGeoSeeder::class);

        // Super-admin login for pinnacle.apimstec.com
        $this->call(CreateAdminUserSeeder::class);

        // --- Disabled: create tenants & catalog via Pinnacle admin / tenant panel instead ---
        // $this->call(TenantSeeder::class);       // demo tenants (tenant1, tenant2, …)
        // $this->call(ProductSeeder::class);     // bulk product CSV import
        // $this->call(TaxValueSeeder::class);
        // $this->call(DoorColorsSeeder::class);
    }
}
