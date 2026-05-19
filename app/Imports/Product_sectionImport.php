<?php
namespace App\Imports;

use App\Models\ProductSection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnFailure;

class Product_sectionImport implements ToModel, WithHeadingRow
{



    public function model(array $row)
    {
        return new ProductSection([
            'cabinets_name' => $row['cabinets_name'],
            'assemble_price' => $row['assemble_price'],
        ]);
    }


    // Retrieve the failed imports
    public function getFailedImports()
    {
        return $this->getFailedImports();
    }
}


