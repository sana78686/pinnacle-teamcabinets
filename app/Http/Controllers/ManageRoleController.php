<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageRoleController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return redirect()->route('tenant_hierarchy_index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenants.manage_roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('tenants.bulletins.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       return view('tenants.bulletins.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
