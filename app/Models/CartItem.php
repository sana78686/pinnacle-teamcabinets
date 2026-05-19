<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_name',
        'room_name',
        'product_label',
        'sku',
        'description',
        'quantity',
        'unit_price',
        'total_price',
        'weight'
    ];
}
