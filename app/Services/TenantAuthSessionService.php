<?php

namespace App\Services;

use App\Models\User;
use App\Services\UserDoorFactorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class TenantAuthSessionService
{
    public const SESSION_VERSION_KEY = 'tenant_login_version';

    public function storeLoginSession(User $user, Request $request): void
    {
        $request->session()->put(self::SESSION_VERSION_KEY, (int) ($user->login_version ?? 0));

        $payload = app(UserDoorFactorService::class)->sessionPayload($user);
        $request->session()->put('point_factor', $payload['point_factor']);
        $request->session()->put('door_point_factor', $payload['door_point_factor']);
        $request->session()->put('catalog_visibility', $payload['catalog_visibility']);

        $request->session()->put('logged_in', [
            'userid' => $user->id,
            'role' => $user->getCiRole(),
            'user_type' => $user->user_type ?? $user->getCiRole(),
            'point_factor' => $user->point_factor,
            'parent_id' => $user->parent_id,
            'door_point_factor' => $user->door_point_factor ?? [],
        ]);
    }

    public function sessionIsValid(User $user, Request $request): bool
    {
        $stored = $request->session()->get(self::SESSION_VERSION_KEY);

        if ($stored === null) {
            return true;
        }

        return (int) $stored === (int) ($user->login_version ?? 0);
    }

    /** Invalidate every session for this user (all devices). */
    public function logoutEverywhere(User $user): void
    {
        $data = [
            'login_version' => (int) ($user->login_version ?? 0) + 1,
        ];

        if (Schema::hasColumn('users', 'remember_token')) {
            $data['remember_token'] = Str::random(60);
        }

        $user->forceFill($data)->save();

        if (Schema::hasTable('sessions') && Schema::hasColumn('sessions', 'user_id')) {
            DB::table('sessions')->where('user_id', $user->id)->delete();
        }
    }
}
