<?php

namespace Database\Seeders;

use App\Services\TenantPermissionService;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        TenantPermissionService::syncPermissions();
    }
}
