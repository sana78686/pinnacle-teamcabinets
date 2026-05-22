<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Collection;

class TenantNavBadgeService
{
    public function countsForUser(User $user): array
    {
        if (! $this->userSeesNavBadges($user)) {
            return $this->emptyCounts();
        }

        $listKeys = config('tenant_nav_badges.list_keys', []);
        $counts = array_fill_keys($listKeys, 0);

        foreach ($user->unreadNotifications()->get() as $notification) {
            $key = $notification->data['list_key'] ?? null;
            if ($key && isset($counts[$key])) {
                $counts[$key]++;
            }
        }

        $parents = config('tenant_nav_badges.parents', []);
        $parentCounts = [];
        foreach ($parents as $parent => $keys) {
            $parentCounts[$parent] = 0;
            foreach ($keys as $key) {
                $parentCounts[$parent] += $counts[$key] ?? 0;
            }
        }

        return array_merge($parentCounts, $counts);
    }

    public function markListSeen(User $user, string $listKey): void
    {
        if (! $this->userSeesNavBadges($user)) {
            return;
        }

        foreach ($user->unreadNotifications()->get() as $notification) {
            if (($notification->data['list_key'] ?? null) === $listKey) {
                $notification->markAsRead();
            }
        }
    }

    protected function userSeesNavBadges(User $user): bool
    {
        if ($user->is_super_user) {
            return true;
        }

        try {
            return $user->hasRole('Admin');
        } catch (\Throwable) {
            return false;
        }
    }

    protected function emptyCounts(): array
    {
        $out = [];
        foreach (config('tenant_nav_badges.parents', []) as $parent => $_) {
            $out[$parent] = 0;
        }
        foreach (config('tenant_nav_badges.list_keys', []) as $key) {
            $out[$key] = 0;
        }

        return $out;
    }
}
