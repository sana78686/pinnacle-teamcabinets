<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\State;
use App\Models\Tenant;
use App\Models\Domain;
use App\Models\Country;
use App\Models\City;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Services\TenantRegistrationMailer;
use App\Services\TenantSubscriptionService;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    public function index(TenantSubscriptionService $subscriptions)
    {
        $data['tenants'] = Tenant::all()->map(function ($tenant) use ($subscriptions) {
            $owner = User::where('tenant_id', $tenant->id)->first();

            return [
                'tenant' => $tenant,
                'owner' => $owner,
                'status' => $subscriptions->statusMeta($tenant),
            ];
        });

        return view('backend.tenants.index', $data);
    }

    public function getCities($state_id)
{
    $cities = City::where('state_id', $state_id)->orderBy('name')->get(['id', 'name']);
    return response()->json($cities);
}


public function getStates($country_id)
{
    $states = State::where('country_id', $country_id)->orderBy('name')->get(['id', 'name']);
    return response()->json($states);
}

    public function showTenantRegistrationForm()
    {
        // $data['states'] = State::where('country_id', 233)->get();
        $data[ 'countries'] = Country::orderBy('name')->get();
        return view('pinnacle.auth.register', $data);
    }
    public function showRegistrationForm()
    {
        $data['states'] = State::where('country_id', 233)->get();

        return view('backend.tenants.auth.register',$data);
    }

    public function registerOld(Request $request)
    {
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255|unique:tenants,id',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        // Generate a slug from the company name
        $slug = Str::slug($request->company_name);

        // Ensure the slug is unique
        $tenantId = $slug;
        $counter = 1;
        while (Tenant::find($tenantId)) {
            $tenantId = $slug . '-' . $counter;
            $counter++;
        }

        try {
            // Create the tenant
            $tenant = Tenant::create([
                'id' => $tenantId, // Tenant ID
                'data' => [
                    'company_name' => $request->company_name,
                    'email' => $request->email,
                ],
            ]);

            // Register the tenant's domain
            $tenant->domains()->create([
                'domain' => $tenantId.'.'.config('app.domain'), // Example: team-cabinets.localhost
            ]);

            // Save user in the main database
            User::create([
                'company_name' => $request->company_name, // Use company name as admin name
                'name' => $request->name, // Use company name as admin name
                'username' => $request->username, // Use company name as admin name
                'tenant_id' => $tenantId, // Use company name as admin name
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Save the user in the tenant database
            $tenant->run(function () use ($request) {
                User::create([
                    'company_name' => $request->company_name, // Use company name as admin name
                    'name' => $request->name, // Use company name as admin name
                    'username' => $request->username, // Use company name as admin name
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ]);
            });


            // Flash success message
            session()->flash('success', 'Tenant registered successfully! You will be redirected to you dashboard shortly.');

            // Redirect to the tenant's URL
            return redirect(tenant_url($tenantId));
        } catch (\Exception $e) {
            // Flash error message
            session()->flash('error', 'Tenant cannot be created. Reason: ' . $e->getMessage());

            // Redirect back to the registration form
            return redirect()->back();
        }
    }
    public function register_tenant(Request $request)
{
    try {
        Log::info('Starting tenant creation.');

        // ✅ Validate input
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'username' => 'required|string|unique:tenants,username',
            'name' => 'required|string|max:255|unique:tenants,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'nullable|string|max:20',
            'country_id' => 'nullable|integer|exists:countries,id',
            'state_id' => 'nullable|integer|exists:states,id',
            'city_name' => 'nullable|string|max:100',
            'zip_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        // ✅ Generate domain slug from company name


$slug = Str::slug($request->company_name);
$tenantId = $slug;
$counter = 1;

while (
    Tenant::find($tenantId) ||
    Tenant::whereHas('domains', function ($query) use ($tenantId) {
        $query->where('domain', $tenantId . '.' . config('app.domain'));
    })->exists()
) {
    $tenantId = $slug . '-' . $counter++;
}


        Log::info('Validation passed. Creating tenant...');

        // ✅ Create tenant
        $tenant = Tenant::create([
            'id' => $tenantId,
            'company_name' => $validatedData['company_name'],
            'username' => $validatedData['username'],
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_name' => $request->city_name,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
        ]);


        // ✅ Domain logic (auto from company name)
        if ($request->has('seperate_domain') && $request->seperate_domain) {
            $domain = $request->domain_name;
        } else {
            $domain = $tenantId.'.'.config('app.domain');
        }

        $tenant->update(['domain_name' => $domain]);

        app(TenantSubscriptionService::class)->startTrial($tenant);

        // ✅ Register domain
        $tenant->domains()->create(['domain' => $domain]);

        // ✅ Create admin user in central DB
        $admin = User::create([
            'tenant_id' => $tenant->id,
            'company_name' => $request->company_name,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_name' => $request->city_name,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'status' => 'active',
            'is_verified_by_admin' => true,
            'is_verified' => true,
        ]);

        $roleName = 'Admin';
        $role = Role::firstOrCreate(['name' => $roleName]);
        $admin->assignRole($role);
        // ✅ Create same user in tenant DB
        // $tenant->run(function () use ($request) {
            // $user = User::create([
            //     'company_name' => $request->company_name,
            //     'username' => $request->username,
            //     'name' => $request->name,
            //     'email' => $request->email,
            //     'password' => Hash::make($request->password),
            //     'phone' => $request->phone,
            //     'country_id' => $request->country_id,
            //     'state_id' => $request->state_id,
            //     'city_name' => $request->city_name,
            //     'zip_code' => $request->zip_code,
            //     'address' => $request->address,
            // ]);

            // $roleName = 'Admin';
            // $role = Role::firstOrCreate(['name' => $roleName]);
            // $user->assignRole($role);
        // });

        TenantRegistrationMailer::send($tenant);

        Log::info('Tenant and user created successfully.');

        return redirect()->away(tenant_url($tenantId, 'login?success=1'))
            ->with('success', 'Your account has been created successfully! Please try to log in');

    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->errors())->withInput();
    } catch (\Exception $e) {
        Log::error('Tenant registration failed: ' . $e->getMessage());
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
}
// public function register_tenant(Request $request)
// {
// //    dd($request->all());
//     try {
//         DB::beginTransaction();
//         Log::info('Starting tenant registration process.');

//         // ✅ Step 1: Validation
//         $validatedData = $request->validate([
//             'company_name' => 'required|string|max:255',
//             'username' => 'required|string|unique:tenants,username',
//             'name' => 'required|string|max:255|unique:tenants,name',
//             'email' => 'required|email|unique:users,email',
//             'password' => 'required|string|min:6|confirmed',
//             'phone' => 'nullable|string|max:20',
//             'country_id' => 'nullable|integer|exists:countries,id',
//             'state_id' => 'nullable|integer|exists:states,id',
//             'city_name' => 'nullable|string|max:100',
//             'zip_code' => 'nullable|string|max:20',
//             'address' => 'nullable|string|max:255',
//             'domain_name' => 'nullable|string|max:255|unique:domains,domain',
//             'seperate_domain' => 'nullable|boolean',
//             'g-recaptcha-response' => 'nullable',
//         ]);

//         // ✅ Step 2: Generate Unique Tenant ID (slug)
//         $slug = Str::slug($request->company_name);
//         $tenantId = $slug;
//         $counter = 1;
//         while (Tenant::find($tenantId)) {
//             $tenantId = $slug . '-' . $counter++;
//         }

//         Log::info('Validation passed. Creating tenant: ' . $tenantId);

//         // ✅ Step 3: Create Tenant Record
//         $tenant = Tenant::create([
//             'id' => $tenantId,
//             'company_name' => $validatedData['company_name'],
//             'username' => $validatedData['username'],
//             'name' => $validatedData['name'],
//             'email' => $validatedData['email'],
//             'password' => Hash::make($validatedData['password']),
//             'phone' => $request->phone,
//             'country_id' => $request->country_id,
//             'state_id' => $request->state_id,
//             'city_name' => $request->city_name,
//             'zip_code' => $request->zip_code,
//             'address' => $request->address,
//         ]);

//         Log::info('Tenant created successfully.', ['tenant_id' => $tenant->id]);

//         // ✅ Step 4: Determine domain
//         if ($request->has('seperate_domain') && $request->seperate_domain) {
//             $domain = $request->domain_name; // Custom domain
//         } else {
//             $domain = $tenantId . '.' . config('app.domain');
//         }

//         // ✅ Step 5: Register domain
//         $tenant->update(['domain_name' => $domain]);
//         $tenant->domains()->create(['domain' => $domain]);

//         // ✅ Step 6: Create Admin User in Central DB
//         $admin = User::create([
//             'tenant_id' => $tenant->id,
//             'company_name' => $request->company_name,
//             'username' => $request->username,
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//             'phone' => $request->phone,
//             'country_id' => $request->country_id,
//             'state_id' => $request->state_id,
//             'city_name' => $request->city_name,
//             'zip_code' => $request->zip_code,
//             'address' => $request->address,
//         ]);

//         // Assign admin role
//         $roleName = 'Admin';
//         $role = Role::firstOrCreate(['name' => $roleName]);
//         $admin->assignRole($roleName);

//         // ✅ Step 7: Create Admin User in Tenant DB
//         $tenant->run(function () use ($request) {
//             User::create([
//                 'company_name' => $request->company_name,
//                 'username' => $request->username,
//                 'name' => $request->name,
//                 'email' => $request->email,
//                 'password' => Hash::make($request->password),
//                 'phone' => $request->phone,
//                 'country_id' => $request->country_id,
//                 'state_id' => $request->state_id,
//                 'city_name' => $request->city_name,
//                 'zip_code' => $request->zip_code,
//                 'address' => $request->address,
//             ]);
//         });

//         DB::commit();
//         // ✅ Step 8: Send Notification Emails
//         $superadminEmail = config('mail.superadmin');
//         try {
//             Mail::to($superadminEmail)->send(new SuperAdminTenantRegisteredMail($tenant));
//             Mail::to($tenant->email)->send(new TenantRegisteredMail($tenant));
//         } catch (\Exception $mailEx) {
//             Log::warning('Mail sending failed: ' . $mailEx->getMessage());
//         }

//         Log::info('Tenant registration completed successfully.');

//         // // ✅ Step 9: Redirect to new tenant domain
//         // if ($request->has('seperate_domain') && $request->seperate_domain) {
//         //     return back()->with('success', 'Tenant registered successfully!');
//         // } else {
//         //     $tenantUrl = "http://{$domain}";
//         //     return redirect()->away($tenantUrl);
//         // }

//     } catch (\Illuminate\Validation\ValidationException $e) {
//         DB::rollBack();
//         return back()->withErrors($e->errors())->withInput();
//     } catch (\Illuminate\Database\QueryException $e) {
//         Log::error('Database Error: ' . $e->getMessage());
//         return back()->withErrors(['error' => 'Database error: ' . $e->getMessage()])->withInput();
//     } catch (\Exception $e) {
//         Log::error('Unexpected Error: ' . $e->getMessage());
//         return back()->withErrors(['error' => $e->getMessage()])->withInput();
//     }
// }

    public function tenant_index()
    {
        return view('tenants.index');
    }
    public function tenant_dashboard()
    {
        if(Auth::user()->hasRole('Admin'))
        {



            $users = User::get();
$tenant = Tenant::get();

$totalUsers = $users->count();

$dealerCount = User::role('Dealer')->count();
// $tenantCount = $tenant->count();
$representativeCount = User::role('Representative')->count();
$distributorCount = User::role('Distributor')->count();
$showroomCount = User::role('Showroom')->count();


            return view('tenants.dashboard',compact('totalUsers','dealerCount','representativeCount','distributorCount','showroomCount'));
            // return view('tenants.dashboard');

        }
        else
        {
            return view('tenants.representative_modals.dashboard');
        }
    }
}
