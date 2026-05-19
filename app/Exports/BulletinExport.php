<?php

namespace App\Exports;

use App\Models\Bulletin;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BulletinExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * Define headings for the export file
     */
    public function headings(): array
    {
        return [
            'ID',
            'user_option',
            'bulletin_title',
            'bulletin_description',
            'image',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Query data to be exported
     */
    public function query()
    {
        return Bulletin::query();
    }

    /**
     * Format each row for export
     */
    public function map($bulletin): array
    {
        return [
            $bulletin->id,
            $bulletin->user_option,
            $bulletin->bulletin_title,
            $bulletin->bulletin_description,
            $bulletin->image,
            $bulletin->created_at->format('Y-m-d H:i:s'), // Format date
            $bulletin->updated_at->format('Y-m-d H:i:s'), // Format date
        ];
    }

    public function collection()
    {
        return Bulletin::select('id', 'user_option', 'bulletin_title','bulletin_description','image'  )->get(); // Export specific columns
    }
}
