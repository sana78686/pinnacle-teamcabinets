<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * Define headings for the export file
     */
    public function headings(): array
    {
        return [

            'Username',
            'Roles',
            'Name',
            'Email',
            'Address',
            'Country',
            'State',
            'City',
            'County',
            'Zip Code',

        ];
    }
    /**
     * Query data to be exported
     */
    public function query()
    {
        return User::query();
    }
    /**
     * Format each row for export
     */
    public function map($user): array
    {
        return [

            $user->username,
            $user->roles()->pluck('name')->implode(', '),
            $user->name,
            $user->email,
            $user->address,
            optional($user->country)->name,
            optional($user->state)->name,
            $user->city_name,
            $user->county_name,
            $user->zip_code,

        ];
    }

    public function collection()
    {
        return User::select('id', 'name', 'email')->get(); // Export specific columns
    }
}
