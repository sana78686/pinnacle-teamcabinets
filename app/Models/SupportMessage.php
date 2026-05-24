<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportMessage extends Model
{
    protected $fillable = [
        'support_thread_id',
        'user_id',
        'message',
        'attachment_path',
        'attachment_name',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    public function thread(): BelongsTo
    {
        return $this->belongsTo(SupportThread::class, 'support_thread_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
