<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class PointFactorDefault extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'user_type',
        'point_factor_percentage',
    ];

    protected $casts = [
        'point_factor_percentage' => 'decimal:4',
    ];
}
