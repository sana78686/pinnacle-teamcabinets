<?php

namespace App\Exports;

use App\Models\Product;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductExport implements FromQuery, WithHeadings, WithMapping
{
    /**
     * Define headings for the export file
     */
    public function headings(): array
    {
        return [
            'ID',
            'Label',
            'SKU',
            'Weight',
            'Cost',
            'Asseble_cost',
            'QTY',
            'Image',
            'Description',
            'Manufacture Date',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Query data to be exported
     */
    public function query()
    {
        return Product::query();
    }

    /**
     * Format each row for export
     */
    public function map($product): array
    {
        return [
            $product->id,
            $product->label,
            $product->sku,
            $product->weight,
            $product->cost,
            $product->assemble_cost,
            $product->image,
            $product->description,
            $product->manufacture_date,
            $product->created_at->format('Y-m-d H:i:s'), // Format date
            $product->updated_at->format('Y-m-d H:i:s'), // Format date
        ];
    }

    public function collection()
    {
        return Product::select('id', 'label', 'sku','weight', 'cost', 'assemble_cost', 'image', 'description','manufacture_date' )->get(); // Export specific columns
    }
}
