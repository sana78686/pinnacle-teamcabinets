<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManageInventory extends Model
{
    protected $fillable = [
        'product_name',
        'sku',
        'quantity',
        'status',
    ];

    protected $casts = [
        'quantity' => 'integer',
    ];
}
