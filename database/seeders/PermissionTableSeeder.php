<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'user-restore',
            'user-revert',
            'user-import',
            'user-export',
            'product_catalog-list',
            'product_catalog-create',
            'product_catalog-edit',
            'product_catalog-delete',
            'product_catalog-restore',
            'product_catalog-revert',
            'product_catalog-import',
            'product_catalog-export',
            'product_section-list',
            'product_section-create',
            'product_section-edit',
            'product_section-delete',
            'product_section-restore',
            'product_section-revert',
            'product_section-import',
            'product_section-export',
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
            'product-restore',
            'product-revert',
            'product-import',
            'product-export',
            'bulliten-list',
            'bulliten-create',
            'bulliten-edit',
            'bulliten-delete',
            'bulliten-restore',
            'bulliten-revert',
            'bulliten-import',
            'bulliten-export',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}
