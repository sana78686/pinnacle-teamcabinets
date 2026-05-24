<?php

namespace App\Services;

use App\Models\User;

class CommissionCalculationService
{
    /**
     * Calculate all commission fields for an order at checkout.
     *
     * @return array{mfgComm: float, repComm: float, affComm: float, subAffComm: float, repId: ?int, parentId: int|string|null}
     */
    public function calculate(float $cartTotal, User $user): array
    {
        $user->loadMissing('roles');

        $admin = User::query()
            ->whereHas('roles', fn ($q) => $q->whereIn('name', ['Admin', 'admin', 'Super Admin']))
            ->first();
        $adminFactor = $admin ? (float) ($admin->point_factor ?? 0) : 0.0;
        $mfgComm = $cartTotal * $adminFactor;

        $userFactor = (float) ($user->point_factor ?? 0);
        $repComm = 0.0;
        $affComm = 0.0;
        $subAffComm = 0.0;
        $repId = null;
        $parentId = $user->parent_id;

        if ($this->isRepresentative($user)) {
            $repComm = $cartTotal * $userFactor;
        } elseif (! $user->parent_id || (string) $user->parent_id === '0') {
            $affComm = $cartTotal * $userFactor;
            $subAffComm = 0.0;
        } else {
            $parent = User::query()->with('roles')->find($user->parent_id);
            $parentFactor = $parent ? (float) ($parent->point_factor ?? 0) : 0.0;

            if ($parent && $this->isRepresentative($parent)) {
                $repComm = $cartTotal * $parentFactor;
                $affComm = $cartTotal * $userFactor;
                $repId = (int) $parent->id;
            } else {
                $affComm = $cartTotal * $parentFactor;
                $subAffComm = $cartTotal * $userFactor;

                if ($parent?->parent_id && (string) $parent->parent_id !== '4') {
                    $rep = User::query()->with('roles')->find($parent->parent_id);
                    if ($rep && $this->isRepresentative($rep)) {
                        $repComm = $cartTotal * (float) ($rep->point_factor ?? 0);
                        $repId = (int) $rep->id;
                    }
                }
            }
        }

        if ($repId === null) {
            $repId = app(OrderPricingService::class)->resolveRepIdForUser($user);
        }

        return [
            'mfgComm' => round($mfgComm, 4),
            'repComm' => round($repComm, 4),
            'affComm' => round($affComm, 4),
            'subAffComm' => round($subAffComm, 4),
            'repId' => $repId,
            'parentId' => $parentId,
        ];
    }

    protected function isRepresentative(User $user): bool
    {
        if (! method_exists($user, 'hasRole')) {
            return false;
        }

        return $user->hasRole(['Representative', 'Rep', 'representative', 'rep']);
    }
}
