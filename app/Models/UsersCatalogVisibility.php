<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersCatalogVisibility extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'catalog_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productCatalog()
    {
        return $this->belongsTo(ProductCatalog::class, 'catalog_id');
    }
    public function userCatalogDoorPointFactors()
    {
        return $this->hasMany(UsersCatalogDoorPointFactor::class, 'user_catalog_visibility_id');
    }
}
