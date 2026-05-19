<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class DoorColors extends Model
{
    use HasFactory, Notifiable, SoftDeletes, BelongsToTenant;
    protected $fillable = [
        'tenant_id',
        'product_catalog_id',
        'product_label',
        'image',
        'status',
        
    ];

    public function productCatalog()
    {
        return $this->belongsTo(ProductCatalog::class);
    }
    public function created_by()
    {
        return $this->belongsTo(User::class);
    }
    public function updated_by()
    {
        return $this->belongsTo(User::class);
    }
}
