<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManageDocument extends Model
{
    public $timestamps = false;

    protected $table = 'manage_document';

    protected $fillable = [
        'user_type',
        'document_name',
    ];
}
