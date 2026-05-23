<?php

namespace App\Http\Controllers;

use App\Models\ProductCatalog;
use App\Support\MediaUpload;
use App\Support\PublicUploadedFile;
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
        $data = $request->validate(array_merge([
            'name' => 'required|string|max:255',
        ], MediaUpload::imageFieldRules('image'), MediaUpload::pdfFieldRules('pdf')));

        $data['image'] = PublicUploadedFile::resolve($request, 'image', null, 'product_catalogs/images', 'public');
        $data['pdf'] = PublicUploadedFile::resolve($request, 'pdf', null, 'product_catalogs/pdfs', 'public');

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

        $data = $request->validate(array_merge([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ], MediaUpload::imageFieldRules('image'), MediaUpload::pdfFieldRules('pdf')));

        $data['image'] = PublicUploadedFile::resolve($request, 'image', $catalog->image, 'product_catalogs/images', 'public');
        $data['pdf'] = PublicUploadedFile::resolve($request, 'pdf', $catalog->pdf, 'product_catalogs/pdfs', 'public');

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
