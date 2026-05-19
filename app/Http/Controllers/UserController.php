<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function checkAuthPermissions()
    {
        $user = auth()->user();

        return response()->json([
            'roles' => $user->getRoleNames(),
            'permissions' => $user->getAllPermissions()->pluck('name'),
        ]);
    }

    public function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        $data['users'] = User::where('is_super_user', 1)->latest()->paginate(10);

        return view('backend.users.index', $data)
            ->with('i', ($request->input('page', 1) - 1) * 10);
    }

    public function create(): View
    {
        $roles = Role::orderBy('name')->pluck('name', 'name')->all();

        return view('backend.users.create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|same:confirm-password',
                'roles' => 'required|array|min:1',
                'roles.*' => 'exists:roles,name',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_super_user' => 1,
            ]);

            $user->syncRoles($validated['roles']);

            return redirect()->route('users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error('User create failed: '.$e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'User could not be created: '.$e->getMessage());
        }
    }

    public function show($id): View
    {
        $user = User::where('is_super_user', 1)->findOrFail($id);

        return view('backend.users.show', compact('user'));
    }

    public function edit($id): View
    {
        $user = User::where('is_super_user', 1)->findOrFail($id);
        $roles = Role::orderBy('name')->pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('backend.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $user = User::where('is_super_user', 1)->findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,'.$user->id,
                'password' => 'nullable|min:8|same:confirm-password',
                'roles' => 'required|array|min:1',
                'roles.*' => 'exists:roles,name',
            ]);

            $user->name = $validated['name'];
            $user->email = $validated['email'];

            if (! empty($validated['password'])) {
                $user->password = Hash::make($validated['password']);
            }

            $user->save();
            $user->syncRoles($validated['roles']);

            return redirect()->route('users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error('User update failed: '.$e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'User could not be updated: '.$e->getMessage());
        }
    }

    public function destroy($id): RedirectResponse
    {
        $user = User::where('is_super_user', 1)->findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }
}
