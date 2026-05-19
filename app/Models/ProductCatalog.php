<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ProductCatalog extends Model
{

    use HasFactory, Notifiable, SoftDeletes,BelongsToTenant;
    protected $guarded = [];

    public function doorColors()
    {
        return $this->hasMany(DoorColors::class);
    }
    public function userCatalogDoorPointFactor()
    {
        return $this->hasMany(UsersCatalogDoorPointFactor::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'product_catalog_id');
    }
}
