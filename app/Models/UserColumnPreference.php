<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserColumnPreference extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'module', 'columns'];

    protected $casts = [
        'columns' => 'array', // Automatically cast JSON to array
    ];
}
