<?php

namespace App\Http\Controllers;

use App\Models\UserColumnPreference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserColumnPreferenceController extends Controller
{
    public function store(Request $request)
    {
        $user = Auth::user();

        UserColumnPreference::updateOrCreate(
            ['user_id' => $user->id, 'module' => $request->module],
            ['columns' => json_encode($request->columns)]
        );

        return response()->json(['message' => 'Column order saved successfully.']);
    }

    public function getUserColumns($module)
    {
        $user = Auth::user();
        $preference = UserColumnPreference::where('user_id', $user->id)
            ->where('module', $module)
            ->first();

        return response()->json(['columns' => $preference ? json_decode($preference->columns, true) : []]);
    }
}
