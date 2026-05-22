<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use App\Models\User;
use App\Mail\PasswordChanged;
use App\Services\TenantNotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class TenantProfileController extends Controller
{
    public function step_1(Request $request): RedirectResponse
    {
        return redirect()->route($this->profileRouteName());
    }

    public function step_2(Request $request): RedirectResponse
    {
        return redirect()->route($this->profileRouteName());
    }

    public function step_3(Request $request): RedirectResponse
    {
        return redirect()->route($this->profileRouteName());
    }

    public function edit(Request $request): RedirectResponse
    {
        return redirect()->route($this->profileRouteName());
    }

    public function settingsProfile(Request $request): View
    {
        return $this->renderProfile($request, true);
    }

    public function profile(Request $request): View
    {
        return $this->renderProfile($request, false);
    }

    public function updateSettingsProfile(Request $request): RedirectResponse
    {
        return $this->saveProfile($request, true);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        return $this->saveProfile($request, false);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        $user = User::findOrFail(Auth::id());

        if (! Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        try {
            Mail::to($user->email)->send(new PasswordChanged($user));
        } catch (\Throwable) {
            // Non-blocking if mail fails
        }

        TenantNotificationService::flashToast('Password changed successfully.', 'success', 'Password updated');

        return back();
    }

    protected function renderProfile(Request $request, bool $inSettings): View
    {
        $user = Auth::user();
        $countryId = (int) ($user->country_id ?: 233);

        return view('tenants.profile.index', [
            'user' => $user,
            'inSettings' => $inSettings,
            'countries' => Country::orderBy('name')->get(),
            'states' => State::where('country_id', $countryId)->orderBy('name')->get(),
            'roleLabel' => $user->getRoleNames()->first() ?? 'User',
            'profileUpdateRoute' => $inSettings
                ? route('tenant_setting_profile_update')
                : route('tenant_profile_update'),
            'passwordUpdateRoute' => $inSettings
                ? route('tenant_setting_profile_password')
                : route('tenant_profile_password'),
        ]);
    }

    protected function saveProfile(Request $request, bool $inSettings): RedirectResponse
    {
        $user = User::findOrFail(Auth::id());

        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'username' => 'required|string|max:255|unique:users,username,'.$user->id,
            'full_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'country_id' => 'nullable|integer|exists:countries,id',
            'state_id' => 'nullable|integer|exists:states,id',
            'city_name' => 'nullable|string|max:120',
            'zip_code' => 'nullable|string|max:20',
        ]);

        if ($request->hasFile('logo')) {
            if ($user->logo && file_exists(public_path($user->logo))) {
                @unlink(public_path($user->logo));
            }

            $file = $request->file('logo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/logos'), $filename);
            $user->logo = 'uploads/logos/'.$filename;
        }

        $user->username = $validated['username'];
        $user->name = $validated['full_name'];
        $user->company_name = $validated['company_name'] ?? $user->company_name;
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?? null;
        $user->address = $validated['address'] ?? null;
        $user->country_id = $validated['country_id'] ?? $user->country_id;
        $user->state_id = $validated['state_id'] ?? null;
        $user->city_name = $validated['city_name'] ?? null;
        $user->zip_code = $validated['zip_code'] ?? null;
        $user->save();

        TenantNotificationService::flashToast('Your profile has been updated.', 'success', 'Profile updated');

        return redirect()->route($inSettings ? 'tenant_setting_profile' : 'tenant_profile');
    }

    protected function profileRouteName(): string
    {
        return Auth::user()->hasRole('Admin') ? 'tenant_setting_profile' : 'tenant_profile';
    }
}
