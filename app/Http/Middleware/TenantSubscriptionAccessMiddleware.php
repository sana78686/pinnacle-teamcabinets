<?php

namespace App\Http\Middleware;

use App\Services\TenantSubscriptionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Subscription / trial access applies to the tenant (dealer) only — never to individual users.
 * Tenant users share access while the tenant subscription or trial is active.
 */
class TenantSubscriptionAccessMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $tenant = tenant();
        if (! $tenant instanceof \App\Models\Tenant) {
            return $next($request);
        }

        if ($request->routeIs([
            'tenant.billing.checkout',
            'tenant.billing.success',
            'tenant.billing.cancel',
            'tenant.subscription.required',
        ])) {
            return $next($request);
        }

        /** @var TenantSubscriptionService $svc */
        $svc = app(TenantSubscriptionService::class);

        if ($svc->hasAccess($tenant)) {
            return $next($request);
        }

        return redirect()
            ->route('tenant.subscription.required')
            ->with('error', 'Your subscription or trial has ended. Subscribe to continue.');
    }
}
