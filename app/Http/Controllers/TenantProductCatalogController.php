<?php

namespace App\Http\Controllers;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\Productcatalog_Export;
use App\Imports\Productcatalog_Import;
use App\Models\ProductCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Support\MediaUpload;
use App\Support\PublicUploadedFile;
class TenantProductCatalogController extends Controller
{
    protected function catalogUploadDir(string $subdir): string
    {
        return 'uploads/catalogs/'.$subdir;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ProductCatalog::query();
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'LIKE', '%' . $request->name . '%');
        }
        if ($request->has('image') && $request->image != '') {
            $query->where('image', 'LIKE', '%' . $request->image . '%');
        }
        if ($request->has('pdf') && $request->pdf != '') {
            $query->where('pdf', 'LIKE', '%' . $request->pdf . '%');
        }
        $data['product_catalogs'] = $query->latest('id')->paginate(tenant_list_per_page())->withQueryString();
        // dd($data['product_catalogs']);
        return view('tenants.product_catalogs.index', $data);
    }

    public function search(Request $request)
    {
        $field = $request->field;
        $query = $request->query('query', '');
        if (!in_array($field, ['name', 'image', 'pdf'])) {
            return response()->json([], 400);
        }
        $results = ProductCatalog::where($field, 'LIKE', '%' . $query . '%')
            ->select('id', 'name', 'image', 'pdf')
            ->get()
            ->map(fn (ProductCatalog $catalog) => [
                'id' => $catalog->id,
                'name' => $catalog->name,
                'image_url' => $catalog->image_url,
                'pdf_url' => $catalog->pdf_url,
                'pdf_view_url' => $catalog->pdf
                    ? route('tenant_product_catalog_pdf', $catalog->id)
                    : null,
                'show_url' => route('tenant_product_catalog_show', $catalog->id),
                'edit_url' => route('tenant_product_catalog_edit', $catalog->id),
            ]);
        return response()->json($results);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('tenants.product_catalogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // dd($request->all());

        $request->validate(array_merge([
            'name' => 'required|string|max:255',
        ], MediaUpload::imageFieldRules('image'), MediaUpload::pdfFieldRules('pdf')));

        $product_catalog = new ProductCatalog();
        $product_catalog->name = $request->name;

        // if ($request->hasFile('image')) {
        //     $product_catalog->image = $request->file('image')->store('public/images');
        // }

        $product_catalog->image = PublicUploadedFile::resolve(
            $request,
            'image',
            null,
            $this->catalogUploadDir('images')
        );

        $product_catalog->pdf = PublicUploadedFile::resolve(
            $request,
            'pdf',
            null,
            $this->catalogUploadDir('pdfs')
        );

        $product_catalog->created_by = Auth::user()->id;
        $product_catalog->status = 1;
        $product_catalog->save();

        return redirect()->route('tenant_product_catalog_index')->with('success', 'Product catalog created successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product_catalog = ProductCatalog::findOrFail($id);
        return view('tenants.product_catalogs.show',compact('product_catalog'));
    }

    public function viewPdf(string $id)
    {
        $product_catalog = ProductCatalog::findOrFail($id);

        if (! $product_catalog->pdf) {
            return redirect()
                ->route('tenant_product_catalog_index')
                ->with('error', 'No PDF file is attached to this catalog.');
        }

        if (PublicUploadedFile::isExternalUrl($product_catalog->pdf)) {
            return redirect()->away($product_catalog->pdf);
        }

        $absolutePath = $this->resolveCatalogPdfPath($product_catalog);
        if ($absolutePath) {
            return response()->file($absolutePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="'.basename($absolutePath).'"',
            ]);
        }

        if ($product_catalog->pdf_url) {
            return redirect()->away($product_catalog->pdf_url);
        }

        return redirect()
            ->route('tenant_product_catalog_index')
            ->with('error', 'PDF file could not be found on the server.');
    }

    protected function resolveCatalogPdfPath(ProductCatalog $catalog): ?string
    {
        $relative = ltrim((string) $catalog->pdf, '/');
        if ($relative === '') {
            return null;
        }

        if (str_starts_with($relative, 'public/')) {
            $relative = substr($relative, 7);
        }

        $candidates = [
            public_path($relative),
            storage_path('app/public/'.$relative),
        ];

        foreach ($candidates as $path) {
            if (is_file($path)) {
                return $path;
            }
        }

        return null;
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product_catalog = ProductCatalog::findOrFail($id);
        return view('tenants.product_catalogs.edit',compact('product_catalog'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
{

    $product_catalog = ProductCatalog::findOrFail($id);

    $request->validate(array_merge([
        'name' => 'required|string|max:255',
    ], MediaUpload::imageFieldRules('image'), MediaUpload::pdfFieldRules('pdf')));

    $product_catalog->name = $request->name;

    $product_catalog->image = PublicUploadedFile::resolve(
        $request,
        'image',
        $product_catalog->image,
        $this->catalogUploadDir('images')
    );

    $product_catalog->pdf = PublicUploadedFile::resolve(
        $request,
        'pdf',
        $product_catalog->pdf,
        $this->catalogUploadDir('pdfs')
    );

    $product_catalog->save();

    return redirect()->route('tenant_product_catalog_index')->with('success', 'Product catalog updated successfully!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // Find the user by ID
            $product_catalog = ProductCatalog::findOrFail($id);

            // Perform soft delete
            $product_catalog->delete();

            // Redirect back with success message
            return redirect()->back()->with('success', 'Product_catalog deleted successfully');
        } catch (\Exception $e) {
            // If something goes wrong, show an error message
            return redirect()->route('tenant_product_catalog_index')->with('error', 'Failed to delete the product_catalog');
        }
    }

    public function deletedproductcatalogList()
    {
        $data['product_catalog'] = ProductCatalog::onlyTrashed()->latest('id')->paginate(tenant_list_per_page())->withQueryString();

        return view('tenants.product_catalogs.deleted_products_catalog_list', $data);
    }

    public function restoreDeletedproductcatalog($id)
    {
        $product_catalog = ProductCatalog::onlyTrashed()->findOrFail($id);
        if (!$product_catalog) {
            session()->flash('error', 'Product catalog cannot found.');
            return redirect()->back();
        }
        $product_catalog->restore(); // Restore the product catalog
        return redirect()->route('tenant_product_catalog_index')
            ->with('success', 'product_catalog.'.$product_catalog->name.'. Restored successfully');
    }

    public function product_catalog_export()
    {
        return Excel::download(new Productcatalog_Export, 'Productcatalog.xlsx');
    }

    public function product_catalog_import(Request $request)
{
    // Validate the file
    $request->validate([
        'ProductcatalogFile' => 'required|file|mimes:xlsx,xls,csv'  // Accept Excel and CSV files
    ]);

    // Import the file using Excel::import
    Excel::import(new Productcatalog_Import, $request->file('ProductcatalogFile'));

    // Redirect back after import
    return redirect()->back();
}
}
