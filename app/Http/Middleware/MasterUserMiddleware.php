<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stancl\Tenancy\Facades\Tenancy;
use Symfony\Component\HttpFoundation\Response;

class MasterUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = Auth::user();
        $appDomain = tenant_base_domain();

        // Allow only super users to access the master URL
        if ($user && $user->is_super_user) {
            return $next($request);
        }

        // Redirect tenant users to their tenant URL
        if ($user && ! $user->is_super_user) {

            $tenantId = $user->tenant_id; // Get current tenant ID

            if ($tenantId) {
                return redirect()->to("http://{$tenantId}.{$appDomain}"); // Change this to your actual domain format
            }
        }

        return redirect()->route('auth_login')->with('error', 'Access Denied.');
    }
}
