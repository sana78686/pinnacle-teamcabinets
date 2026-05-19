<?php

namespace App\View\Composers;

use App\Models\SiteSetting;
use App\Services\TenantSubscriptionService;
use Illuminate\View\View;

class TenantPanelComposer
{
    public function __construct(
        protected TenantSubscriptionService $subscriptions,
    ) {}

    public function compose(View $view): void
    {
        $tenant = tenant();
        if (! $tenant instanceof \App\Models\Tenant) {
            return;
        }

        $status = $this->subscriptions->resolveStatus($tenant);
        $meta = $this->subscriptions->statusMeta($tenant);
        $settings = SiteSetting::first();

        $view->with([
            'tcTenant' => $tenant,
            'tcSubscriptionStatus' => $status,
            'tcSubscriptionMeta' => $meta,
            'tcSiteLogo' => $settings?->logo,
            'tcTrialEndsAt' => $tenant->trial_ends_at,
            'tcShowTrialBanner' => $status === TenantSubscriptionService::STATUS_TRIAL && $tenant->trial_ends_at,
            'tcFrontendUrl' => tenant_url($tenant->id),
        ]);
    }
}
