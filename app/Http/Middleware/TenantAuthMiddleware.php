<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class TenantAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!tenant()) {
            abort(403, 'No tenant found');
        }

        // Ensure user is authenticated
        if (!Auth::check()) {
            return redirect()->route('tenant_login'); // Redirect to login page
        }
        return $next($request);
    }
}
