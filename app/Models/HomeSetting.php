<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class HomeSetting extends Model
{
    use HasFactory, Notifiable, BelongsToTenant;

    protected $connection = 'tenant';

    protected $table = 'home_settings';

    protected $fillable = [
        'tenant_id',
        'banner_image',
        'benner_title',
        'benner_description',
        'aboutus_image',
        'aboutus_title',
        'aboutus_description',
        'card_one_title',
        'card_one_description',
        'card_two_title',
        'card_two_description',
        'card_three_title',
        'card_three_description',
        'faqs',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'modern_hero_video',
        'modern_hero_poster',
        'modern_factory_video',
        'modern_factory_poster',
        'modern_slideshow_interval_ms',
    ];

    protected $casts = [
        'faqs' => 'array',
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

        return static::firstOrCreate(['tenant_id' => $tenantId], []);
    }

    /** @return array<int, array{q: string, a: string}> */
    public function resolvedFaqs(): array
    {
        $items = $this->faqs ?? [];
        if (is_string($items)) {
            $items = json_decode($items, true) ?: [];
        }

        $normalized = [];
        foreach ($items as $item) {
            if (! is_array($item)) {
                continue;
            }
            $q = trim((string) ($item['q'] ?? $item['question'] ?? ''));
            $a = trim((string) ($item['a'] ?? $item['answer'] ?? ''));
            if ($q !== '' && $a !== '') {
                $normalized[] = ['q' => $q, 'a' => $a];
            }
        }

        if ($this->faqs !== null) {
            return $normalized;
        }

        return config('tenant_hazel_home.faqs', []);
    }
}
