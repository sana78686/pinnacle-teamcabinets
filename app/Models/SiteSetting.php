<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

// use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    use HasFactory, Notifiable, BelongsToTenant;

    protected $connection = 'tenant';

    protected $table = 'site_settings';

    protected $fillable = [
        'tenant_id',
        'logo',
        'favicon',
        'phone',
        'email',
        'contactus_phone',
        'contactus_email',
        'newuser_phone',
        'newuser_email',
        'address',
        'facebook',
        'twitter',
        'youtube',
        'instagram',
        'site_meta_title',
        'site_meta_description',
        'site_meta_keywords',
        'og_image',
        'frontend_theme',
        'contact_sidebar_title',
        'map_embed_url',
        'use_same_contact',
    ];

    protected $casts = [
        'use_same_contact' => 'boolean',
    ];

    public static function forCurrentTenant(): self
    {
        $tenantId = tenant('id');

        $settings = static::query()->where('tenant_id', $tenantId)->first();
        if ($settings) {
            return $settings;
        }

        $legacy = static::withoutGlobalScopes()
            ->where(function ($q) {
                $q->whereNull('tenant_id')->orWhere('tenant_id', '');
            })
            ->orderBy('id')
            ->first();

        if ($legacy) {
            $legacy->forceFill(['tenant_id' => $tenantId])->save();

            return $legacy;
        }

        return static::firstOrCreate(
            ['tenant_id' => $tenantId],
            ['phone' => '', 'email' => '']
        );
    }
}
