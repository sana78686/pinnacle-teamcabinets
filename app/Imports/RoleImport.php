<?php
namespace App\Imports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnFailure;

class RoleImport implements ToModel, WithHeadingRow
{



    public function model(array $row)
    {
        return new Role([
            'name' => $row['name'],
            'guard_name' => $row['guard_name'],
        ]);
    }






    // Handle failed imports


    // Retrieve the failed imports
    public function getFailedImports()
    {
        return $this->getFailedImports();
    }
}

