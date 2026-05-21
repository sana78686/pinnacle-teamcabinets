<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class TenantQuickBooksSetting extends Model
{
    use BelongsToTenant;

    protected $table = 'tenant_quickbooks_settings';

    protected $fillable = [
        'tenant_id',
        'client_id',
        'client_secret',
        'redirect_uri',
        'qb_environment',
        'realm_id',
        'access_token',
        'refresh_token',
        'token_expires_at',
        'environment',
        'connected_at',
    ];

    protected $casts = [
        'client_secret' => 'encrypted',
        'access_token' => 'encrypted',
        'refresh_token' => 'encrypted',
        'token_expires_at' => 'datetime',
        'connected_at' => 'datetime',
    ];

    protected $hidden = ['client_secret', 'access_token', 'refresh_token'];

    public function hasApiCredentials(): bool
    {
        return filled($this->client_id) && filled($this->client_secret) && filled($this->redirect_uri);
    }

    public function isConnected(): bool
    {
        return $this->connected_at !== null
            && $this->realm_id
            && $this->access_token;
    }
}
