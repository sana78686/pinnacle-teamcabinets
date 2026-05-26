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
use App\Mail\AffiliateRegisteredMail;
use App\Mail\UserRegisteredByAdminMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
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
use App\Services\AdminRecordViewService;
use App\Services\ManageCommissionService;
use App\Services\TenantNavBadgeService;
use App\Services\TenantNotificationService;
use App\Services\UserDoorFactorService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Support\TenantListPaginator;

class TenantUserController extends Controller
{
    public function __construct(
        protected UserDoorFactorService $doorFactors,
        protected ManageCommissionService $commissions
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, TenantNavBadgeService $navBadges): View|JsonResponse
    {
        $savedColumns = UserColumnPreference::where('user_id', Auth::id())
            ->where('module', 'users')
            ->first();

        $defaultColumns = ['#', 'Type', 'Username', 'Full Name', 'Email', 'Status', 'Created On', 'Actions'];

        $data['columns'] = $savedColumns ? json_decode($savedColumns->columns, true) : $defaultColumns;

        $search = TenantListPaginator::search($request);
        $perPage = TenantListPaginator::perPage($request);
        $users = $this->userListQuery($request)->latest()->paginate($perPage)->withQueryString();

        $data['users'] = $users;
        $data['search'] = $search;
        $data['perPage'] = $perPage;

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'rows' => view('tenants.users.partials.list-rows', [
                    'users' => $users,
                    'search' => $search,
                ])->render(),
                'pagination' => $users->total() > 0
                    ? view('partials.tenant-pagination', ['paginator' => $users])->render()
                    : '',
                'meta' => [
                    'total' => $users->total(),
                    'from' => $users->firstItem() ?? 0,
                    'to' => $users->lastItem() ?? 0,
                ],
                'url' => $users->url($users->currentPage()),
            ]);
        }

        $data['point_factor_defaults'] = PointFactorDefault::query()
            ->pluck('point_factor_percentage', 'user_type')
            ->map(fn ($v) => (string) $v)
            ->all();

        return view('tenants.users.index', $data);
    }

    /** @return array<string, mixed> */
    protected function doorFactorBootstrapData(): array
    {
        $product_catalogs = ProductCatalog::query()->where('status', 1)->orderBy('name')->get(['id', 'name', 'status']);
        $catalogIds = $product_catalogs->pluck('id');

        $door_colors = $catalogIds->isEmpty()
            ? collect()
            : DoorColors::query()
                ->whereIn('product_catalog_id', $catalogIds)
                ->orderBy('product_label')
                ->get(['id', 'product_catalog_id', 'product_label', 'status']);

        $point_factor_defaults = PointFactorDefault::query()
            ->pluck('point_factor_percentage', 'user_type')
            ->map(fn ($v) => (string) $v)
            ->all();
        $has_point_factor_defaults = count($point_factor_defaults) > 0;
        $has_product_catalogs = $product_catalogs->isNotEmpty();
        $has_door_styles = $door_colors->isNotEmpty();

        return [
            'product_catalogs' => $product_catalogs,
            'door_colors' => $door_colors,
            'doors_by_catalog' => $door_colors->groupBy('product_catalog_id'),
            'point_factor_defaults' => $point_factor_defaults,
            'has_point_factor_defaults' => $has_point_factor_defaults,
            'has_product_catalogs' => $has_product_catalogs,
            'has_door_styles' => $has_door_styles,
            'door_factor_setup_incomplete' => ! $has_point_factor_defaults
                || ! $has_product_catalogs
                || ! $has_door_styles,
        ];
    }

    public function autocomplete(Request $request): JsonResponse
    {
        $q = trim((string) $request->get('q', ''));
        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $users = User::query()
            ->where(function (Builder $query) use ($q) {
                $this->applyUserListSearch($query, $q);
            })
            ->with('roles')
            ->select(['id', 'name', 'username', 'email'])
            ->limit(12)
            ->get();

        return response()->json($users->map(function (User $user) {
            $role = $user->getRoleNames()->first() ?? 'N/A';

            return [
                'id' => $user->id,
                'label' => $user->name ?: ($user->username ?: $user->email),
                'subtitle' => trim(($user->email ?? '').' · '.$role, ' · '),
                'value' => $user->name ?: ($user->username ?: $user->email),
            ];
        })->values());
    }

    public function search(Request $request): JsonResponse
    {
        return $this->autocomplete($request);
    }

    protected function userListQuery(Request $request): Builder
    {
        $query = User::query()
            ->withCount([
                'catalogVisibilities as catalogs_configured',
                'doorFactors as door_styles_configured',
            ]);

        $search = TenantListPaginator::search($request);
        if ($search !== '') {
            $this->applyUserListSearch($query, $search);
        }

        if ($request->query('verified') === '0') {
            $query->where('is_verified_by_admin', false);
        } elseif ($request->query('verified') === '1') {
            $query->where('is_verified_by_admin', true);
        }

        return $query;
    }

    protected function applyUserListSearch(Builder $query, string $search): void
    {
        $term = '%'.$search.'%';
        $query->where(function ($q) use ($term) {
            $q->where('name', 'like', $term)
                ->orWhere('username', 'like', $term)
                ->orWhere('email', 'like', $term)
                ->orWhereHas('roles', function ($roleQuery) use ($term) {
                    $roleQuery->where('name', 'like', $term);
                });
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('tenants.users.create', array_merge(
            $this->doorFactorBootstrapData(),
            [
                'roleOptions' => \App\Services\TenantRoleService::roleOptionsForUserForms(),
                'countries' => Country::where('id', 233)->pluck('name', 'id'),
                'states' => State::where('country_id', 233)->pluck('name', 'id'),
            ]
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request): RedirectResponse|JsonResponse
    {
        try {
            $role = Role::where('id', $request->role_id)->orWhere('name', $request->role)->first();
            if (! $role) {
                return $this->userFormErrorResponse($request, 'Selected role does not exist.');
            }

            $validatedData = $request->validated();
            $plainPassword = $request->filled('password')
                ? (string) $request->password
                : Str::password(12);

            $pointFactor = $this->doorFactors->resolvePointFactor($request, $role->name);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($plainPassword),
                'username' => $validatedData['username'],
                'phone' => $validatedData['phone'],
                'country_id' => $validatedData['country_id'],
                'state_id' => $validatedData['state_id'],
                'city_name' => $request->city_name,
                'county_name' => $request->county_name,
                'zip_code' => $request->zip_code,
                'address' => $request->address,
                'note' => $request->note,
                'company_name' => $request->business_name,
                'status' => $request->status,
                'point_factor' => $pointFactor,
                'admin_viewed_at' => now(),
            ]);

            $user->forceFill([
                'is_taxable_user' => ($request->is_taxable_user || $request->is_taxable_user === 'on') ? 1 : 0,
                'is_verified_by_admin' => $request->status === 'approved',
                'is_verified' => $request->status === 'approved',
            ])->save();

            $user->assignCiRole($role->name);

            $this->doorFactors->persistForUser($user, $request);
            $this->commissions->syncFromRequest($user, $request);
            $this->sendUserRegisteredByAdminEmail($user, $plainPassword);

            $message = 'User created successfully. Welcome email will be sent to '.$user->email.'.';

            return $this->userFormSuccessResponse($request, $message);
        } catch (\Exception $e) {
            Log::error('Error in store method:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return $this->userFormErrorResponse($request, 'User cannot be created. Reason: '.$e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, AdminRecordViewService $adminView)
    {
        $user = User::with(['catalogVisibilities.productCatalog', 'catalogVisibilities', 'doorFactors.doorStyle'])->findOrFail($id);

        $adminView->markViewed($user, Auth::user());

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
    public function edit($id, AdminRecordViewService $adminView): View|RedirectResponse
    {
        $data = [];
        $edit_user = User::findOrFail($id);

        if ($blocked = $this->adminUserManagementBlockedResponse($edit_user)) {
            return $blocked;
        }

        $adminView->markViewed($edit_user, Auth::user());
        $data['user'] = User::with(['catalogVisibilities', 'manageCommission'])->find($id);
        $data['gross_sales'] = $this->commissions->grossSalesForUser($data['user']);
        $data['countries'] = Country::where('id', 233)->pluck('name', 'id');
        $data['states'] = State::where('country_id', 233)->pluck('name', 'id');
        $data['cities'] = City::forCountry(233)->orderBy('name')->pluck('name', 'id');

        $data['counties'] = County::pluck('name', 'name')->all();
        $data['roles'] = Role::get();
        // dd($data['cities']);

          // ✅ Get the user's first role ID via Spatie
        $data['user_role_id'] = $data['user']->roles()->pluck('id')->first();
        // Get selected catalogs for the user
        $doorFactors = UsersCatalogDoorPointFactor::query()->where('user_id', $id)->get();
        $existingFactorsMap = [];
        foreach ($doorFactors as $factor) {
            $existingFactorsMap[(int) $factor->catalog_id][(int) $factor->door_style] = $factor->factor;
        }

        $doorFactorValue = function (int $catalogId, int $doorColorId) use ($existingFactorsMap): string {
            $value = $existingFactorsMap[$catalogId][$doorColorId] ?? '';

            return $value !== null && $value !== '' ? (string) $value : '';
        };

        return view('tenants.users.edit', array_merge(
            $this->doorFactorBootstrapData(),
            [
                'user' => $data['user'],
                'gross_sales' => $data['gross_sales'],
                'countries' => $data['countries'],
                'states' => $data['states'],
                'cities' => $data['cities'],
                'counties' => $data['counties'],
                'roles' => $data['roles'],
                'user_role_id' => $data['user_role_id'],
                'selected_catalogs' => UsersCatalogVisibility::query()
                    ->where('user_id', $id)
                    ->pluck('catalog_id')
                    ->map(fn ($catalogId) => (int) $catalogId)
                    ->values()
                    ->all(),
                'doorFactorValue' => $doorFactorValue,
                'modalTitle' => 'Edit Product Catalog Visibility & Point Factors',
            ]
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id): RedirectResponse|JsonResponse
    {
        $user = User::find($id);
        $role = Role::where('id', $request->role_id)->orWhere('name', $request->role)->first();

        if (! $user) {
            return $this->userFormErrorResponse($request, 'User not found.', route('tenant_user_index'));
        }

        if ($blocked = $this->adminUserManagementBlockedResponse($user)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Admin users cannot be edited here.'], 403);
            }

            return $blocked;
        }

        $request->validated();

        if (! $role) {
            return $this->userFormErrorResponse($request, 'Selected role does not exist.');
        }

        $user->fill([
            'username' => $request->username,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'country_id' => $request->country_id,
            'state_id' => $request->state_id,
            'city_name' => $request->city_name,
            'county_name' => $request->county_name,
            'zip_code' => $request->zip_code,
            'address' => $request->address,
            'note' => $request->note,
            'company_name' => $request->business_name,
            'status' => $request->status,
            'is_taxable_user' => ($request->is_taxable_user || $request->is_taxable_user === 'on') ? 1 : 0,
        ]);

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $user->assignCiRole($role->name);

        try {
            $this->doorFactors->persistForUser($user, $request);
            $this->commissions->syncFromRequest($user, $request);

            return $this->userFormSuccessResponse($request, 'User updated successfully.');
        } catch (\Throwable $e) {
            Log::error('Error updating catalog visibility:', [
                'user_id' => $user->id,
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            $message = 'An error occurred while saving door factors.';
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                $message = 'Could not save catalog visibility (duplicate record). Please try again.';
            } elseif (config('app.debug')) {
                $message .= ' '.$e->getMessage();
            }

            return $this->userFormErrorResponse($request, $message);
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

        if ($blocked = $this->adminUserManagementBlockedResponse($user)) {
            return $blocked;
        }

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

    TenantNotificationService::accountApproved($user);

    return response()->json([
        'success' => true,
        'message' => 'User verified successfully.',
        'show_approval_setup' => true,
        'user_id' => $user->id,
    ]);
}

public function approvalSetupForm($id): JsonResponse
{
    $user = User::findOrFail((int) $id);

    if (tenant_user_has_admin_role($user)) {
        return response()->json([
            'success' => false,
            'message' => 'Admin users do not use catalog visibility setup.',
        ], 403);
    }

    $selected_catalogs = UsersCatalogVisibility::query()
        ->where('user_id', $user->id)
        ->pluck('catalog_id')
        ->map(fn ($id) => (int) $id)
        ->all();

    $existing = UsersCatalogDoorPointFactor::query()
        ->where('user_id', $user->id)
        ->get(['catalog_id', 'door_style', 'factor'])
        ->groupBy('catalog_id');

    $doorFactorValue = function ($catalogId, $doorColorId) use ($existing) {
        $row = $existing->get($catalogId)?->firstWhere('door_style', (int) $doorColorId);

        return $row ? (string) $row->factor : '';
    };

    $roleName = $user->roles()->pluck('name')->first();

    return response()->json([
        'success' => true,
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'username' => $user->username,
            'role' => $roleName,
        ],
        'html' => view('tenants.users.partials.approval-setup-modal-body', array_merge(
            $this->doorFactorBootstrapData(),
            [
                'selected_catalogs' => $selected_catalogs,
                'doorFactorValue' => $doorFactorValue,
            ]
        ))->render(),
    ]);
}

public function saveApprovalSetup(Request $request, $id): JsonResponse
{
    $user = User::findOrFail((int) $id);

    if (tenant_user_has_admin_role($user)) {
        return response()->json([
            'success' => false,
            'message' => 'Admin users do not use catalog visibility setup.',
        ], 403);
    }

    $errors = $this->doorFactors->doorFactorValidationErrors($request);
    if ($errors !== null) {
        return response()->json([
            'success' => false,
            'message' => 'Please fix the door factor values below.',
            'errors' => $errors,
        ], 422);
    }

    try {
        $this->doorFactors->persistForUser($user, $request);
    } catch (\Throwable $e) {
        Log::error('Approval catalog setup failed', [
            'user_id' => $user->id,
            'message' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'success' => false,
            'message' => config('app.debug')
                ? 'Could not save catalog settings: '.$e->getMessage()
                : 'Could not save catalog settings. Please try again.',
        ], 500);
    }

    $summary = $this->doorFactors->factorSummary($user);

    return response()->json([
        'success' => true,
        'message' => $summary['catalogs'] > 0
            ? 'Catalog access saved for '.$user->name.'.'
            : 'Saved. No catalogs selected — you can configure them later from Edit user.',
        'summary' => $summary,
    ]);
}

public function updateStatus(Request $request, $id)
{
    Log::info("Updating status for user ID: $id");

    $user = User::findOrFail($id);

    if (tenant_user_has_admin_role($user)) {
        return response()->json([
            'success' => false,
            'message' => 'Admin status cannot be changed from the user list.',
        ]);
    }

    $newStatus = $request->status;

    $allowed = array_keys(tenant_user_status_options());
    if (! in_array($newStatus, $allowed, true)) {
        return response()->json(['success' => false, 'message' => 'Invalid status']);
    }

    $previousStatus = $user->status;
    $user->status = $newStatus;
    $user->save();

    if ($newStatus === 'active' && $previousStatus !== 'active') {
        Mail::to($user->email)->send(new UserAccountActivationMail($user));
    } elseif ($newStatus === 'deactive' && $previousStatus !== 'deactive') {
        Mail::to($user->email)->send(new UserAccountDeactivationMail($user));
        TenantNotificationService::accountDeactivated($user);
    }

    $becameApproved = $newStatus === 'approved' && $previousStatus !== 'approved';

    if ($becameApproved) {
        TenantNotificationService::accountApproved($user);
    }

    return response()->json([
        'success' => true,
        'message' => 'User status updated successfully.',
        'show_approval_setup' => $becameApproved,
        'user_id' => $user->id,
    ]);
}

    protected function adminUserManagementBlockedResponse(User $user): ?RedirectResponse
    {
        if (! tenant_user_has_admin_role($user)) {
            return null;
        }

        return redirect()
            ->route('tenant_user_index')
            ->with('error', 'Admin users cannot be edited or deleted here. Update your account from Settings → Profile.');
    }

    protected function sendUserRegisteredByAdminEmail(User $user, string $plainPassword): void
    {
        $userId = $user->id;
        $email = $user->email;
        $parentId = $user->parent_id;

        dispatch(function () use ($userId, $email, $plainPassword, $parentId) {
            $recipient = User::query()->find($userId);
            if (! $recipient) {
                return;
            }

            try {
                if ($parentId) {
                    $parent = User::query()->find($parentId);
                    if ($parent) {
                        Mail::to($email)->send(new AffiliateRegisteredMail($recipient, $parent, $plainPassword));
                    } else {
                        Mail::to($email)->send(new UserRegisteredByAdminMail($recipient, $plainPassword));
                    }
                } else {
                    Mail::to($email)->send(new UserRegisteredByAdminMail($recipient, $plainPassword));
                }
                TenantNotificationService::accountCreatedByAdmin($recipient);
            } catch (\Throwable $e) {
                Log::warning('Failed to send admin-created user welcome email', [
                    'user_id' => $userId,
                    'email' => $email,
                    'message' => $e->getMessage(),
                ]);
            }
        })->afterResponse();
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

    public function roleDefault(Request $request): JsonResponse
    {
        $role = null;
        if ($request->filled('role_id')) {
            $role = Role::query()->find($request->query('role_id'));
        }
        if (! $role && $request->filled('role')) {
            $role = Role::query()->where('name', $request->query('role'))->first();
        }

        if (! $role) {
            return response()->json([
                'success' => false,
                'message' => 'Role not found.',
            ], 404);
        }

        $default = $this->doorFactors->roleDefaultFactor($role->name);

        return response()->json([
            'success' => true,
            'role' => $role->name,
            'default_factor' => $default,
        ]);
    }

    protected function userFormSuccessResponse(Request $request, string $message): RedirectResponse|JsonResponse
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'redirect' => route('tenant_user_index'),
            ]);
        }

        return redirect()->route('tenant_user_index')->with('success', $message);
    }

    protected function userFormErrorResponse(Request $request, string $message, ?string $redirectRoute = null): RedirectResponse|JsonResponse
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }

        return redirect()->back()->with('error', $message);
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
        $user->status = config('tenant_user.default_status', 'un-approved');
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
        if (Auth::user()->isRepresentative()) {
        $query = $request->get('q', '');
            $data = Role::select('id', 'name')
                ->whereNotIn('name', ['admin', 'representatives'])
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
        $data['cities'] = City::forCountry(233)->orderBy('name')->pluck('name', 'name')->all();
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

            $user->assignCiRole($role->name);

            $this->commissions->syncFromRequest($user, $request);

            Log::info('Role Assigned');

            $plainPassword = (string) $request->input('password', '');
            if ($user->email && $plainPassword !== '') {
                try {
                    Mail::to($user->email)->send(new AffiliateRegisteredMail($user, $auth, $plainPassword));
                } catch (\Throwable $e) {
                    Log::warning('Affiliate welcome email failed: '.$e->getMessage(), ['user_id' => $user->id]);
                }
            }

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
                    $role = Role::firstOrCreate(['name' => \App\Services\TenantRoleService::normalizeCiRoleName($data['user_type']), 'guard_name' => 'web']);
                    $user->assignCiRole($role->name);
                });
            }
            return back()->with('success', 'CSV file imported successfully.');
        } catch (\Exception $e) {
            Log::error('CSV Import Error: ' . $e->getMessage());
            return back()->with('error', 'CSV import failed. Please check the file format.');
        }
    }

}


