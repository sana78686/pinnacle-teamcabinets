<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromQuery, WithHeadings, WithMapping
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
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Query data to be exported
     */
    public function query()
    {
        return Order::query();
    }

    /**
     * Format each row for export
     */
    public function map($order): array
    {
        return [
            $order->id,
            $order->label,
            $order->sku,

            $order->created_at->format('Y-m-d H:i:s'), // Format date
            $order->updated_at->format('Y-m-d H:i:s'), // Format date
        ];
    }

    public function collection()
    {
        return Order::select('id', 'label', 'sku','weight',  )->get(); // Export specific columns
    }
}
