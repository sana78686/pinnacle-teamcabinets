<?php
namespace App\Imports;

use App\Models\ProductCatalog;
use App\Models\ProductSection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnFailure;

class Productcatalog_Import implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new ProductCatalog([
            'name' => $row['name'],
            'image' => $row['image'],
            'pdf' => $row['pdf'],
        ]);
    }


    // Retrieve the failed imports
    public function getFailedImports()
    {
        return $this->getFailedImports();
    }
}


