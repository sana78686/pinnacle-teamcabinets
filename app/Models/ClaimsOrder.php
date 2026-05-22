<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ClaimsOrder extends Model
{
    use BelongsToTenant, SoftDeletes;

    protected $table = 'claims_order';

    protected $guarded = [];

    protected $casts = [
        'is_viewed' => 'boolean',
        'admin_viewed_at' => 'datetime',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getClaimsProductValAttribute(mixed $value): array
    {
        if (is_array($value)) {
            return $value;
        }

        if (is_string($value) && $value !== '') {
            $decoded = json_decode($value, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }

    /**
     * @param  array<int, array<string, mixed>>|string|null  $value
     */
    public function setClaimsProductValAttribute(mixed $value): void
    {
        $this->attributes['claims_product_val'] = is_array($value)
            ? json_encode($value)
            : (string) $value;
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'claims_order_id');
    }

    public function claimant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'claims_order_user_id');
    }
}
