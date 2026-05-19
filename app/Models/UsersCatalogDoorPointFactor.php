<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersCatalogDoorPointFactor extends Model
{
    use SoftDeletes;
    protected $fillable = ['catalog_id', 'door_style', 'factor','user_id', 'user_catalog_visibility_id'];

    // A door point factor belongs to a catalog
    public function catalog()
    {
        return $this->belongsTo(ProductCatalog::class, 'catalog_id');
    }

    // If needed, you could associate this with a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function doorStyle()
    {
        return $this->belongsTo(DoorColors::class, 'door_style');
    }

    public function userCatalogDoorPointFactor()
    {
        return $this->belongsTo(UsersCatalogVisibility::class, 'user_catalog_visibility_id');
    }
}
