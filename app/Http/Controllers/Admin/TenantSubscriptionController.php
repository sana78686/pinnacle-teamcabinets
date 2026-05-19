<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Services\TenantSubscriptionService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TenantSubscriptionController extends Controller
{
    public function __construct(
        protected TenantSubscriptionService $subscriptions
    ) {}

    public function update(Request $request, Tenant $tenant): RedirectResponse
    {
        $validated = $request->validate([
            'access_type' => 'required|in:trial,paid,complimentary_unlimited,complimentary_until,expired',
            'trial_days' => 'nullable|integer|min:1|max:365',
            'complimentary_until' => 'required_if:access_type,complimentary_until|nullable|date',
            'subscription_ends_at' => 'nullable|date',
        ]);

        match ($validated['access_type']) {
            'trial' => $this->subscriptions->startTrial(
                $tenant,
                (int) ($validated['trial_days'] ?? config('pinnacle.trial_days', 14))
            ),
            'paid' => $this->subscriptions->markPaid(
                $tenant,
                ! empty($validated['subscription_ends_at'])
                    ? Carbon::parse($validated['subscription_ends_at'])
                    : null
            ),
            'complimentary_unlimited' => $this->subscriptions->grantComplimentary($tenant, null),
            'complimentary_until' => $this->subscriptions->grantComplimentary(
                $tenant,
                Carbon::parse($validated['complimentary_until'])
            ),
            'expired' => $tenant->update([
                'subscription_status' => TenantSubscriptionService::STATUS_EXPIRED,
                'is_complimentary' => false,
                'complimentary_ends_at' => null,
            ]),
        };

        return redirect()
            ->route('tenant_index')
            ->with('success', 'Subscription updated for '.$tenant->company_name);
    }
}
