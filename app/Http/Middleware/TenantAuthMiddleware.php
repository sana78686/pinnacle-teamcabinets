<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the authenticated user belongs to the current tenant (used after Laravel auth middleware).
 */
class TenantAuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! tenant()) {
            abort(403, 'No tenant found');
        }

        $user = $request->user();

        if (! $user || $user->is_super_user) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('tenant_login');
        }

        if ((string) $user->tenant_id !== (string) tenant('id')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('tenant_login')
                ->with('error', 'You do not have access to this tenant.');
        }

        return $next($request);
    }
}
