<?php

namespace App\Http\Middleware;

use App\Services\TenantPermissionService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTenantPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            abort(403);
        }

        $routeName = $request->route()?->getName();
        $repType = $request->route('type');
        if (is_string($routeName) && str_starts_with($routeName, 'tenant_rep_workspace_api_')) {
            $repType = is_string($repType) ? $repType : null;
        } else {
            $repType = null;
        }

        if (! TenantPermissionService::userCanAccessRoute($user, $routeName, $repType)) {
            if ($request->expectsJson()) {
                abort(403, 'You do not have permission to perform this action.');
            }

            return redirect()
                ->route('tenant_dashboard')
                ->with('error', 'You do not have permission to access that page.');
        }

        return $next($request);
    }
}
