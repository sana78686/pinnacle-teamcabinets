<?php

namespace App\Services;

use App\Models\User;

class CommissionCalculationService
{
    /**
     * Mirror of CI Admin::commCalculation().
     *
     * @return array{
     *     mfgCommission: float,
     *     repCommission: float,
     *     affCommission: float,
     *     sub_aff_commission: float,
     *     repId: ?int,
     *     parentId: int,
     *     mfgComm: float,
     *     repComm: float,
     *     affComm: float,
     *     subAffComm: float
     * }
     */
    public function calculate(float $cartAmount, User $orderingUser, ?int $affiliateId = null): array
    {
        if ($affiliateId && $affiliateId > 0) {
            $user = User::query()->findOrFail($affiliateId);
            $userPointFactor = (float) $user->point_factor;
            $parentId = (int) ($user->parent_id ?? 0);
            $customerType = $user->getCiRole();
        } else {
            $user = $orderingUser;
            $userPointFactor = (float) $orderingUser->point_factor;
            $parentId = (int) ($orderingUser->parent_id ?? 0);
            $customerType = $orderingUser->getCiRole();
        }

        $parentPointFactor = 0.0;
        $parentUserType = '';
        if ($parentId > 0) {
            $parent = User::query()->find($parentId);
            if ($parent) {
                $parentPointFactor = (float) $parent->point_factor;
                $parentUserType = $parent->getCiRole();
            }
        }

        $admin = User::query()
            ->where(function ($q) {
                $q->where('user_type', 'admin')
                    ->orWhereHas('roles', fn ($r) => $r->whereIn('name', ['admin', 'Admin']));
            })
            ->first();
        $adminPointFactor = $admin ? (float) $admin->point_factor : 0.0;

        $mgfCommission = $cartAmount * $adminPointFactor;
        $repCommission = 0.0;
        $affCommission = 0.0;
        $subAffCommission = 0.0;

        if ($customerType === 'representatives') {
            $repCommission = $cartAmount * $userPointFactor;
            $affCommission = 0.0;
        } else {
            if ($parentUserType === 'representatives' && $parentUserType !== 'admin') {
                $repCommission = $cartAmount * $parentPointFactor;
                $affCommission = $cartAmount * $userPointFactor;
            } else {
                $affCommission = $cartAmount * $parentPointFactor;
                $subAffCommission = $cartAmount * $userPointFactor;
            }

            if ($parentId === 0) {
                $affCommission = $cartAmount * $userPointFactor;
                $subAffCommission = 0.0;
            }
        }

        $repId = $parentUserType === 'representatives' ? $parentId : null;
        if ($repId !== null && $repId <= 0) {
            $repId = null;
        }

        return [
            'mgfCommission' => round($mgfCommission, 4),
            'repCommission' => round($repCommission, 4),
            'affCommission' => round($affCommission, 4),
            'sub_aff_commission' => round($subAffCommission, 4),
            'repId' => $repId,
            'parentId' => $parentId,
            'mfgComm' => round($mgfCommission, 4),
            'repComm' => round($repCommission, 4),
            'affComm' => round($affCommission, 4),
            'subAffComm' => round($subAffCommission, 4),
        ];
    }
}
