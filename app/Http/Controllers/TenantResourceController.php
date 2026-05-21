<?php

namespace App\Http\Controllers;

use App\Services\TenantProvisioningService;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use App\Rules\ReCaptcha;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class TenantResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['tenants'] = Tenant::all()->map(function ($tenant) {
            $owner = User::where('tenant_id', $tenant->id)->first(); // Fetch owner from users table
            return [
                'tenant' => $tenant,
                'owner' => $owner,
            ];
        });
        return view('backend.tenants.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // return view('backend.tenants.auth.register2');
        return view('backend.tenants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
        Log::info('Starting tenant creation.');
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'username' => 'required|string|unique:tenants,username',
                'name' => 'required|string|max:255|unique:tenants,name',
                // 'g-recaptcha-response' => ['required' // , new ReCaptcha ],
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:3',
                'domain_name' => 'required|max:255|unique:domains,domain',
                'g-recaptcha-response' => 'nullable'
            ]);
            $slug = Str::slug($request->domain_name);

            // Ensure slug is unique
            $tenantId = $slug;
            $counter = 1;
            while (Tenant::find($tenantId)) {
                $tenantId = $slug . '-' . $counter;
                $counter++;
            }
            Log::info('Validation passed.');
                try {
                    // Create the tenant
                    $tenant = Tenant::create($validatedData);
                    // $tenant = Tenant::create([
                    //     'id' => $tenantId,
                    //     'name' => $validatedData['name'],
                    //     'username' => $validatedData['username'],
                    //     'email' => $validatedData['email'],
                    //     'password' => Hash::make($validatedData['password']),
                    //     'company_name' => $validatedData['company_name'],
                    //     'domain_name' => $validatedData['domain_name'],
                    // ]);
                    Log::info('Tenant created successfully.', $tenant->toArray());

                } catch (\Exception $e) {
                    Log::error('Error creating tenant: ' . $e->getMessage());
                    return redirect()->back()->withErrors(['error' => 'Unable to create tenant.']);
                }
                // Determine domain type
                if ($request->has('seperate_domain') && $request->seperate_domain) {
                    $domain = $request->domain_name; // Custom domain
                } else {
                    $domain = $tenantId.'.'.config('app.domain');
                }

                // Register the tenant's domain
                if ($tenant->domain_name) {
                    $tenant->domains()->create([
                        'domain' => $domain,
                    ]);
                }

                // Create the admin user in the main database
                $user = User::create([
                    'tenant_id' => $tenant->id,
                    'company_name' => $request->company_name,
                    'name' => $request->name,
                    'username' => $validatedData['username'],
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'status' => 'active',
                    'is_verified_by_admin' => true,
                    'is_verified' => true,
                ]);

                app(TenantProvisioningService::class)->provision($tenant, $user);
            //    $superadminEmail = config('mail.superadmin');

            //     // Send emails
            //     Mail::to($superadminEmail)->send(new SuperAdminTenantRegisteredMail($tenant));
            //     Mail::to($tenant->email)->send(new TenantRegisteredMail($tenant));

                if ($request->has('seperate_domain') && $request->seperate_domain) {
                    // $tenantUrl = $tenant->domain_name;
                    return redirect()->back()->with('success', 'Tenant registered successfully!');
                }

                return redirect(tenant_url($tenantId));
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422); // Return validation errors
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database-related errors
            Log::error('Database Error:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'A database error occurred.', 'error' => $e->getMessage()], 500);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return response()->json(['message' => 'Validation failed.', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Handle any other exceptions
            Log::error('Unexpected Error:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'An unexpected error occurred.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        //
    }
}
