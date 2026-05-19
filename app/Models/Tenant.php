<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Passwords\CanResetPassword; // <- this is the trait
use Stancl\Tenancy\Contracts\TenantWithDatabase;
use Stancl\Tenancy\Database\Concerns\HasDomains;
use Stancl\Tenancy\Database\Concerns\HasDatabase;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Stancl\Tenancy\Database\Models\Tenant as BaseTenant;

class Tenant extends BaseTenant implements TenantWithDatabase, CanResetPasswordContract
{
    use HasDatabase, HasDomains, SoftDeletes, Notifiable, CanResetPassword;

    protected $guarded = [];

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
        'complimentary_ends_at' => 'datetime',
        'is_complimentary' => 'boolean',
    ];

    // protected $fillable = [

    //     'id',
    //     'name',
    //     'username',
    //     'company_name',
    //     'email',
    //     'password',
    //     'domain_name',
    //     'address',
    //     'city',
    //     'state',
    //     'zip_code',
    //     'country',
    //     'phone',
    // ];
    public function getDomain(): string
    {
        return $this->domains()->first()?->domain ?? 'No Domain';
    }
    public static function getCustomColumns(): array
    {
        return [
            'id',
            'name',
            'username',
            'company_name',
            'email',
            'password',
            'domain_name',
            'address',
            'city',
            'state',
            'zip_code',
            'country',
            'phone',
            'subscription_status',
            'trial_ends_at',
            'subscription_ends_at',
            'is_complimentary',
            'complimentary_ends_at',
            'stripe_customer_id',
            'stripe_subscription_id',
        ];
    }
    public function setPasswordAttribute($value){
        return $this->attributes['password'] = Hash::make($value);
    }
    public function users(): HasMany
    {
        return $this->hasMAny(User::class);
    }
}
