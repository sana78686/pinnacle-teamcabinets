<?php

namespace App\Models;

use App\Support\BulletinAudience;
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
        $roleKeys = BulletinAudience::roleKeysForUser($user);

        return $query->where(function (Builder $q) use ($roleKeys) {
            $q->where('user_option', 'every_one')
                ->orWhere(function (Builder $inner) use ($roleKeys) {
                    $inner->where('user_option', 'specific_user')
                        ->where(function (Builder $roleQuery) use ($roleKeys) {
                            $roleQuery->whereNull('target_role')
                                ->orWhere('target_role', '');

                            if ($roleKeys !== []) {
                                $roleQuery->orWhereIn('target_role', $roleKeys);
                            }
                        });
                });
        });
    }

    public function isVisibleToUser(User $user): bool
    {
        if ($this->user_option === 'every_one') {
            return true;
        }

        if ($this->user_option !== 'specific_user') {
            return false;
        }

        return BulletinAudience::targetMatchesUser($this->target_role, $user);
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
