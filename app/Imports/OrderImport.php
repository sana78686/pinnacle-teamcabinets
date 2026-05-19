<?php
namespace App\Imports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnFailure;

class OrderImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new Order([
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


