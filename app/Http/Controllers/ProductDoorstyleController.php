<?php

namespace App\Http\Controllers;
use App\Models\DoorColors;
    use Illuminate\Http\Request;
use App\Support\MediaUpload;
use App\Support\PublicUploadedFile;
    use Illuminate\Support\Facades\Auth;

use App\Models\ProductCatalog;

class ProductDoorstyleController extends Controller
{
    // List all door styles
    public function index()
    {
        $productCatalogs = ProductCatalog::all();
        $doorColors = DoorColors::with('productCatalog')
            ->latest('id')
            ->paginate(tenant_list_per_page())
            ->withQueryString();

        return view('tenants.door_colors.index', compact('productCatalogs', 'doorColors'));
    }


    // Show form to create a new door style
    public function create()
    {
        $productCatalogs = ProductCatalog::all();
        return view('tenants.door_colors.create', compact('productCatalogs'));
    }

    // Store new door style


   public function store(Request $request)
{
    logger('Store method called');

    try {
        $request->validate([
            'product_catalog_id' => 'nullable|integer|exists:product_catalogs,id',
            'product_label' => 'nullable|string|max:255',
            ...MediaUpload::imageFieldRules('image'),
            'status' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'product_catalog_id',
            'product_label',
            'status',
        ]);

        $data['tenant_id'] = Auth::user()->tenant_id;

        $data['image'] = PublicUploadedFile::resolve(
            $request,
            'image',
            null,
            'uploads/door_style'
        );

        $userId = Auth::id();
        $data['created_by'] = $userId;
        $data['updated_by'] = $userId;

        logger("📦 Final data stored in DB:", $data);

        DoorColors::create($data);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Door style created successfully.',
            ]);
        }

        return redirect()->route('tenant_door_style_index')
            ->with('success', 'Door style created successfully.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        throw $e;
    } catch (\Throwable $e) {
        logger()->error('Error in DoorColor@store: '.$e->getMessage(), [
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message' => 'Failed to create door style: '.$e->getMessage(),
            ], 500);
        }

        return back()
            ->with('error', 'Failed to create door style: '.$e->getMessage())
            ->withInput();
    }
}




    // Show single door style
    public function show(ProductDoorstyle $doorstyle)
    {
        return view('doorstyles.show', compact('doorstyle'));
    }

    // Show form to edit
    public function edit($id)
    {
        $doorColor = DoorColors::findOrFail($id);
        $productCatalogs = ProductCatalog::all();

        return view('tenants.door_colors.edit', compact('doorColor', 'productCatalogs'));
    }


    // Update door style
    public function update(Request $request, $id)
    {
        $doorColor = DoorColors::findOrFail($id);

        $request->validate([
            'product_catalog_id' => 'nullable|integer|exists:product_catalogs,id',
            'product_label' => 'nullable|string|max:255',
            ...MediaUpload::imageFieldRules('image'),
            'status' => 'nullable|boolean',
        ]);

        $doorColor->product_catalog_id = $request->product_catalog_id;
        $doorColor->product_label = $request->product_label;
        $doorColor->status = $request->status ?? 0;

        $doorColor->image = PublicUploadedFile::resolve(
            $request,
            'image',
            $doorColor->image,
            'door_colors',
            'public'
        );

        $doorColor->updated_by = Auth::id();
        $doorColor->save();

        return redirect()->route('tenant_door_style_index')
        ->with('success', 'Door color updated successfully.');
    }


    // Delete
    public function destroy($id)
    {
        $doorColor = DoorColors::findOrFail($id);
        $doorColor->delete();

        return redirect()->route('tenant_door_style_index')
                ->with('success', 'Door color deleted successfully.');
    }

}

