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
        // Tenant hosts boot Stancl tenancy; asset() can become /tenancy/assets/ (broken).
        // Central Pinnacle (pinnacle.apimstec.com) never boots tenancy — asset() stays /assets/...
        $host = request()->getHost();
        $centralHosts = config('tenancy.central_domains', []);
        if ($host !== '' && ! in_array($host, $centralHosts, true)) {
            config(['tenancy.filesystem.asset_helper_tenancy' => false]);
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
