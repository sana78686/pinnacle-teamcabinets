<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class HomeSetting extends Model
{
    use HasFactory, Notifiable, BelongsToTenant;

    protected $guarded = [];

    protected $connection = 'tenant';

    protected $table = 'home_settings';

    protected $casts = [
        'faqs' => 'array',
    ];

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
