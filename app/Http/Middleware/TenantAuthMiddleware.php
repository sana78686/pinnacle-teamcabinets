<?php

namespace App\Http\Middleware;

use App\Services\TenantAuthSessionService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ensures the authenticated user belongs to the current tenant (used after Laravel auth middleware).
 */
class TenantAuthMiddleware
{
    public function __construct(
        protected TenantAuthSessionService $authSessions,
    ) {}

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

        if (! $this->authSessions->sessionIsValid($user, $request)) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('tenant_login')
                ->with('error', 'Your session has ended. Please sign in again.');
        }

        return $next($request);
    }
}
