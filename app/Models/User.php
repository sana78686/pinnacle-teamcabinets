<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Stancl\Tenancy\Database\Concerns\TenantConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Constraint\Count;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, BelongsToTenant, TenantConnection;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'phone',
        'country_id',
        'state_id',
        'city_id',
        'zip_code',
        'is_taxable_user',
        'business_name',
        'gross_sale',
        'status',
        'name',
        'email',
        'username',
        'seperate_domain',
        'catalog_data',
        'door_factors',
        'point_factor',
        'door_point_factor',
        'catalog_visibility',
        'accept_terms',
        'company_name',
        'tenant_id',
        'password',
        'is_super_user',
        'county_name',
        'city_name',
        'parent_id',
        'logo',
        'otp_code',
        'otp_expires_at',
        'otp_attempts',
        'is_verified',
        'status',
        'is_verified_by_admin',
        'address',
        'note',
        'login_version',
    ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'admin_viewed_at' => 'datetime',
            'password' => 'hashed',
            'point_factor' => 'decimal:4',
            'door_point_factor' => 'array',
            'catalog_visibility' => 'array',
            'login_version' => 'integer',
        ];
    }
    public function getInitialsAttribute()
    {
        $nameParts = explode(' ', $this->name);
        $initials = '';
        $hash = md5($this->name);

        $backgroundColor = '#' . substr($hash, 0, 6); // Get a unique color

        foreach ($nameParts as $part) {
            $initials .= strtoupper(substr($part, 0, 1));
        }

        return substr($initials, 0, 2); // Get up to 2 initials
    }
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function doorFactors()
    {
        return $this->hasMany(UsersCatalogDoorPointFactor::class);
    }
    public function catalogVisibilities()
    {
        return $this->hasMany(UsersCatalogVisibility::class, 'user_id'); // Assuming you have a UserCatalogVisibility model
    }
    public function doorFactorValue($catalogId, $doorColorId)
    {
        $doorFactor = $this->doorFactors()->where('catalog_id', $catalogId)
                                        ->first();

        return $doorFactor ? $doorFactor->factor : null;
    }
    public function restoreDeletedUser($id)
    {
        // Find the user in the trashed records
        $user = User::onlyTrashed()->findOrFail($id);

        if (!$user) {
            session()->flash('error', 'User cannot be found.');
            return redirect()->back();
        }

        // Restore the user
        $user->restore();

        // Manually update the status to 'un-approval' after restoring
        $user->status = config('tenant_user.default_status', 'un-approved');
        $user->save();  // Save the updated status

        // Return success message
        return redirect()->route('tenant_deleted_users_list')
            ->with('success', 'User ' . $user->name . ' restored successfully and status set to un-approval.');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function county()
    {
        return $this->belongsTo(County::class);
    }

    // protected static function booted()
    // {
    //     static::creating(function ($model) {
    //         if (!auth()->user() || !auth()->user()->isSuperAdmin()) {
    //             $model->tenant_id = tenant()->id; // Only set tenant_id for normal users
    //         }
    //     });

    //     static::addGlobalScope('tenant', function (Builder $builder) {
    //         if (!auth()->check() || !auth()->user()->isSuperAdmin()) {
    //             $builder->where('tenant_id', tenant()->id); // Normal users only see their tenant data
    //         }
    //     });
    // }

    // public function isSuperAdmin()
    // {
    //     return $this->tenant_id === null; // Super Admins have tenant_id = NULL
    // }
    public function children()
    {
        return $this->hasMany(User::class, 'parent_id');
    }
    public function grandchildren()
    {
        return $this->hasManyThrough(User::class, User::class, 'parent_id', 'parent_id');
    }
}
