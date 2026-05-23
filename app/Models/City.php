<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class City extends Model
{
    use  Notifiable;
    protected $guarded = [];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function scopeForCountry($query, $countryId)
    {
        return $query->whereHas('state', function ($q) use ($countryId) {
            $q->where('country_id', $countryId);
        });
    }
}
