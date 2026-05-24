<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class StockCheckRequest extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    // protected $fillable = ['job_name', 'rooms', 'comment', 'assemble_cabinets_check', 'shipping_status'];
    protected $guarded = [];

    protected $casts = [
        'rooms' => 'array',
        'original_rooms' => 'array',
        'admin_viewed_at' => 'datetime',
        'completion_date' => 'datetime',
        'is_approved' => 'boolean',
    ];

    public function billToName(): string
    {
        return (string) ($this->bill_to_name ?: $this->user?->name ?: '—');
    }

    public function isApproved(): bool
    {
        if ($this->is_approved !== null) {
            return (bool) $this->is_approved;
        }

        return filled($this->completion_date);
    }

    /** @return array<int, mixed> */
    public function normalizedOriginalRooms(): array
    {
        $rooms = $this->original_rooms;

        if (is_array($rooms) && $rooms !== []) {
            return $rooms;
        }

        return $this->normalizedRooms();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /** @return array<int, mixed> */
    public function normalizedRooms(): array
    {
        $rooms = $this->rooms;

        if (is_array($rooms)) {
            return $rooms;
        }

        if (is_string($rooms) && $rooms !== '') {
            $decoded = json_decode($rooms, true);

            return is_array($decoded) ? $decoded : [];
        }

        return [];
    }
}
