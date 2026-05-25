<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AdminRecordViewService
{
    public function adminSeesHighlights(?User $user): bool
    {
        if (! $user) {
            return false;
        }

        if ($user->is_super_user) {
            return true;
        }

        try {
            return $user->isAdmin();
        } catch (\Throwable) {
            return false;
        }
    }

    public function isUnviewed(Model $record, ?User $user = null): bool
    {
        $user ??= auth()->user();

        if (! $this->adminSeesHighlights($user)) {
            return false;
        }

        return empty($record->admin_viewed_at);
    }

    public function markViewed(Model $record, ?User $user = null): void
    {
        $user ??= auth()->user();

        if (! $this->adminSeesHighlights($user)) {
            return;
        }

        if (! empty($record->admin_viewed_at)) {
            return;
        }

        $record->forceFill(['admin_viewed_at' => now()])->save();

        app(TenantNavBadgeService::class)->markRecordSeen($user, $record);
    }
}
