<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class HierarchyService
{
    public function getRepresentatives(): Collection
    {
        return $this->usersByCiType('representatives')->orderBy('name')->get();
    }

    public function getAdmin(): ?User
    {
        return User::query()
            ->where(function ($q) {
                $q->where('user_type', 'admin')
                    ->orWhereHas('roles', fn ($r) => $r->where('name', 'admin'));
            })
            ->orderBy('id')
            ->first();
    }

    public function getRepsConnectedToAdmin(): Collection
    {
        $admin = $this->getAdmin();
        if (! $admin) {
            return new Collection;
        }

        return $this->usersByCiType('representatives')
            ->where('parent_id', $admin->id)
            ->orderBy('name')
            ->get();
    }

    /**
     * @return array<int, array{id: int, name: string}>
     */
    public function getUnderRep(int $repId, string $type): array
    {
        return $this->usersByCiType($type)
            ->where('parent_id', $repId)
            ->orderBy('name')
            ->get()
            ->map(fn (User $u) => $this->userSummary($u))
            ->values()
            ->all();
    }

    /**
     * @return array<int, array{id: int, name: string}>
     */
    public function getAffiliatesUnder(int $parentId): array
    {
        return User::query()
            ->where(function ($q) {
                $q->whereIn('user_type', ['affiliate', 'sub-affiliate'])
                    ->orWhereHas('roles', fn ($r) => $r->whereIn('name', ['affiliate', 'sub-affiliate', 'Affiliate', 'Sub-Affiliate']));
            })
            ->where('parent_id', $parentId)
            ->orderBy('name')
            ->get()
            ->map(fn (User $u) => $this->userSummary($u))
            ->values()
            ->all();
    }

    /**
     * Dealers whose parent is a showroom (CI dealer ↔ showroom panel).
     *
     * @return array<int, array{dealer: string, showroom: string, dealer_id: int, showroom_id: int}>
     */
    public function getDealerShowroomConnections(): array
    {
        $rows = [];
        $dealers = $this->usersByCiType('dealers')
            ->whereNotNull('parent_id')
            ->where('parent_id', '>', 0)
            ->with('parent')
            ->get();

        foreach ($dealers as $dealer) {
            $parent = $dealer->parent;
            if (! $parent || $parent->getCiRole() !== 'showrooms') {
                continue;
            }
            $rows[] = [
                'dealer_id' => $dealer->id,
                'showroom_id' => $parent->id,
                'dealer' => $this->displayName($dealer),
                'showroom' => $this->displayName($parent),
                'affiliates' => $this->getAffiliatesUnder($dealer->id),
            ];
        }

        return $rows;
    }

    /**
     * @return array{
     *     rep_show_data: array<string, array<string, array<int, array{id: int, name: string}>>>,
     *     rep_dealer_data: array<string, array<string, array<int, array{id: int, name: string}>>>,
     *     rep_distri_data: array<string, array<string, array<int, array{id: int, name: string}>>>,
     *     dealer_showroom_data: array<int, array<string, mixed>>
     * }
     */
    public function buildHierarchyTree(): array
    {
        $reps = $this->getRepsConnectedToAdmin();
        $conShow = [];
        $conDealer = [];
        $conDistri = [];

        foreach ($reps as $rep) {
            $repName = $this->displayName($rep);

            foreach ($this->getUnderRep($rep->id, 'showrooms') as $show) {
                $conShow[$repName][$show['name']] = $this->getAffiliatesUnder($show['id']);
            }

            foreach ($this->getUnderRep($rep->id, 'dealers') as $dealer) {
                $conDealer[$repName][$dealer['name']] = $this->getAffiliatesUnder($dealer['id']);
            }

            foreach ($this->getUnderRep($rep->id, 'distributors') as $distri) {
                $conDistri[$repName][$distri['name']] = $this->getAffiliatesUnder($distri['id']);
            }
        }

        return [
            'rep_show_data' => $conShow,
            'rep_dealer_data' => $conDealer,
            'rep_distri_data' => $conDistri,
            'dealer_showroom_data' => $this->getDealerShowroomConnections(),
        ];
    }

    public function connectUserToParent(int $userId, int $parentId): void
    {
        User::query()->whereKey($userId)->update(['parent_id' => $parentId]);
    }

    public function disconnectUser(int $userId): void
    {
        User::query()->whereKey($userId)->update(['parent_id' => null]);
    }

    /**
     * @return array<int, array{id: int, name: string, user_type: string, parent_id: int|null}>
     */
    public function allHierarchyUsers(): array
    {
        $types = ['representatives', 'showrooms', 'dealers', 'distributors', 'affiliate', 'sub-affiliate'];

        return User::query()
            ->where(function ($q) use ($types) {
                $q->whereIn('user_type', $types)
                    ->orWhereHas('roles', fn ($r) => $r->whereIn('name', array_merge(
                        $types,
                        ['Representative', 'Showroom', 'Dealer', 'Distributor', 'Affiliate', 'Sub-Affiliate']
                    )));
            })
            ->orderBy('name')
            ->get(['id', 'name', 'username', 'user_type', 'parent_id'])
            ->map(fn (User $u) => [
                'id' => $u->id,
                'name' => $this->displayName($u),
                'user_type' => $u->getCiRole() ?: (string) $u->user_type,
                'parent_id' => $u->parent_id ? (int) $u->parent_id : null,
            ])
            ->values()
            ->all();
    }

    protected function usersByCiType(string $ciType): Builder
    {
        $names = [$ciType];
        foreach (TenantRoleService::LEGACY_TO_CI as $legacy => $normalized) {
            if ($normalized === $ciType) {
                $names[] = $legacy;
            }
        }
        $names = array_values(array_unique($names));

        return User::query()->where(function ($q) use ($names) {
            $q->whereIn('user_type', $names)
                ->orWhereHas('roles', fn ($r) => $r->whereIn('name', $names));
        });
    }

    /**
     * @return array{id: int, name: string}
     */
    protected function userSummary(User $user): array
    {
        return [
            'id' => $user->id,
            'name' => $this->displayName($user),
        ];
    }

    protected function displayName(User $user): string
    {
        $name = trim((string) ($user->name ?? ''));
        if ($name !== '') {
            return $name;
        }

        return (string) ($user->username ?? 'User #'.$user->id);
    }
}
