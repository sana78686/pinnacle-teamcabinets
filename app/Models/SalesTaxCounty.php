<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesTaxCounty extends Model
{
    public $timestamps = false;

    protected $table = 'sales_tax_counties';

    protected $fillable = ['counties', 'state_id', 'tax'];
}
