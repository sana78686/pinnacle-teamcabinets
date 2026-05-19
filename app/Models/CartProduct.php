<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;
    protected $fillable = ['cart_job_id', 'product_id', 'room_name', 'product_sku', 'quantity', 'price'];

    public function cartRoom()
    {
        return $this->belongsTo(CartJob::class, 'cart_job_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
