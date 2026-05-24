<?php

namespace App\View\Composers;

use App\Models\SiteSetting;
use App\Services\TenantAdminNavService;
use App\Services\TenantNavBadgeService;
use App\Services\TenantSubscriptionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TenantPanelComposer
{
    protected static ?\App\Models\SiteSetting $cachedSiteSettings = null;

    public function __construct(
        protected TenantSubscriptionService $subscriptions,
        protected TenantNavBadgeService $navBadges,
        protected TenantAdminNavService $adminNav,
    ) {}

    public function compose(View $view): void
    {
        $tenant = tenant();
        if (! $tenant instanceof \App\Models\Tenant) {
            return;
        }

        $status = $this->subscriptions->resolveStatus($tenant);
        $meta = $this->subscriptions->statusMeta($tenant);
        $settings = self::$cachedSiteSettings ??= SiteSetting::query()->select(['id', 'logo'])->first();

        $tcNavBadges = [];
        $tcAdminNavItems = [];
        if (Auth::check()) {
            $user = Auth::user();
            $tcNavBadges = $this->navBadges->countsForUser($user);
            if (tenant_user_is_panel_admin($user)) {
                $tcAdminNavItems = $this->adminNav->itemsForUser($user);
            }
        }

        $view->with([
            'tcTenant' => $tenant,
            'tcSubscriptionStatus' => $status,
            'tcSubscriptionMeta' => $meta,
            'tcSiteLogo' => $settings?->logo,
            'tcTrialEndsAt' => $tenant->trial_ends_at,
            'tcShowTrialBanner' => $status === TenantSubscriptionService::STATUS_TRIAL && $tenant->trial_ends_at,
            'tcFrontendUrl' => tenant_url($tenant->id),
            'tcLayout' => tenant_layout_flags(),
            'tcNavBadges' => $tcNavBadges,
            'tcAdminNavItems' => $tcAdminNavItems,
        ]);
    }
}
