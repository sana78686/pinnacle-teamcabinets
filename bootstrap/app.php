<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'stripe/webhook',
            'dev/migrate-fresh-seed',
            'dev/seed-team-cabinets',
        ]);
        $middleware->redirectGuestsTo(function (Request $request) {
            return tenant_guest_redirect_url($request);
        });

        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
            'tenant.auth' => App\Http\Middleware\TenantAuthMiddleware::class,
            'guest' => App\Http\Middleware\RedirectIfAuthenticated::class,
            \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
            \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
            'master.user'   => \App\Http\Middleware\MasterUserMiddleware::class,
            'tenant.subscribed' => \App\Http\Middleware\TenantSubscriptionAccessMiddleware::class,
            'tenant.permission' => \App\Http\Middleware\EnsureTenantPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
