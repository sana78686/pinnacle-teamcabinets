<?php
namespace App\Imports;

use App\Models\Bulletin;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnFailure;

class BulletinImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        return new Bulletin([
            'user_option' => $row['user_option'],
            'bulletin_title' => $row['bulletin_title'],
            'bulletin_description' => $row['bulletin_description'],
            // 'image' => $row['image'],
        ]);
    }


    // Retrieve the failed imports
    public function getFailedImports()
    {
        return $this->getFailedImports();
    }
}


