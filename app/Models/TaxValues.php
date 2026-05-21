<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class TaxValues extends Model
{
    use HasFactory, BelongsToTenant;

    protected $table = 'tax_values';

    protected $fillable = [
                        'tenant_id',
                        'option_key',
                        'option_value',
                        'field_label',
                        'created_by',
                        'updated_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
