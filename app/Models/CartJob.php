<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class CartJob extends Model
{
    use HasFactory, BelongsToTenant;
    protected $fillable = ['user_id', 'job_name', 'room_name'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cartRooms()
    {
        return $this->hasMany(CartJob::class, 'cart_job_id');
    }
}

