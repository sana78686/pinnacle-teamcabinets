<?php

namespace App\Imports;

use App\Services\TenantRoleService;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Permission\Models\Role;

class RoleImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $name = trim((string) ($row['name'] ?? ''));

        if ($name === '' || TenantRoleService::isProtectedRole($name)) {
            return null;
        }

        $existing = Role::query()
            ->where('name', $name)
            ->where('guard_name', $row['guard_name'] ?? 'web')
            ->first();

        if ($existing) {
            return null;
        }

        return new Role([
            'name' => $name,
            'guard_name' => $row['guard_name'] ?? 'web',
        ]);
    }
}
