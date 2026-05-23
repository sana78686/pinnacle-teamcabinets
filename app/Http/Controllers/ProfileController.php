<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\County;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
// dd($request->all());
        $data['user'] = Auth::user();

        $data['countries'] = Country::where('id', '233')->get();
        $data['states'] = State::where('country_id', '233')->get();
        $data['cities'] = City::select('id', 'name')->forCountry(233)->orderBy('name')->get();
        $data['counties'] = County::get();
        return view('profile.edit_profile', $data);
    }

    /**
     * Update the user's profile information.
     */


    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'username' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'company_name' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'country_id' => 'required|integer|exists:countries,id',
            'state_id' => 'required|integer|exists:states,id',
            'city_name' => 'required|string|max:255',
            'zip_code' => 'nullable|string|max:20',
            'description' => 'nullable|string',
            'address' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $user->logo = $path;
        }

        // Assign other fields manually or via fill
        $user->username = $validated['username'];
        $user->name = $validated['full_name'];
        $user->company_name = $validated['company_name'];
        $user->email = $validated['email_address'];
        $user->phone = $validated['contact_number'];
        $user->country_id = $validated['country_id'];
        $user->state_id = $validated['state_id'];
        $user->city_name = $validated['city_name'];
        $user->zip_code = $validated['zip_code'] ?? null;
        // $user->description = $validated['description'] ?? null;
        $user->address = $validated['address'] ?? null;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('dashboard')->with('status', 'Profile updated successfully!');
    }


    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function editProfile(Request $request)
    {
        try {
            // Validate form data
            $validator = Validator::make($request->all(), [
                'logo'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'username'      => 'required|string|max:255|unique:users,username,' . Auth::id(),
                'full_name'     => 'required|string|max:255',
                'company_name'  => 'required|string|max:255',
                'email_address' => 'required|email|max:255|unique:users,email,' . Auth::id(),
                'contact_number' => 'required|string|max:15',
            ]);

            // if ($validator->fails()) {
            //     return back()->withErrors($validator)->withInput();
            // }

            // Get authenticated user
            $user = User::find(Auth::id());


        if ($request->hasFile('logo')) {
            // Delete old image if exists
            if ($user->logo && file_exists(public_path($user->logo))) {
                unlink(public_path($user->logo)); // Remove old file
            }

            // Upload new image
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName(); // Unique filename
            $file->move(public_path('super-user/uploads/logos'), $filename); // Save to public directory

            // Save new image path in DB
            $user->logo = 'super-user/uploads/logos/' . $filename;
        }

            // dd(User::find(Auth::id()));
            $user->username      = $request->username;
            $user->name          = $request->full_name;
            $user->company_name  = $request->company_name;
            $user->email         = $request->email_address;
            $user->phone         = $request->contact_number;
            $user->save();
            return redirect()->route('tenant_profile_step_2')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    //  public function changePassword()
    // {
    //    return view('profile.change_password');
    // }

    public function changePasssword(Request $request)
    {
        $request->validate([
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8'],
            'confirm_password' => ['required', 'same:new_password'],
        ]);

        $user = User::find(Auth::id());

        // Check if the old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }


        $user->password         = $request->new_password;
        $user->save();

        return back()->with('success', 'Password updated successfully.');
    }
}
