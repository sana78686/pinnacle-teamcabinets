<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Quote;
use App\Models\TaxValues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TenantQuotesController extends Controller
{
    public function index(){
        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.quotes.index');
        }
        else
        {
            return view('tenants.representative_modals.quotes.index');
        }
        // return view('tenants.quotes.index');
    }

    public function create(){

        return view('tenants.quotes.create');
    }

    public function edit(string $id){

        return view('tenants.quotes.edit');
    }

    public function show(string $id){

        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.quotes.show');
        }
        else
        {
            return view('tenants.representative_modals.quotes.show');
        }
        // return view('tenants.quotes.show');
    }



    public function deleted_quotes_list()

    {
        // $data['product_section'] = ProductSection::onlyTrashed()->get();
        return view('tenants.quotes.deleted_quotes_list');
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

    public function shipping_quotes_create(){

        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.quotes.create_shipping_quotes');
        }
        else
        {
            return view('tenants.representative_modals.quotes.create_shipping_quotes');
        }
        // return view('tenants.quotes.create_shipping_quotes');
    }
    public function shipping_quotes_index(){

        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.quotes.shipping_quotes_list');
        }
        else
        {
            return view('tenants.representative_modals.quotes.shipping_quotes_list');
        }
        // return view('tenants.quotes.shipping_quotes_list');
    }
    public function shipping_quotes_edit(string $id){
        return view('tenants.quotes.edit_shipping_quotes');
    }
    public function shipping_quotes_show(){
        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.quotes.show_shipping_quotes');
        }
        else
        {
            return view('tenants.representative_modals.quotes.show_shipping_quotes');
        }
        // return view('tenants.quotes.show_shipping_quotes');
    }
    public function deleted_shipping_quotes_list()

    {
        // $data['product_section'] = ProductSection::onlyTrashed()->get();
        return view('tenants.quotes.deleted_shipping_quotes_list');
    }

    public function store(Request $request)
    {

        Log::info("Received Data:", $request->all());
        $user = Auth::user();
        $validated_data = $request->validate([
            'job_name' => 'required|string',
            'rooms' => 'req|array|required',
            'assemble_cabinets_check' => 'required',
            'shipping_status' => 'required|in:yes,pending',
            'comment' => 'nullable|string'
        ]);

        Log::info($request->rooms);
        $countryName = $user->country_id ? $user->country->name : '';
        $stateName = $user->state_id ? $user->state->name : '';

        $user_address = implode(', ', array_filter([
            $user->address,
            $user->city_name,
            $user->county_name,
            $stateName,
            $countryName
        ]));
        $fuel_tax = TaxValues::where('option_key', 'fuel_charges_value')->first();

        $total_assemble_cost = 0;
        $sub_total_cost = 0;
        $sub_total_weight = 0;
        foreach ($request->rooms as $room) {
            foreach ($room['products'] as $product) {
                // Fetch the assemble cost for the product from the database
                $productData = Product::find($product['product_id']);
                Log::info($productData);
                $product_assemble_cost = $productData ? $productData->assemble_cost : 0;
                $product_cost = $productData ? $productData->cost : 0;
                $product_weight = $productData ? $productData->weight : 0;

                // Multiply by quantity and add to total
                $total_assemble_cost += ($product_assemble_cost * $product['quantity']);
                $sub_total_cost += ($product_cost * $product['quantity']);
                $sub_total_weight += ($product_weight * $product['quantity']);

            }
        }
        Log::info($total_assemble_cost);
        $stockCheckRequest = Quote::create([
            'job_name' => $request->job_name,
            'rooms' => json_encode($request->rooms),
            'assemble_cabinets_check' => $request->assemble_cabinets_check,
            'shipping_status' => $request->shipping_status,
            'comment' => $request->comment,
            'user_id' => $user->id,
            'user_address' => $user_address,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'sub_total_cost' => $sub_total_cost,
            'fuel_tax' => $fuel_tax->option_value,
        ]);
        if($request->assemble_cabinets_check == 1)
        {
            Log::info("assemble cabinet check");
            $stockCheckRequest->sub_total_assemble_cost = $total_assemble_cost;
            $stockCheckRequest->save();
        }
        /***  Sum grand total */
        $stockCheckRequest->grand_total_cost = $total_assemble_cost + $sub_total_cost;
        $stockCheckRequest->sub_total_weight = $sub_total_weight;
        $stockCheckRequest->save();


        // $admins = User::where('role', 'admin')->pluck('email')->toArray();
        // Mail::to($user->email)->send(new StockCheckUserMail());
        // if (!empty($admins)) {
        //     Mail::to($admins)->send(new StockCheckAdminMail());
        // }
        Log::info($stockCheckRequest);
        return response()->json(['message' => 'Stock check saved successfully'], 200);
    }

}
