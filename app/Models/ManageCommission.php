<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ManageCommission extends Model
{
    protected $fillable = [
        'user_id',
        'gross_sales',
    ];

    protected function casts(): array
    {
        return [
            'gross_sales' => 'decimal:4',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
