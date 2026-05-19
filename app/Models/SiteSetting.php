<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory, Notifiable,  BelongsToTenant;

    protected $guarded = [];
protected $connection = 'tenant';

    protected $table = 'site_settings';

    // protected $fillable = [
    //     'logo',
    //     'phone',
    //     'email',
    //     'facebook',
    //     'twitter',
    //     'youtube',
    //     'instagram',
    // ];
}
