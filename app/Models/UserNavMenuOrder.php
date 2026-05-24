<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserNavMenuOrder extends Model
{
    protected $fillable = [
        'user_id',
        'menu_order',
    ];

    protected function casts(): array
    {
        return [
            'menu_order' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
