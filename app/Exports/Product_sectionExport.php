<?php

namespace App\Exports;
use App\Models\ProductSection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Product_sectionExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * Define headings for the export file
     */
    public function headings(): array
    {
        return [
            'ID',
            'cabinets_name',
            'assemble_price',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Query data to be exported
     */
    public function query()
    {
        return productSection::query();
    }

    /**
     * Format each row for export
     */
    public function map($productsection): array
    {
        return [
            $productsection->id,
            $productsection->cabinets_name,
            $productsection->assemble_price,
            $productsection->created_at->format('Y-m-d H:i:s'), // Format date
            $productsection->updated_at->format('Y-m-d H:i:s'), // Format date
        ];
    }

    public function collection()
    {
        return ProductSection::select('id', 'cabinets_name', 'assemble_price' )->get(); // Export specific columns
    }
}
