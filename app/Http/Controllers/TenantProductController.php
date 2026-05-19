<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Imports\ProductImport;
use App\Exports\UserExport;
use App\Imports\ProductImport as ImportsProductImport;
use App\Models\DoorColors;
use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\ProductSection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TenantProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $product = product::all();
        $query = Product::query();


        if ($request->has('product') && $request->product != '') {
            $query->where('product', 'LIKE', '%' . $request->product . '%');
        }


        if ($request->has('product_section') && $request->product_section != '') {
            $query->where('product_section', 'LIKE', '%' . $request->product_section . '%');
        }


        if ($request->has('product_label') && $request->product_label != '') {
            $query->where('product_label', 'LIKE', '%' . $request->product_label . '%');
        }

        $data['Product'] = $query->paginate(10);
       return view('tenants.products.index',$data,compact('product'));
    }
    public function search(Request $request)
    {
        $field = $request->field;
        $query = $request->query('query', '');

        if (!in_array($field, ['product', 'product_section', 'product_label'])) {
            return response()->json([], 400);
        }


        $results = Product::where($field, 'LIKE', '%' . $query . '%')
            ->select('id', 'product', 'product_section', 'product_label')
            ->get();

        return response()->json($results);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [];
        $data['product_catalogs'] = ProductCatalog::get();
        $data['product_sections'] = ProductSection::get();
        $data['door_colors'] = DoorColors::get();
        return view('tenants.products.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    // dd($request->all());
    // $request->validate([
    //     'product_label' => 'required|string|max:255',
    //     'product_sku' => 'required|string|unique:products,sku|max:255',
    //     'product_weight' => 'required|numeric',
    //     'product_cost' => 'required|numeric',
    //     'product_description' => 'nullable|string',
    //     'cabinet_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    // ]);
    $product = new Product;
    $product->product_catalog_id = $request->catalog_id;
    $product->product_section_id = $request->section_id;
    $product->door_color_id = $request->door_color_id;
    $product->label = $request->label;
    $product->sku = $request->sku;
    $product->weight = $request->weight;
    $product->cost = $request->cost;
    $product->assemble_cost = $request->assemble_cost;
    $product->manufacture_date = $request->manufcature_date;
    $product->qty = $request->qty;
    $product->description = $request->description;
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('product/images'), $imageName);
        $product->image = $imageName;
    }

    $product->save();

    return redirect()->route('tenant_product_index')->with('success', 'Product added successfully.');
}
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('productCatalog')->findOrFail($id);
        return view('tenants.products.show', compact('product'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $product = Product::findOrFail($id);
       return view('tenants.products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product->label = $request->product_label;
        $product->sku = $request->sku;
        $product->weight = $request->weight;
        $product->cost = $request->cost;
        $product->description = $request->description;
        if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('product/images'), $imageName);
        $product->image = $imageName;
    }

    $product->save();

    return redirect()->route('tenant_product_index')->with('success', 'Product Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the user by ID
            $product = Product::findOrFail($id);

            // Perform soft delete
            $product->delete();

            // Redirect back with success message
            return redirect()->back()->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            // If something goes wrong, show an error message
            return redirect()->route('tenants.products.index')->with('error', 'Failed to delete the product');
        }
    }


    public function deletedproductList()

    {
        $data['product'] = Product::onlyTrashed()->get();
        return view('tenants.products.deleted_products_list', $data);
    }

    public function restoreDeletedproducts($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        if (!$product) {
            session()->flash('error', 'Product cannot found.');
            return redirect()->back();
        }
        $product->restore(); // Restore the user
        return redirect()->route('tenant_product_index')
            ->with('success', 'Product.'.$product->name.'. Restored successfully');
    }

    public function product_export()
    {
        return Excel::download(new ProductExport, 'products.xlsx');
    }



    public function product_import(Request $request)
{
    // Validate the file
    $request->validate([
        'productFile' => 'required|file|mimes:xlsx,xls,csv'  // Accept Excel and CSV files
    ]);

    // Import the file using Excel::import
    Excel::import(new ProductImport, $request->file('productFile'));

    // Redirect back after import
    return redirect()->back();
}

}
