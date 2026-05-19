<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Quote extends Model
{

    use HasFactory, SoftDeletes, BelongsToTenant;

    // protected $fillable = ['job_name', 'rooms', 'comment', 'assemble_cabinets_check', 'shipping_status'];
    protected $guarded = [];

    protected $casts = [
        'rooms' => 'array', // JSON format for rooms and products
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
