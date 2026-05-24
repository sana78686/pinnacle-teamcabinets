<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RoleExport;
use App\Imports\RoleImport;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Services\TenantPermissionService;
use App\Services\TenantRoleService;
use App\Support\TenantListPaginator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TenantRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // function __construct()
    // {
    //      $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
    //      $this->middleware('permission:role-create', ['only' => ['create','store']]);
    //      $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    //      $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $perPage = TenantListPaginator::perPage($request);
        $search = TenantListPaginator::search($request);
        $query = Role::query()->withCount('permissions')->orderBy('id', 'DESC');

        if ($search !== '') {
            $query->where('name', 'like', '%'.$search.'%');
        }

        return view('tenants.roles.index', [
            'roles' => $query->paginate($perPage)->withQueryString(),
            'perPage' => $perPage,
            'search' => $search,
            'protectedRoles' => TenantRoleService::DEFAULT_ROLES,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        return view('tenants.roles.create', [
            'permissions' => TenantPermissionService::groupedForUi(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $permissionsID = array_map(
            function($value) { return (int)$value; },
            $request->input('permission')
        );

        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($permissionsID);

        return redirect()->route('tenant_role_index')
                        ->with('success','Role created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
            ->where("role_has_permissions.role_id",$id)
            ->get();

        return view('tenants.roles.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $role = Role::findOrFail($id);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_id', $id)
            ->pluck('permission_id')
            ->all();

        return view('tenants.roles.edit', [
            'role' => $role,
            'permissions' => TenantPermissionService::groupedForUi(),
            'rolePermissions' => $rolePermissions,
            'isProtected' => TenantRoleService::isProtectedRole($role->name),
        ]);
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
    $request->validate([
        'name' => 'required',
        'permission' => 'required|array',
    ]);

    $role = Role::findOrFail($id);

    if (TenantRoleService::isProtectedRole($role->name)) {
        if ($request->input('name') !== $role->name) {
            return redirect()->route('tenant_role_index')
                ->with('error', 'System role names cannot be changed.');
        }
    } else {
        $role->name = $request->input('name');
        $role->save();
    }

    $permissionsID = array_map('intval', $request->input('permission'));
    $role->syncPermissions($permissionsID);

    return redirect()->route('tenant_role_index')
                     ->with('success', 'Role updated successfully');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        if (TenantRoleService::isProtectedRole($role->name)) {
            return redirect()->route('tenant_role_index')
                ->with('error', 'System roles cannot be deleted.');
        }

        $role->delete();

        return redirect()->route('tenant_role_index')
            ->with('success', 'Role deleted successfully');
    }



    public function role_export()
    {
        return Excel::download(new RoleExport, 'role.xlsx');
    }



    public function role_import(Request $request)
{
    // Validate the file
    $request->validate([
        'roleFile' => 'required|file|mimes:xlsx,xls,csv'  // Accept Excel and CSV files
    ]);

    // Import the file using Excel::import
    Excel::import(new RoleImport, $request->file('roleFile'));

    // Redirect back after import
    return redirect()->back();
}
}
