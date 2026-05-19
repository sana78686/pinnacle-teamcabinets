<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\County;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Mail\PasswordChanged;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class TenantProfileController extends Controller
{

    public function step_1(Request $request)
    {

        $data['user'] = Auth::user();

        $data['countries'] = Country::where('id', '233')->get();
        $data['states'] = State::where('country_id', '233')->get();
        $data['cities'] = City::select('id', 'name')->where('country_id', '233')->get();
        $data['counties'] = County::get();
        // dd($data['cities']);
        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.profile.step_1', $data);
        }
        else
        {
            return view('tenants.representative_modals.profile.step_1', $data);
        }
    }
    public function step_2(Request $request)
    {

        $data['user'] = Auth::user();
        if(Auth::user()->hasRole('Admin'))
        {
        return view('tenants.profile.step_2', $data);
        }
        else{
            return view('tenants.representative_modals.profile.step_2', $data);
        }
    }
    public function step_3(Request $request)
    {

        $data['user'] = Auth::user();
        if(Auth::user()->hasRole('Admin'))
        {
        return view('tenants.profile.step_3', $data);
        }
        else{
            return view('tenants.representative_modals.profile.step_3', $data);
        }
    }
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('tenants.profile.edit');
    }

    public function storeProfileStep1(Request $request)
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
            $file->move(public_path('uploads/logos'), $filename); // Save to public directory

            // Save new image path in DB
            $user->logo = 'uploads/logos/' . $filename;
        }

            $user->username      = $request->username;
            $user->name          = $request->full_name;
            $user->company_name  = $request->company_name;
            $user->email         = $request->email_address;
            $user->phone         = $request->contact_number;
            $user->address         = $request->address;
            $user->save();
            return redirect()->route('tenant_profile_step_2')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
    public function updatePassword(Request $request)
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


        $user->password = $request->new_password;
        $updated = $user->save();
        if ($updated) {
            Mail::to($user->email)->send(new PasswordChanged($user));
        }
        return back()->with('success', 'Password updated successfully.');
    }

}
