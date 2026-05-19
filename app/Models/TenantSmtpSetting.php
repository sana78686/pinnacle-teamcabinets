<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class TenantSmtpSetting extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'smtp_host',
        'smtp_port',
        'smtp_encryption',
        'smtp_username',
        'smtp_password',
        'from_email',
        'from_name',
        'is_verified',
        'verified_at',
    ];

    protected $casts = [
        'smtp_password' => 'encrypted',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
        'smtp_port' => 'integer',
    ];

    protected $hidden = ['smtp_password'];
}
