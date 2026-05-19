<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TenantClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tenants.claims.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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

    public function deletedclaimList()
    {
        return view('tenants.claims.deleted_claim_list');
        // $data['order'] = Order::onlyTrashed()->get();
        // session()->flash('success', "Please deleted_products_list add user's Point Factor immediately after the Approval. Otherwise it will affect the Commission Report.You can only change the product type of the product until product is not approved.");
        // return view('tenants.orders.deleted_order_list', $data);
    }

    public function restoreDeletedclaim($id)
    {
        // $order = ::onlyTrashed()->findOrFail($id);
        // if (!$order) {
        //     session()->flash('error', 'Product cannot found.');
        //     return redirect()->back();
        }
    //     $order->restore(); // Restore the user
    //     return redirect()->route('tenant_deleted_product_catalog_list')
    //         ->with('success', 'product_catalog.'.$order->name.'. Restored successfully');
    // }
}
