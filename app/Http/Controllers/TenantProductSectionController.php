<?php

namespace App\Http\Controllers;

use App\Exports\Product_sectionExport;
use App\Imports\Product_sectionImport;
use App\Models\ProductSection;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TenantProductSectionController extends Controller
{
    public function index(){
        $product_section = ProductSection::latest('id')->paginate(tenant_list_per_page())->withQueryString();

        return view('tenants.product_section.index', compact('product_section'));
    }

    public function create(){
        return view('tenants.product_section.create');
    }

    public function store(Request $request){
        $request->validate([
            'cabinets_name'=>'required',
            // 'assemble_price'=>'required',
        ]);
        $product_section = new ProductSection;
        $product_section->cabinets_name = $request->cabinets_name;
        // $product_section->assemble_price = $request->assemble_price;
        $product_section->save();
        return redirect()->route('tenant_product_section_index')->with('success','Product Section added successfully');
    }

    public function edit(string $id){
        $product_section = ProductSection::findOrFail($id);
        return view('tenants.product_section.edit',compact('product_section'));
    }

    public function update(Request $request,$id){

     $product_section = ProductSection::findOrFail($id);
     $request->validate([
        'cabinets_name'=>'required',
        // 'assemble_price'=>'required',
    ]);

     $product_section->cabinets_name = $request->cabinets_name;
    //  $product_section->assemble_price = $request->assemble_price;
     $product_section->save();
     return redirect()->route('tenant_product_section_index')->with('success','Product Section Updated successfully');

    }

    public function show(string $id){
        $product_section = ProductSection::findOrFail($id);
        return view('tenants.product_section.show',compact('product_section'));
    }

    public function deletedproductsectionList()

    {
        $data['product_section'] = ProductSection::onlyTrashed()->latest('id')->paginate(tenant_list_per_page())->withQueryString();

        return view('tenants.product_section.deleted_product_section_list', $data);
    }

    public function restoreDeletedproductsection($id)
    {
        $product_section = ProductSection::onlyTrashed()->findOrFail($id);
        if (!$product_section) {
            session()->flash('error', 'Product Section cannot found.');
            return redirect()->back();
        }
        $product_section->restore(); // Restore the user
        return redirect()->route('tenant_product_section_index')
            ->with('success', 'product_section.'.$product_section->name.'. Restored successfully');
    }

    public function destroy($id){
        try {
            // Find the user by ID
            $product_section = ProductSection::findOrFail($id);

            // Perform soft delete
            $product_section->delete();

            // Redirect back with success message
            return redirect()->back()->with('success', 'Product Section deleted successfully');
        } catch (\Exception $e) {
            // If something goes wrong, show an error message
            return redirect()->route('tenants.product_section.index')->with('error', 'Failed to delete the Product Section');
        }
    }

    public function product_section_export()
    {
        return Excel::download(new Product_sectionExport, 'productsection.xlsx');
    }

    public function product_section_import(Request $request)
{
    // Validate the file
    $request->validate([
        'productsectionFile' => 'required|file|mimes:xlsx,xls,csv'  // Accept Excel and CSV files
    ]);
    // Import the file using Excel::import
    Excel::import(new Product_sectionImport, $request->file('productsectionFile'));
    // Redirect back after import
    return redirect()->back();
}

}
