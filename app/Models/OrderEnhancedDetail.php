<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class OrderEnhancedDetail extends Model
{
    use BelongsToTenant;

    protected $table = 'order_enhanced_details';

    protected $guarded = [];

    protected $casts = [
        'stock_check_status' => 'integer',
        'state' => 'integer',
    ];
}
