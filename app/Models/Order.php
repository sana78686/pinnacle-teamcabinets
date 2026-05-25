<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Order extends Model
{

    use HasFactory, SoftDeletes, BelongsToTenant;

    // protected $fillable = ['job_name', 'rooms', 'comment', 'assemble_cabinets_check', 'shipping_status'];
    protected $guarded = [];

    protected $casts = [
        'rooms' => 'array',
        'admin_viewed_at' => 'datetime',
        'mfg_comm' => 'decimal:4',
        'rep_comm' => 'decimal:4',
        'aff_comm' => 'decimal:4',
        'sub_aff_commission' => 'decimal:4',
        'state' => 'integer',
        'is_picked' => 'boolean',
        'picked_at' => 'datetime',
    ];

    public function scopeActiveCommission($query)
    {
        return $query->where('state', 1);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
