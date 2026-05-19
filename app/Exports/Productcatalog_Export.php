<?php

namespace App\Exports;

use App\Models\ProductCatalog;
use App\Models\ProductSection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Productcatalog_Export implements FromQuery, WithHeadings, WithMapping
{
    /**
     * Define headings for the export file
     */
    public function headings(): array
    {
        return [
            'ID',
            'name',
            'image',
            'pdf',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Query data to be exported
     */
    public function query()
    {
        return ProductCatalog::query();
    }

    /**
     * Format each row for export
     */
    public function map($productcatalog): array
    {

        return [
            $productcatalog->id,
            $productcatalog->name,
            $productcatalog->image,
            $productcatalog->pdf,
            $productcatalog->created_at->format('Y-m-d H:i:s'), // Format date
            $productcatalog->updated_at->format('Y-m-d H:i:s'), // Format date
        ];

    }

    public function collection()
    {
        return ProductCatalog::select('id', 'name', 'image', 'pdf' )->get(); // Export specific columns
    }
}
