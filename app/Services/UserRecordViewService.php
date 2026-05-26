<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class UserRecordViewService
{
    public function markUserViewed(Model $record, ?User $user = null): void
    {
        $user ??= auth()->user();

        if (! $user || $this->userIsPanelAdmin($user)) {
            return;
        }

        if (! Schema::hasColumn($record->getTable(), 'user_viewed_at')) {
            return;
        }

        if (! empty($record->user_viewed_at)) {
            return;
        }

        $record->forceFill(['user_viewed_at' => now()])->save();
    }

    public function clearUserViewed(Model $record): void
    {
        if (! Schema::hasColumn($record->getTable(), 'user_viewed_at')) {
            return;
        }

        if (! empty($record->user_viewed_at)) {
            $record->forceFill(['user_viewed_at' => null])->save();
        }
    }

    protected function userIsPanelAdmin(User $user): bool
    {
        if ((int) ($user->is_super_user ?? 0) === 1) {
            return true;
        }

        try {
            return $user->isAdmin();
        } catch (\Throwable) {
            return false;
        }
    }
}
