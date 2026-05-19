<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantCommissionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return  view('tenants.commission_report.commission_report_list');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return  view('tenants.commission_report.create_commission_report');
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
       return view('tenants.commission_report.show_commission_report');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('tenants.commission_report.edit_commission_report');
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


    public function deleted_commission_report_list()

    {
        // $data['product_section'] = ProductSection::onlyTrashed()->get();
        return view('tenants.commission_report.deleted_commission_report_list');
    }

    public function restoreDeletedproductsection($id)
    {
        // $product_section = ProductSection::onlyTrashed()->findOrFail($id);
        // if (!$product_section) {
        //     session()->flash('error', 'Product Section cannot found.');
        //     return redirect()->back();
        // }
        // $product_section->restore(); // Restore the user
        // return redirect()->route('tenant_deleted_product_section_list')
        //     ->with('success', 'product_section.'.$product_section->name.'. Restored successfully');
    }
}
