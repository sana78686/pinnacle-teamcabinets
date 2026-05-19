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
        // CI email templates (OTP, orders, registration, etc.)
        $this->call(ManageEmailsContentSeeder::class);

        // Permissions, then tenant roles (Admin, Dealer, Representative, …)
        $this->call(PermissionTableSeeder::class);
        $this->call(TenantRoleSeeder::class);

        // Countries / states / cities (world.sql)
        $this->call(ImportSQLSeeder::class);

        // Super-admin login for pinnacle.apimstec.com
        $this->call(CreateAdminUserSeeder::class);

        // --- Disabled: create tenants & catalog via Pinnacle admin / tenant panel instead ---
        // $this->call(TenantSeeder::class);       // demo tenants (tenant1, tenant2, …)
        // $this->call(ProductSeeder::class);     // bulk product CSV import
        // $this->call(TaxValueSeeder::class);
        // $this->call(DoorColorsSeeder::class);
    }
}
