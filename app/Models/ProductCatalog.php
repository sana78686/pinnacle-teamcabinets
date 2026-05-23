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

    public function getImageUrlAttribute(): ?string
    {
        return self::publicAssetUrl($this->image);
    }

    public function getPdfUrlAttribute(): ?string
    {
        return self::publicAssetUrl($this->pdf);
    }

    /** Resolve DB path (public/…, uploads/…, or storage) to a browser URL. */
    public static function publicAssetUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $path = ltrim($path, '/');

        if (str_starts_with($path, 'public/')) {
            return asset('storage/' . substr($path, 7));
        }

        return asset($path);
    }
}
