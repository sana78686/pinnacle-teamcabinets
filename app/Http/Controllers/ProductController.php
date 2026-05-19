<?php

namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [];
        $data['product_catalogs'] = ProductCatalog::latest()->get();
        if ($request->ajax()) {
            $product_catalogs = ProductCatalog::latest()->get();
            return response()->json(['product_catalogs' => $product_catalogs]);
        }

        return view('tenants.product_catalogs.index',$data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'pdf' => 'nullable|mimes:pdf',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('product_catalogs/images', 'public');
        }

        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('product_catalogs/pdfs', 'public');
        }

        ProductCatalog::create($data);
        return response()->json(['success' => 'Catalog created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product_catalog = ProductCatalog::find($id);
        return response()->json(['product_catalog' => $product_catalog]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $catalog = ProductCatalog::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'pdf' => 'nullable|mimes:pdf',
            'status' => 'required|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('product_catalogs/images', 'public');
        }

        if ($request->hasFile('pdf')) {
            $data['pdf'] = $request->file('pdf')->store('product_catalogs/pdfs', 'public');
        }

        $catalog->update($data);
        return response()->json(['success' => 'Catalog updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ProductCatalog::findOrFail($id)->delete();
        return response()->json(['success' => 'Catalog deleted successfully']);
    }
}
