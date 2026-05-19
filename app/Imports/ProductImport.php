<?php
namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnFailure;

class ProductImport implements ToModel, WithHeadingRow
{



    public function model(array $row)
    {
        return new Product([
            'label' => $row['label'],
            'sku' => $row['sku'],
            'weight' => $row['weight'],
            'cost' => $row['cost'],
            'assemble_cost' => $row['assemble_cost'],
            'image' => $row['image'],
            // 'manufacture_date' => $row['manufacture_date'],
            'description' => $row['description'],
        ]);
    }






    // Handle failed imports


    // Retrieve the failed imports
    public function getFailedImports()
    {
        return $this->getFailedImports();
    }
}

