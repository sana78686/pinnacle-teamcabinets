<?php

namespace App\Services;

use App\Models\Bulletin;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TenantRoleDashboardService
{
    /**
     * @return array<string, mixed>
     */
    public function dashboardData(User $user, ?int $bulletinId = null): array
    {
        $user->loadMissing(['country', 'state', 'city']);

        $bulletins = $this->visibleBulletins($user);
        $featured = $this->resolveFeaturedBulletin($bulletins, $bulletinId);

        return [
            'account' => $this->accountCard($user),
            'childUsers' => $this->childUsers($user),
            'usersCardTitle' => $this->usersCardTitle($user),
            'addUserLabel' => $this->addUserLabel($user),
            'showAddUser' => $this->showAddUserButton($user),
            'pastBulletins' => $bulletins,
            'featuredBulletin' => $featured,
        ];
    }

    /** @return Collection<int, Bulletin> */
    public function visibleBulletins(User $user): Collection
    {
        return Bulletin::query()
            ->visibleToUser($user)
            ->latest('id')
            ->get()
            ->filter(fn (Bulletin $bulletin) => $bulletin->isVisibleToUser($user))
            ->values();
    }

    /**
     * @param  Collection<int, Bulletin>  $bulletins
     */
    protected function resolveFeaturedBulletin(Collection $bulletins, ?int $bulletinId): ?Bulletin
    {
        if ($bulletinId) {
            $selected = $bulletins->firstWhere('id', $bulletinId);
            if ($selected) {
                return $selected;
            }
        }

        return $bulletins->first();
    }

    /** @return array<string, string|null> */
    protected function accountCard(User $user): array
    {
        return [
            'account_number' => (string) $user->id,
            'name' => tenant_panel_display_name($user),
            'address' => $user->address,
            'state' => $user->state?->name ?? null,
            'city' => $user->city_name ?: $user->city?->name,
            'zipcode' => $user->zip_code,
            'phone' => $user->phone,
            'email' => $user->email,
        ];
    }

    /** @return Collection<int, User> */
    protected function childUsers(User $user): Collection
    {
        return User::query()
            ->where('parent_id', $user->id)
            ->orderBy('name')
            ->limit(100)
            ->get(['id', 'name', 'username', 'email']);
    }

    protected function usersCardTitle(User $user): string
    {
        if ($user->hasRole('Representative')) {
            return 'My Users';
        }

        return tenant_user_is_affiliate_panel($user) ? 'My Affiliates' : 'My Users';
    }

    protected function addUserLabel(User $user): string
    {
        return $user->hasRole('Representative') ? 'Add User' : 'Add Affiliate';
    }

    protected function showAddUserButton(User $user): bool
    {
        if (tenant_user_is_affiliate_panel($user)) {
            return false;
        }

        try {
            return ! $user->hasAnyRole(['Customer']);
        } catch (\Throwable) {
            return true;
        }
    }
}
