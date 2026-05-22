<?php

namespace App\Providers;

use App\Services\TenantFrontendThemeService;
use App\View\Composers\TenantFrontendThemeComposer;
use App\View\Composers\TenantPanelComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TenantFrontendThemeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tenant hosts: docroot is project folder → files are under /public/ on disk.
        // Do not set APP_URL to .../public — that only affects Pinnacle, not tenant subdomains.
        $host = request()->getHost();
        $centralHosts = config('tenancy.central_domains', []);
        $isTenantHost = $host !== '' && ! in_array($host, $centralHosts, true);
        $isDevHost = str_contains($host, 'localhost') || str_contains($host, '127.0.0.1');

        if ($isTenantHost) {
            config(['tenancy.filesystem.asset_helper_tenancy' => false]);

            if (! $isDevHost) {
                $tenantAssetRoot = rtrim(request()->getSchemeAndHttpHost(), '/').'/public';
                config(['app.asset_url' => $tenantAssetRoot]);
                app('url')->setAssetRoot($tenantAssetRoot);
            }
        }

        Paginator::useBootstrapFive();

        Schema::defaultStringLength(191);

        Gate::before(function ($user, $ability) {
            return $user->is_super_user ? true : null;
        });

        View::composer([
            'layouts.tenant.master',
            'layouts.tenant.header',
            'layouts.tenant.admin_sidebar',
            'layouts.tenant.partials.header-actions',
            'layouts.tenant.partials.tenant-logo',
            'layouts.tenant.partials.*',
        ], TenantPanelComposer::class);

        View::composer([
            'themes.*',
            'frontend.superusers.*',
        ], TenantFrontendThemeComposer::class);

        if (! config('app.debug')) {
            \Illuminate\Support\Facades\DB::disableQueryLog();
        }

        if (config('app.env') === 'local' && config('app.optimize_local', true)) {
            \Illuminate\Support\Facades\View::share('pinnacle', config('pinnacle'));
        }
    }
}
