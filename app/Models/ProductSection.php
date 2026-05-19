<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ProductSection extends Model
{
    use HasFactory, Notifiable, SoftDeletes, BelongsToTenant;
    protected $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_section_id');
    }
}
