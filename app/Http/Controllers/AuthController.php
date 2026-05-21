<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use Concerns\ValidatesTurnstile;
    public function login()
    {
        return view('pinnacle.auth.login');
    }

    public function postLogin(Request $request)

    {

        $this->validateWithTurnstile($request, [
            'email' => 'required',
            'password' => 'required',
        ]);



        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            if ($user->is_super_user) {
                if ($remember) {
                    Cookie::queue('super_admin_login', $request->input('email'), 43200);
                } else {
                    Cookie::queue(Cookie::forget('super_admin_login'));
                }

                return redirect()->route('dashboard');
            }

            Auth::logout();

            return redirect()->route('login')
                ->withInput($request->only('email', 'remember'))
                ->with('error', 'Access denied.');
        }

        return back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Oops! You have entered invalid credentials');

    }

    public function dashboard()

    {

        if(Auth::check()){

// $users = User::get();
$tenant = Tenant::get();

// $totalUsers = $users->count();

// $dealerCount = User::role('Dealer')->count();
$tenantCount = $tenant->count();
// $representativeCount = User::role('Representative')->count();
// $distributorCount = User::role('Distributor')->count();
// $showroomCount = User::role('Showroom')->count();


            return view('dashboard',compact('tenantCount'));

        }



        return redirect("login")->withSuccess('Opps! You do not have access');

    }
    public function logout() {

        Session::flush();

        Auth::logout();



        return Redirect('login');

    }
    public function storeProfileStep1(Request $request)
    {
        try {
            // Validate form data
            $validator = Validator::make($request->all(), [
                'company_logo'  => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'username'      => 'required|string|max:255|unique:users,username,' . Auth::id(),
                'full_name'     => 'required|string|max:255',
                'company_name'  => 'required|string|max:255',
                'email_address' => 'required|email|max:255|unique:users,email,' . Auth::id(),
                'contact_number' => 'required|string|max:15',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Get authenticated user
            $user = User::find(Auth::id());

            // Handle company logo upload
            if ($request->hasFile('company_logo')) {
                $logoPath = $request->file('company_logo')->store('company_logos', 'public');
                $user->company_logo = $logoPath;
            }

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

}
