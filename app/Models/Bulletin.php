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
        $userType = BulletinAudience::primaryUserTypeKey($user);

        return $query->where(function (Builder $q) use ($userType) {
            $q->where('user_option', 'every_one');

            if ($userType === '') {
                return;
            }

            $q->orWhere(function (Builder $inner) use ($userType) {
                $inner->where('user_option', 'specific_user')
                    ->where(function (Builder $roleQuery) use ($userType) {
                        $roleQuery->whereNull('target_role')
                            ->orWhere('target_role', '')
                            ->orWhere('target_role', $userType);

                        $expanded = BulletinAudience::expandTargetRoleKeys($userType);
                        if ($expanded !== []) {
                            $roleQuery->orWhereIn('target_role', $expanded);
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

        return tenant_media_url($this->image);
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
