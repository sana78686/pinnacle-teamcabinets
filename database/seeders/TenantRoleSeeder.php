<?php

namespace Database\Seeders;

use App\Services\TenantRoleService;
use Illuminate\Database\Seeder;

class TenantRoleSeeder extends Seeder
{
    public function run(): void
    {
        TenantRoleService::ensureDefaultRoles();
    }
}
