<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ContactQuery extends Model
{
    use BelongsToTenant;

    protected $guarded = [];

    protected $casts = [
        'admin_viewed_at' => 'datetime',
    ];
}
