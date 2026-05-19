<?php

namespace App\Services;

use App\Models\Tenant;
use Carbon\Carbon;

class TenantSubscriptionService
{
    public const STATUS_TRIAL = 'trial';

    public const STATUS_ACTIVE = 'active';

    public const STATUS_PAST_DUE = 'past_due';

    public const STATUS_EXPIRED = 'expired';

    public const STATUS_COMPLIMENTARY = 'complimentary';

    /** @return array{color: string, label: string, title: string} */
    public function statusMeta(Tenant $tenant): array
    {
        $resolved = $this->resolveStatus($tenant);

        return match ($resolved) {
            self::STATUS_ACTIVE => [
                'color' => 'green',
                'label' => 'Paid',
                'title' => 'Active paid subscription',
            ],
            self::STATUS_COMPLIMENTARY => [
                'color' => 'blue',
                'label' => $tenant->complimentary_ends_at
                    ? 'Free until '.$tenant->complimentary_ends_at->format('M j, Y')
                    : 'Free (unlimited)',
                'title' => 'Complimentary access granted by super admin',
            ],
            self::STATUS_TRIAL => [
                'color' => 'yellow',
                'label' => $tenant->trial_ends_at
                    ? 'Trial · ends '.$tenant->trial_ends_at->format('M j, Y')
                    : 'Trial',
                'title' => 'Trial period',
            ],
            self::STATUS_PAST_DUE => [
                'color' => 'orange',
                'label' => 'Past due',
                'title' => 'Payment past due',
            ],
            default => [
                'color' => 'grey',
                'label' => 'Unpaid',
                'title' => 'No active subscription',
            ],
        };
    }

    public function resolveStatus(Tenant $tenant): string
    {
        if ($tenant->is_complimentary && $this->complimentaryIsActive($tenant)) {
            return self::STATUS_COMPLIMENTARY;
        }

        if ($tenant->subscription_status === self::STATUS_ACTIVE && $this->subscriptionIsActive($tenant)) {
            return self::STATUS_ACTIVE;
        }

        if ($tenant->subscription_status === self::STATUS_PAST_DUE) {
            return self::STATUS_PAST_DUE;
        }

        if ($this->trialIsActive($tenant)) {
            return self::STATUS_TRIAL;
        }

        return self::STATUS_EXPIRED;
    }

    public function hasAccess(Tenant $tenant): bool
    {
        return in_array($this->resolveStatus($tenant), [
            self::STATUS_ACTIVE,
            self::STATUS_COMPLIMENTARY,
            self::STATUS_TRIAL,
        ], true);
    }

    public function startTrial(Tenant $tenant, ?int $days = null): void
    {
        $days = $days ?? (int) config('pinnacle.trial_days', 14);

        $tenant->update([
            'subscription_status' => self::STATUS_TRIAL,
            'trial_ends_at' => now()->addDays($days),
            'is_complimentary' => false,
            'complimentary_ends_at' => null,
        ]);
    }

    public function grantComplimentary(Tenant $tenant, ?Carbon $until = null): void
    {
        $tenant->update([
            'is_complimentary' => true,
            'complimentary_ends_at' => $until,
            'subscription_status' => self::STATUS_COMPLIMENTARY,
        ]);
    }

    public function markPaid(Tenant $tenant, ?Carbon $endsAt = null): void
    {
        $tenant->update([
            'subscription_status' => self::STATUS_ACTIVE,
            'subscription_ends_at' => $endsAt,
            'is_complimentary' => false,
            'complimentary_ends_at' => null,
        ]);
    }

    protected function trialIsActive(Tenant $tenant): bool
    {
        return $tenant->subscription_status === self::STATUS_TRIAL
            && $tenant->trial_ends_at
            && $tenant->trial_ends_at->isFuture();
    }

    protected function subscriptionIsActive(Tenant $tenant): bool
    {
        if (! $tenant->subscription_ends_at) {
            return true;
        }

        return $tenant->subscription_ends_at->isFuture();
    }

    protected function complimentaryIsActive(Tenant $tenant): bool
    {
        if (! $tenant->complimentary_ends_at) {
            return true;
        }

        return $tenant->complimentary_ends_at->isFuture();
    }
}
