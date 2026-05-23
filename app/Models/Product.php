<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Product extends Model
{

    use HasFactory, Notifiable, SoftDeletes, BelongsToTenant;
    protected $guarded = [];

    protected $connection = 'tenant';

    public function productCategory()
    {
        return $this->belongsTo(ProductSection::class, 'product_section_id');
    }
    public function productCatalog()
    {
        return $this->belongsTo(ProductCatalog::class, 'product_catalog_id');
    }
    public function doorColor()
    {
        return $this->belongsTo(DoorColors::class, 'door_color_id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return ProductCatalog::publicAssetUrl($this->image);
    }
}
