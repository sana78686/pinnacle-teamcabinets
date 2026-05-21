<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Country;
use App\Models\County;
use App\Models\DoorColors;
use App\Models\ProductCatalog;
use App\Models\State;
use App\Mail\UserAccountVerificationMail;
use App\Mail\UserAccountActivationMail;
use App\Mail\UserAccountDeactivationMail;
use App\Mail\UserRegisteredByAdminMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Imports\UserImport;
use App\Exports\UserExport;
use App\Models\UserColumnPreference;
use App\Models\PointFactorDefault;
use App\Models\UsersCatalogDoorPointFactor;
use App\Models\UsersCatalogVisibility;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;



use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
use App\Services\TenantNotificationService;

class TenantUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        $savedColumns = UserColumnPreference::where('user_id', Auth::id())
            ->where('module', 'users')
            ->first();

        $defaultColumns = ['#', 'Type', 'Username', 'Full Name', 'Email', 'Status', 'Created On', 'Actions'];

        $data['columns'] = $savedColumns ? json_decode($savedColumns->columns, true) : $defaultColumns;

        if ($request->filled('name')) {
            $query->where('name', 'LIKE', '%'.$request->name.'%');
        }

        if ($request->filled('username')) {
            $query->where('username', 'LIKE', '%'.$request->username.'%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'LIKE', '%'.$request->email.'%');
        }

        $data['users'] = $query->latest()->paginate(tenant_list_per_page())->withQueryString();

        return view('tenants.users.index', $data);
    }

    public function search(Request $request)
    {
        $field = $request->field;
        $query = $request->query('query', '');

        if (!in_array($field, ['name', 'username', 'email'])) {
            return response()->json([], 400);
        }


        $results = User::where($field, 'LIKE', '%' . $query . '%')
            ->select('id', 'name', 'username', 'email')
            ->get();

        return response()->json($results);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $data = [];
        $data['product_catalogs'] = ProductCatalog::where('status', 1)->get();
        $data['door_colors'] = DoorColors::with('productCatalog')->get();
        $data['countries'] = Country::where('id', '233')->pluck('name', 'name')->all();
        $data['states'] = State::where('country_id', '233')->pluck('name', 'name')->all();
        $data['cities'] = City::where('country_id', '233')->pluck('name', 'name')->all();
        $data['counties'] = County::pluck('name', 'name')->all();
        $data['point_factor_defaults'] = PointFactorDefault::query()
            ->pluck('point_factor_percentage', 'user_type')
            ->map(fn ($v) => (string) $v)
            ->all();
        $data['has_point_factor_defaults'] = count($data['point_factor_defaults']) > 0;
        $data['has_product_catalogs'] = $data['product_catalogs']->isNotEmpty();
        $data['has_door_styles'] = $data['door_colors']->isNotEmpty();
        $data['door_factor_setup_incomplete'] = ! $data['has_point_factor_defaults']
            || ! $data['has_product_catalogs']
            || ! $data['has_door_styles'];

        return view('tenants.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        // Log::info('Request Data', $request->all());dd($request->header('Content-Type'));
        // dd($request->all());

        try {
            $role = Role::where('id', $request->role_id)->orWhere('name', $request->role)->first();
            Log::info('Role Found');
            if (!$role) {
                Log::info('Role Not Found');
                return back()->with('error', 'Selected role does not exist.');
            }
            $validatedData = $request->validate([
                'role_id'      => 'required',
                'username'     => 'required',
                'name'         => 'required',
                'phone'        => 'required',
                'email'        => 'required|email|unique:users,email',
                'country_id'   => 'required',
                'state_id'     => 'required',
                'password'     => 'nullable|string|min:8',
                // 'city_id'    => 'required',
            ]);

            $plainPassword = $request->filled('password')
                ? (string) $request->password
                : Str::password(12);

            Log::info('Validated Data', $validatedData);
            // dd($validatedData, $validatedData['name']);
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($plainPassword),
                'username' => $validatedData['username'],
                'phone' => $validatedData['phone'],
                'country_id' => $validatedData['country_id'],
                'state_id' => $validatedData['state_id'],
                // 'city_id' => $validatedData['city_id'],
                'city_name' => $request->city_name,
                'county_name' => $request->county_name,
                'zip_code' => $request->zip_code,
                'address' => $request->address,
                'note' => $request->note,
                // 'is_taxable_user' => $request->is_taxable_user,
                'company_name' => $request->business_name,
                // 'gross_sale' => $request->gross_sale,
                'status' => $request->status,
            ]);

            Log::info('User Created');
            if($request->is_taxable_user || $request->is_taxable_user === 'on')
            {
                $user->update([

                'is_taxable_user' => 1,
                ]);
            }

            Log::info('Tax Exempted');
            $user->assignRole($role->name);

            Log::info('Role Assigned');

            if ($request->status === 'approved') {
                $user->update([
                    'is_verified_by_admin' => true,
                    'is_verified' => true,
                ]);
            }

            // DB::beginTransaction();
            try {
                // Ensure catalog_visibility exists
                if ($request->has('catalog_visibility')) {
                    foreach ($request->input('catalog_visibility', []) as $catalog_id) {
                        // Save catalog visibility
                        $catalogVisibility = UsersCatalogVisibility::create([
                            'user_id' => $user->id,
                            'catalog_id' => $catalog_id,
                        ]);

                        Log::info('Catalog Provides');

                        // Ensure door factors exist for this catalog
                        if ($request->has("door_factors.$catalog_id")) {
                            foreach ($request->input("door_factors.$catalog_id", []) as $door_color_id => $factor) {
                                $factor = trim($factor); // Remove whitespace

                                if (!empty($factor)) { // Save only if factor is not empty
                                    UsersCatalogDoorPointFactor::create([
                                        'user_catalog_visibility_id' => $catalogVisibility->id,
                                        'user_id' => $user->id,
                                        'catalog_id' => $catalog_id,
                                        'door_style' => $door_color_id, // The door color ID
                                        'factor' => $factor,
                                    ]);

                                    Log::info('Assigned Door Factors');
                                }
                            }
                        }
                    }
                }

                $this->sendUserRegisteredByAdminEmail($user, $plainPassword);

                return redirect()->route('tenant_user_index')->with(
                    'success',
                    'User created successfully. Login details were emailed to '.$user->email.'.'
                );
            } catch (\Exception $e) {
                // DB::rollBack(); // Rollback on failure

                // **Log the error**
                Log::error('Error in store method:', [
                    'message' => $e->getMessage(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);

                session()->flash('error', 'User cannot be created. Reason: ' . $e->getMessage());
                // Redirect back to the registration form
                return redirect()->back();
            }

            return redirect()->route('tenant_user_index')
            ->with('success', 'User created successfully');
        } catch (\Exception $e) {
            // Flash error message
            session()->flash('error', 'User cannot be created. Reason: ' . $e->getMessage());
            // Redirect back to the registration form
            return redirect()->back();
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with(['catalogVisibilities.productCatalog', 'catalogVisibilities', 'doorFactors.doorStyle'])->findOrFail($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return view('tenants.users.show', compact('user'));
    }

    // public function show($id): View
    // {

    //     $user = User::find($id);

    //     return view('tenants.users.show', compact('user'));
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $data = [];
        $edit_user = User::find($id);
        $data['user'] = User::with(['catalogVisibilities'])->find($id); // Eager load the catalogVisibilities relationship
        $data['product_catalogs'] = ProductCatalog::where('status', 1)->get();
            $data['countries'] = Country::where('id', 233)->pluck('name', 'id');
        $data['states'] = State::where('country_id', 233)->pluck('name', 'id');
        $data['cities'] = City::where('country_id', 233)->pluck('name', 'id');

        $data['counties'] = County::pluck('name', 'name')->all();
        $data['door_colors'] = DoorColors::with('productCatalog')->get();
        $data['roles'] = Role::get();
        // dd($data['cities']);

          // ✅ Get the user's first role ID via Spatie
        $data['user_role_id'] = $data['user']->roles()->pluck('id')->first();
        // Get selected catalogs for the user
        $data['selected_catalogs'] = UsersCatalogVisibility::where('user_id', $id)
                                                                ->pluck('catalog_id')
                                                                ->toArray();

        // Get all door colors & factor values for the selected catalogs
        $existing_factors = [];
        $data['door_factors'] = $door_factors = UsersCatalogDoorPointFactor::where('user_id', $id)->get();

        // Get existing factors for the selected catalogs
        $data['existing_factors'] = UsersCatalogDoorPointFactor::where('user_id', $id)
                            ->get()
                            ->groupBy('catalog_id');
        foreach ($door_factors as $factor) {
        $existing_factors[$factor->catalog_id][$factor->door_style] = $factor->factor;
        }

        // dd($data);
        return view('tenants.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // dd($request->all());
        // Find the user by ID
        $user = User::find($id);
        $role = Role::where('id', $request->role_id)->orWhere('name', $request->role)->first();

        if (!$user) {
            return redirect()->route('tenant_user_index')->with('error', 'User not found.');
        }

        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required'
        ]);
        // If password is not provided, retain the old password
        if (empty($validatedData['password'])) {
            unset($validatedData['password']); // Remove password from data
        } else {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->username         = $request->username;
        $user->name         = $request->name;
        $user->phone         = $request->phone;
        $user->email         = $request->email;
        $user->country_id         = $request->country_id;
        $user->state_id         = $request->state_id;
        $user->city_name         = $request->city_name;
        $user->county_name         = $request->county_name;
        $user->zip_code         = $request->zip_code;
        $user->address         = $request->address;
        $user->note            = $request->note;
        $user->company_name    = $request->business_name;
        $user->gross_sale      = $request->gross_sale;
        $user->status          = $request->status;
        $user->save();
        // Update the user
        // $user->update($validatedData);

        $user->update([
            'is_taxable_user' => ($request->is_taxable_user || $request->is_taxable_user === 'on') ? 1 : 0,
        ]);

        if($request->password)
        {
            $user->update([

            'password' => Hash::make($request->password),
            ]);
        }

        Log::info('Tax Exempted');
        // Remove old roles and assign new ones
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($role->name);

        DB::beginTransaction();
        try {
            // Delete old catalog visibility records
            UsersCatalogVisibility::where('user_id', $user->id)->forceDelete();
            UsersCatalogDoorPointFactor::where('user_id', $user->id)->forceDelete();

            $catalogVisibility = $request->input('catalog_visibility', []);

            foreach ($catalogVisibility as $catalog_id) {
                $catalogVisibility = UsersCatalogVisibility::create([
                    'user_id' => $user->id,
                    'catalog_id' => $catalog_id,
                ]);

                // Ensure door factors exist for this catalog
                if ($request->has("door_factors.$catalog_id")) {
                    foreach ($request->input("door_factors.$catalog_id", []) as $door_color_id => $factor) {
                        $factor = trim($factor); // Remove whitespace

                        if (!empty($factor)) { // Save only if factor is not empty
                            UsersCatalogDoorPointFactor::create([
                                'user_catalog_visibility_id' => $catalogVisibility->id,
                                'user_id' => $user->id,
                                'catalog_id' => $catalog_id,
                                'door_style' => $door_color_id,
                                'factor' => $factor,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->route('tenant_user_index')->with('success', 'Data updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error updating catalog visibility:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('tenant_user_index')->with('error', 'An error occurred. Check logs for details.');
        }
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    try {
        // Find the user by ID
        $user = User::findOrFail($id);

        //update status to "block"  before status

        $user->status="block";
        $user->save();

        // Perform soft delete

        $user->delete();

        // Redirect back with success message
        return redirect()->back()->with('success', 'User deleted successfully');
    } catch (\Exception $e) {
        // If something goes wrong, show an error message
        return redirect()->route('tenant_user_index')->with('error', 'Failed to delete the user');
    }
}

public function updateVerification(Request $request, $id)
{
    $user = User::findOrFail($id);

    if ($user->is_verified_by_admin) {
        return response()->json(['success' => false, 'message' => 'User already verified.']);
    }

    $user->is_verified_by_admin = true;
    $user->is_verified = true;
    $user->status = $user->status === 'block' ? 'block' : 'approved';
    $user->save();

    Mail::to($user->email)->send(new UserAccountVerificationMail($user));

    TenantNotificationService::notifyUser(
        $user,
        'Account approved',
        'Your account has been approved. You can now sign in to the dealer panel.',
        route('tenant_login'),
        'success'
    );

    return response()->json(['success' => true, 'message' => 'User verified successfully.']);
}


public function updateStatus(Request $request, $id)
{
    Log::info("Updating status for user ID: $id");

    $user = User::findOrFail($id);

    $newStatus = $request->status;

    if (!in_array($newStatus, ['active', 'deactive'])) {
        return response()->json(['success' => false, 'message' => 'Invalid status']);
    }

    $user->status = $newStatus;
    $user->save();

    // ✅ Send the appropriate email based on new status
    if ($newStatus === 'active') {
        Mail::to($user->email)->send(new UserAccountActivationMail($user));
    } elseif ($newStatus === 'deactive') {
        Mail::to($user->email)->send(new UserAccountDeactivationMail($user));
    }

    return response()->json([
        'success' => true,
        'message' => 'User status updated successfully.'
    ]);
}

    protected function sendUserRegisteredByAdminEmail(User $user, string $plainPassword): void
    {
        try {
            Mail::to($user->email)->send(new UserRegisteredByAdminMail($user, $plainPassword));

            TenantNotificationService::notifyUser(
                $user,
                'Your account is ready',
                'An email with your login link and credentials was sent to '.$user->email.'.',
                route('tenant_login'),
                'success'
            );
        } catch (\Throwable $e) {
            Log::warning('Failed to send admin-created user welcome email', [
                'user_id' => $user->id,
                'email' => $user->email,
                'message' => $e->getMessage(),
            ]);
            session()->flash(
                'error',
                'User was created but the welcome email could not be sent. Share login details manually. ('.$e->getMessage().')'
            );
        }
    }

    public function roleAutoComplete(Request $request)

    {
        $data = [];
        $query = $request->get('q', '');
            $data = Role::select('id', 'name')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->limit(10)
                ->get();

        return response()->json($data);
    }
    public function countryAutoComplete(Request $request)

    {
        $data = [];
        $query = $request->get('q', '');
            $data = Country::select('id', 'name')->where('id', '233')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->limit(10)
                ->get();

        return response()->json($data);
    }
    public function stateAutoComplete(Request $request)
    {
        $data = [];
        $query = $request->get('q', '');
        $countryId = $request->get('country_id', null);

        if ($countryId) {
            $data = State::select('id', 'name')
                ->where('country_id', 233)
                ->where('name', 'LIKE', '%' . $query . '%')
                ->limit(10)
                ->get();
        }

        return response()->json($data);
    }

    public function cityAutoComplete(Request $request)
    {
        $data = [];
        $query = $request->get('q', '');
        $stateId = $request->get('state_id', null);

        if ($stateId) {
            $data = City::select('id', 'name')
                ->where('state_id', $stateId)
                ->where('country_id', 233)
                ->where('name', 'LIKE', '%' . $query . '%')
                ->limit(10)
                ->get();
        }

        return response()->json($data);
    }

    // public function cityAutoComplete(Request $request)

    // {
    //     $data = [];
    //     $query = $request->get('q', '');
    //         $data = City::select('id', 'name')
    //             ->where('name', 'LIKE', '%' . $query . '%')
    //             ->limit(10)
    //             ->get();

    //     return response()->json($data);
    // }
    public function countyAutoComplete(Request $request)

    {
        $data = [];
        $query = $request->get('q', '');
            $data = County::select('id', 'name')
                ->where('name', 'LIKE', '%' . $query . '%')
                ->limit(10)
                ->get();

        return response()->json($data);
    }
    public function showDetails($id)
    {
        dd('here');
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found']);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'roles' => $user->getRoleNames()->toArray(),
                'username' => $user->username,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'company_name' => $user->company_name,
                'status' => ucfirst($user->status),
                'created_at' => $user->created_at->format('d-m-Y'),
            ],
        ]);
    }
    public function deletedUsersList()
    {
        $data['users'] = User::onlyTrashed()->latest()->paginate(tenant_list_per_page())->withQueryString();

        return view('tenants.users.deleted_users_list', $data);
    }
    public function restoreDeletedUser($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);

        if (!$user) {
            session()->flash('error', 'User cannot found.');
            return redirect()->back();
        }

        //change status to un-approved
        $user->restore();
        $user->status="un-approved";
        $user->save();// Restore the user
        return redirect()->route('tenant_user_index')
            ->with('success', 'User.'.$user->name.'. Restored successfully!');

    }

    // public function import(Request $request)
    // {
    //     $failedImports = [];
    //     $successfulImports = [];

    //     if ($request->hasFile('userFile') && $request->file('userFile')->isValid()) {
    //         // Define the import
    //         $import = Excel::import(new UserImport, $request->file('userFile'));

    //         // Get the failed imports (if any)
    //         $failedImports = $import->failures();

    //         // Handle successful imports (if any)
    //         $successfulImports = $import->getRows();

    //         return back()->with([
    //             'success' => 'Users imported successfully!',
    //             'imported_data' => $successfulImports,
    //             'failed_data' => $failedImports,
    //         ]);
    //     }

    //     return back()->with('error', 'Invalid file, please try again.');
    // }



    public function import(Request $request)
    {
        Log::info("Received request data: ", $request->all());

        // Check if a file is actually uploaded
        if (!$request->hasFile('userFile')) {
            Log::error("No file uploaded.");
            return redirect()->back()->withErrors(['userFile' => 'No file was uploaded.'])->withInput();
        }

        // Get file info
        $file = $request->file('userFile');
        Log::info("Uploaded file details:", [
            'Original Name' => $file->getClientOriginalName(),
            'MIME Type' => $file->getMimeType(),
            'Extension' => $file->getClientOriginalExtension(),
            'Real Path' => $file->getRealPath(),
        ]);
        // Manually validate the request
        $validator = Validator::make($request->all(), [
            'userFile' => 'required|file|mimes:xlsx,xls,csv,txt|max:2048',  // Ensure it's an Excel/CSV file and limit size
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            Log::error("Validation failed: ", $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Log::info("Validation passed. Processing file...");
        $file = $request->file('userFile');
        $extension = strtolower($file->getClientOriginalExtension());

        $allowedExtensions = ['csv', 'xlsx', 'xls'];
        if (!in_array($extension, $allowedExtensions)) {
            Log::error("Invalid file extension: " . $extension);
            return redirect()->back()->withErrors(['userFile' => 'Invalid file format.'])->withInput();
        }
        // Process file import
        Excel::import(new UserImport, $request->file('userFile'));

        Log::info("File imported successfully.");
        return redirect()->back()->with('success', "Successfully Imported");
    }


    public function export()
    {
        return Excel::download(new UserExport, 'users.xlsx');
    }

    public function role_child(Request $request): View
    {
        $auth = Auth::user();
        $data['users'] = User::where('parent_id', $auth->id)
            ->latest()
            ->paginate(tenant_list_per_page())
            ->withQueryString();

        return view('tenants.representative_modals.users.index', $data);
    }
    public function childRoleAutoComplete(Request $request)

    {
        $data = [];
        if(Auth::user()->hasRole('Representative'))
        {
        $query = $request->get('q', '');
            $data = Role::select('id', 'name')
                ->whereNotIn('name', ['Admin', 'Representative'])
                ->where('name', 'LIKE', '%' . $query . '%')
                ->limit(10)
                ->get();
        }
        else
        {

        $query = $request->get('q', '');
        $data = Role::select('id', 'name')
            ->whereIn('name', ['Customer'])
            ->where('name', 'LIKE', '%' . $query . '%')
            ->limit(10)
            ->get();
        }
        return response()->json($data);
    }

    public function child_create(): View
    {
        $data = [];
        $data['product_catalogs'] = ProductCatalog::where('status', 1)->get();
        $data['door_colors'] = DoorColors::with('productCatalog')->get();
        $data['countries'] = Country::where('id', '233')->pluck('name', 'name')->all();
        $data['states'] = State::where('country_id', '233')->pluck('name', 'name')->all();
        $data['cities'] = City::where('country_id', '233')->pluck('name', 'name')->all();
        $data['counties'] = County::pluck('name', 'name')->all();
        // dd($data['door_colors']);
        return view('tenants.representative_modals.users.create', $data);
    }

    public function deletedChildUsersList()
    {
        $auth = Auth::user();
        $data['users'] = User::where('parent_id', $auth->id)
            ->onlyTrashed()
            ->latest()
            ->paginate(tenant_list_per_page())
            ->withQueryString();

        return view('tenants.representative_modals.users.deleted_users_list', $data);
    }

    public function childStore(Request $request): RedirectResponse
    {
        $auth = Auth::user();
        try {
            $role = Role::where('id', $request->role_id)->orWhere('name', $request->role)->first();
            Log::info('Role Found');
            if (!$role) {
                Log::info('Role Not Found');
                return back()->with('error', 'Selected role does not exist.');
            }
            $validatedData = $request->validate([
                'role_id'       => 'required',
                'username'      => 'required',
                'name'          => 'required',
                'phone'         => 'required',
                'email'         => 'required|email|unique:users,email',
                'country_id'    => 'required',
                'state_id'    => 'required',
                // 'city_id'    => 'required',
            ]);

            Log::info('Validated Data', $validatedData);
            // dd($validatedData, $validatedData['name']);
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($request['password']),
                'username' => $validatedData['username'],
                'phone' => $validatedData['phone'],
                'country_id' => $validatedData['country_id'],
                'parent_id' => $auth->id,
                'state_id' => $validatedData['state_id'],
                // 'city_id' => $validatedData['city_id'],
                'city_name' => $request->city_name,
                'county_name' => $request->county_name,
                'zip_code' => $request->zip_code,
                'address' => $request->address,
                'note' => $request->note,
                // 'is_taxable_user' => $request->is_taxable_user,
                'company_name' => $request->business_name,
                // 'gross_sale' => $request->gross_sale,
                'status' => $request->status,
            ]);

            Log::info('User Created');

            $user->assignRole($role->name);

            Log::info('Role Assigned');

            return redirect()->route('tenant_user_child_index')
            ->with('success', 'User created successfully');
        } catch (\Exception $e) {
            // Flash error message
            session()->flash('error', 'User cannot be created. Reason: ' . $e->getMessage());
            // Redirect back to the registration form
            return redirect()->back();
        }
    }
    public function showChild($id)
    {
        $auth = Auth::user();
        $user = User::where('parent_id', $auth->id)->with(['catalogVisibilities.productCatalog', 'catalogVisibilities', 'doorFactors.doorStyle'])->findOrFail($id);
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        return view('tenants.representative_modals.users.show', compact('user'));
    }

    public function downloadCSV()
    {
        $filePath = public_path('assets/samples_csv/Users_sample.csv');

        if (!file_exists($filePath)) {
            return back()->with('error', 'File not found.');
        }
        return response()->download($filePath, 'Users_sample.csv', [
            'Content-Type' => 'text/csv',
        ]);
    }



    public function importCSV(Request $request)
    {


        $request->validate([
            'userFile' => 'required|file|mimes:xlsx,xls,csv|max:2048',
        ]);
        $file = $request->file('userFile');
        $extension = $file->getClientOriginalExtension();
        if (in_array($extension, ['xlsx', 'xls'])) {
            // Excel file import
            Excel::import(new UserImport, $file);
            return back()->with('success', 'Excel file imported successfully.');
        }
        try {
            // CSV File Import
            $csvData = array_map('str_getcsv', file($file->getRealPath()));
            $headers = array_map('trim', array_shift($csvData)); // Remove header row and trim spaces
            foreach ($csvData as $row) {
                $data = array_combine($headers, array_map('trim', $row));

                if (!isset($data['email']) || !isset($data['username']) || !isset($data['phone']) || !isset($data['user_type'])) {
                    Log::error('Missing required fields in CSV row:', $data);
                    continue; // Skip invalid row
                }
                DB::transaction(function () use ($data) {
                    // Check if user already exists by email
                    $user = User::updateOrCreate(
                        ['email' => $data['email']],
                        [
                            'username'       => $data['username'] ?? null,
                            'phone'          => $data['phone'] ?? null,
                            'name'          => $data['first_name'] ?? null,
                            'password'       => isset($data['password']) ? Hash::make($data['password']) : Hash::make('defaultPass123'),
                            'country_name'   => $data['country_name'] ?? null,
                            'county'         => $data['county'] ?? null,
                            'city'           => $data['city'] ?? null,
                            'state'          => $data['state'] ?? null,
                            'zip'            => $data['zip'] ?? null,
                            'address'        => $data['address'] ?? null,
                            'note'           => $data['note'] ?? null,
                            'status'         => $data['Status'] ?? 'pending',
                        ]
                    );
                    // Assign Role
                    $role = Role::firstOrCreate(['name' => $data['user_type']]);
                    $user->assignRole($role->name);
                });
            }
            return back()->with('success', 'CSV file imported successfully.');
        } catch (\Exception $e) {
            Log::error('CSV Import Error: ' . $e->getMessage());
            return back()->with('error', 'CSV import failed. Please check the file format.');
        }
    }

}


