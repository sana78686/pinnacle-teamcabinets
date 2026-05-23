<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\State;
use App\Models\Tenant;
use App\Models\Country;
use App\Mail\sendOtpMail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TenantForgotUsernameMail;
use App\Mail\TenantResetPasswordMail;
use App\Services\TenantAuthSessionService;
use App\Services\TenantUserSchemaService;
use App\Services\TenantNotificationService;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Mail\PendingUserVerificationMail;
use App\Mail\AdminNewUserNotificationMail;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Cookie;

class TenantAuthController extends Controller
{
    use Concerns\ValidatesTurnstile;

    public function __construct(
        protected TenantAuthSessionService $authSessions,
        protected TenantUserSchemaService $userSchema,
    ) {}

    public function index()
    {
        return view('tenants.auth.login');
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        $data['countries'] = Country::where('id', 233)->get();
        $data['states'] = State::where('country_id', 233)->get();
        $data['cities'] = City::forCountry(233)->orderBy('name')->get();
        return view('tenants.auth.register', $data);
    }
    /**
     * Write code on Method
     *
     * @return response()
     */
public function postLogin(Request $request)
{
    $this->validateWithTurnstile($request, [
        'login' => 'required|string',
        'password' => 'required',
    ]);

    $login = trim($request->input('login'));
    if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
        $credentials = ['email' => $login, 'password' => $request->password];
    } else {
        $credentials = ['username' => $login, 'password' => $request->password];
    }

    $remember = $request->boolean('remember');

    if (Auth::attempt($credentials, $remember)) {
        $user = Auth::user();

        // ✅ Check if user is blocked or unapproved
        if (!$user->is_verified_by_admin) {
            Auth::logout();
            return redirect()->back()
                ->withInput($request->only('login', 'remember'))
                ->with('error', 'Your account has not been approved by the dealer admin yet. You will be notified when it is approved.');
        }

        if (in_array($user->status, ['deactive', 'block'], true)) {
            Auth::logout();
            return redirect()->back()
                ->withInput($request->only('login', 'remember'))
                ->with('error', 'Your account has been deactivated.');
        }

        if ($remember) {
            Cookie::queue('login', $login, 43200);
        } else {
            Cookie::queue(Cookie::forget('login'));
        }

        $this->authSessions->storeLoginSession($user, $request);

        $toastIds = TenantNotificationService::notifyOnLogin($user);

        return redirect()->route('tenant_dashboard')
            ->with('tenant_panel_toast_ids', $toastIds)
            ->with('tenant_panel_toast_messages', TenantNotificationService::loginToastsForUser($user));
    }

    return redirect()->back()
        ->withInput($request->only('login', 'remember'))
        ->with('error', 'Oops! You have entered invalid credentials.');
}


    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {
        $role = Role::where('id', $request->role)->orWhere('name', $request->role)->first();
        if (!$role) {
            return back()->with('error', 'Selected role does not exist.');
        }
        $this->validateWithTurnstile($request, [
            'role' => 'required',
            'username' => 'required|string|max:255|unique:users,username',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $this->userSchema->ensureStatusColumn();

        // Create user in the tenant's database
        // tenancy()->initialize(tenant()); // Ensure we're in tenant DB
        // $tenant_user = DB::connection('tenant')->table('users')->insert([
        //     'username' => $request->username,
        //     'full_name' => $request->full_name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);
        $tenant_user = User::create([
            'username' => $request->username,
            'name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_name' => $request->city_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'zip_code' => $request->zip_code,
            'is_super_user' => 0,
            'tenant_id' => tenant('id'),
            'company_name' => tenant('name'),
            'status' => config('tenant_user.default_status', 'un-approved'),
            'is_verified' => false,
            'is_verified_by_admin' => false,
        ]);

        $tenant_user->assignRole($role->name);

        TenantNotificationService::registrationPendingApproval($tenant_user);

        try {
            Mail::to($tenant_user->email)->send(new PendingUserVerificationMail($tenant_user));
        } catch (\Throwable $e) {
            Log::warning('Registration confirmation email failed', [
                'user_id' => $tenant_user->id,
                'message' => $e->getMessage(),
            ]);
        }

        $adminEmail = SiteSetting::first()?->newuser_email;
        if (! $adminEmail) {
            $adminEmail = User::role('Admin')->value('email');
        }
        if ($adminEmail) {
            try {
                Mail::to($adminEmail)->send(new AdminNewUserNotificationMail($tenant_user));
            } catch (\Throwable $e) {
                Log::warning('Admin new-user email failed', [
                    'user_id' => $tenant_user->id,
                    'message' => $e->getMessage(),
                ]);
            }
        }


        return back()->with('success', 'Registration submitted. The dealer admin will review and approve your account before you can sign in.');
        // return redirect()->route('tenant_login')->with('success', 'Registration success.');
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function dashboard()

    {

        if (Auth::check()) {

            return view('tenant.dashboard');
        }



        return redirect("login")->withSuccess('Opps! You do not have access');
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function create(array $data)

    {

        return User::create([

            'name' => $data['name'],

            'email' => $data['email'],

            'password' => Hash::make($data['password'])

        ]);
    }



    /**

     * Write code on Method

     *

     * @return response()

     */

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $this->authSessions->logoutEverywhere($user);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('tenant_login')
            ->with('success', 'You have been logged out from all devices.');
    }

    public function forgot_username()
    {
        return view('tenants.auth.forgot_username');
    }
    public function forgot_password()
    {
        return view('tenants.auth.forgot_password');
    }

    public function sendForgotUsername(Request $request)
    {
        $this->validateWithTurnstile($request, ['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();
        if ($user && $user->username) {
            $tenantName = tenant('company_name') ?? tenant('name') ?? config('app.name');
            Mail::to($user->email)->send(new TenantForgotUsernameMail($user, $tenantName, tenant('id')));
        }

        return back()->with('success', 'If an account exists for that email, we have sent your username.');
    }


    // otp verification module
    public function showVerifyForm()
    {
        return view('tenants.auth.verifyOTP');
    }
    public function verifyOtp(Request $request)
    {

        // dd('hello');
        $this->validateWithTurnstile($request, [
            'otp' => 'required|digits:6',
        ]);


        $email = $request->email; // already stored when OTP was sent
        // dd($email);
        $user = User::where('email', $email)->first();

        // dd($user);
        if (! $user) {
            return redirect()->route('tenant_login')->withErrors(['otp' => 'User not found.']);
        }

        if ($user->otp_attempts >= 5) {
            return redirect()->route('tenant_login')->withErrors(['otp' => 'Too many failed attempts. Try again later.']);
        }

        if (! Hash::check($request->otp, $user->otp_code) || now()->gt($user->otp_expires_at)) {
            $user->increment('otp_attempts');

            return back()->withErrors(['otp' => 'Invalid or expired OTP.'])->withInput();
        }

        // Success
        $user->is_verified = true;
        $user->otp_code = null;
        $user->otp_expires_at = null;
        $user->otp_attempts = 0;
        $user->save();
        // Auth::login($user);

        return redirect()->route('tenant_login')
            ->with('success', 'your email is sucessfully verified now please login again to continue.');
    }

    // Resend OTP
    public function resendOtp(Request $request)
    {
        $this->validateWithTurnstile($request, [
            'email' => 'required|email',
        ]);

        $email = $request->input('email') ?? session('otp_email');
        $user = User::where('email', $email)->first();

        if (! $user) {
            return redirect()->route('tenant_login')->with('error', 'User not found.');
        }

        $otp = rand(100000, 999999);
        $user->otp_code = Hash::make($otp);
        $user->otp_expires_at = now()->addMinutes(10);
        $user->otp_attempts = 0;
        $user->save();


        Mail::to($user->email)->send(new SendOtpMail(
            $otp,
            $user->name,
            tenant('company_name') ?? tenant('name')
        ));


        return view('tenants.auth.verifyOTP', [
            'email' => $user->email,
            'success' => 'OTP re-send successfully!',
        ]);
    }


    /**
     * Generate a custom tenant reset URL manually (if you want full control).
     */

    public function generateTenantResetUrl(User $user): string
    {
        $token = Password::broker('tenants')->createToken($user);
        $tenantId = tenant('id') ?? $user->tenant_id;

        return tenant_url($tenantId, 'show-resetform/'.$token).'?email='.urlencode($user->email);
    }


    public function sendTenantResetLink(Request $request)
    {

        $this->validateWithTurnstile($request, ['email' => 'required|email']);

        $user = \App\Models\User::where('email', $request->email)->first();

        if (! $user) {
            return back()->with('success', 'If an account exists for that email, we sent a reset link.');
        }

        try {
            $resetUrl = $this->generateTenantResetUrl($user);
            Mail::to($user->email)->send(new TenantResetPasswordMail($user, $resetUrl));
        } catch (\Throwable $e) {
            Log::error('Password reset mail failed: '.$e->getMessage());

            return back()->with('error', 'Unable to send reset email. Please try again later.');
        }

        return back()->with('success', 'If an account exists for that email, we sent a reset link.');
    }

    public function showResetForm(Request $request, $token)
    {
        // dd('hello');
        return view('tenants.auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    // public function resetPassword(Request $request)
    // {

    //     // dd('hello');
    //     $validated = $request->validate([
    //         'token' => 'nullable',
    //         'email' => 'required|email',
    //         'password' => 'required|confirmed|min:8',
    //     ]);;

    //     // dd($validated);
    //     $status = Password::broker('tenants')->reset(
    //         $request->only('email', 'password', 'password_confirmation', 'token'),
    //         function ($user, $password) {
    //             $user->forceFill([
    //                 'password' => $password, // let the mutator hash it
    //                 'remember_token' => Str::random(60),
    //             ])->save();

    //             event(new PasswordReset($user));
    //         }
    //     );


    //     // dd($status);
    //     return $status === 'passwords.user'
    //         ? redirect()->route('tenant_login')->with('success', __($status))
    //         : back()->with(['error' => [__($status)]]);
    // }
    public function resetPassword(Request $request)
    {
        $this->validateWithTurnstile($request, [
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'No user found with this email']);
        }

        $user->update([
            'password' => $request->password, // ✅ mutator will hash it
            'remember_token' => Str::random(60),
        ]);

        return redirect()->route('tenant_login')->with('success', 'Password reset successfully!');
    }
}
