<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Bulletin extends Model
{
    use HasFactory, Notifiable, SoftDeletes, BelongsToTenant;

    protected $guarded = [];

    public function scopeVisibleToUser(Builder $query, User $user): Builder
    {
        $role = $user->getRoleNames()->first();

        return $query->where(function (Builder $q) use ($role) {
            $q->where('user_option', 'every_one')
                ->orWhere(function (Builder $inner) use ($role) {
                    $inner->where('user_option', 'specific_user')
                        ->where(function (Builder $roleQuery) use ($role) {
                            $roleQuery->whereNull('target_role')
                                ->orWhere('target_role', '')
                                ->orWhere('target_role', $role);
                        });
                });
        });
    }

    public function attachmentUrl(): ?string
    {
        if (empty($this->image)) {
            return null;
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset(ltrim($this->image, '/'));
    }

    public function attachmentExtension(): string
    {
        return strtolower(pathinfo((string) $this->image, PATHINFO_EXTENSION));
    }

    public function isImageAttachment(): bool
    {
        return in_array($this->attachmentExtension(), ['jpg', 'jpeg', 'png', 'gif', 'webp'], true);
    }

    public function isPdfAttachment(): bool
    {
        return $this->attachmentExtension() === 'pdf';
    }
}
