<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class CartData extends Model
{
    use BelongsToTenant;

    protected $connection = 'tenant';

    protected $table = 'cart_data';

    protected $fillable = [
        'tenant_id',
        'user_id',
        'product_catalog_id',
        'product_img_src',
        'product_img_name',
        'product_description_val',
        'room_data',
        'added_product_ids',
        'cart_product_weight',
        'all_cart_total',
        'job_name',
        'order_comment',
        'affiliate_id',
        'is_assemble',
    ];

    protected function casts(): array
    {
        return [
            'room_data' => 'array',
            'all_cart_total' => 'decimal:2',
            'is_assemble' => 'integer',
        ];
    }
}
