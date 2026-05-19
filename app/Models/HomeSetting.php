<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class HomeSetting extends Model
{
    use HasFactory, Notifiable,  BelongsToTenant;
  protected $guarded = [];
protected $connection = 'tenant';

    protected $table = 'home_settings';


}
