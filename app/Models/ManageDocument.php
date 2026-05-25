<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManageDocument extends Model
{
    use SoftDeletes;

    protected $table = 'manage_document';

    protected $fillable = [
        'user_type',
        'document_name',
        'status',
    ];

    protected $casts = [
        'deleted_at' => 'datetime',
    ];
}
