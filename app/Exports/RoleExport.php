<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Spatie\Permission\Models\Role as ModelsRole;

class RoleExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * Define headings for the export file
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Guard_name',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Query data to be exported
     */
    public function query()
    {
        return Role::query();
    }

    /**
     * Format each row for export
     */
    public function map($role): array
    {
        return [
            $role->id,
            $role->name,
            $role->guard_name,
            $role->created_at->format('Y-m-d H:i:s'), // Format date
            $role->updated_at->format('Y-m-d H:i:s'), // Format date
        ];
    }

    public function collection()
    {
        return Role::select('id', 'name', 'guard_name' )->get(); // Export specific columns
    }
}
