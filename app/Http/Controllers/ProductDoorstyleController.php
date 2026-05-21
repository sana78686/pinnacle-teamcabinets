<?php

namespace App\Http\Controllers;
use App\Models\DoorColors;
    use Illuminate\Http\Request;
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $data = $request->only([
            'product_catalog_id',
            'product_label',
            'status',
        ]);

        $data['tenant_id'] = Auth::user()->tenant_id;

        // ✅ Handle image upload properly
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();

            // Move file to uploads directory
            $file->move(public_path('uploads/door_style'), $filename);

            // Save correct path in DB
            $data['image'] = 'uploads/door_style/' . $filename;

            logger("✅ Image uploaded successfully to: " . $data['image']);
        }

        $userId = Auth::id();
        $data['created_by'] = $userId;
        $data['updated_by'] = $userId;

        logger("📦 Final data stored in DB:", $data);

        DoorColors::create($data);

        return redirect()->route('tenants.door_color.index')
            ->with('success', 'Door color created successfully.');
    } catch (\Throwable $e) {
        logger()->error("❌ Error in DoorColor@store: " . $e->getMessage(), [
            'line' => $e->getLine(),
            'file' => $e->getFile(),
            'trace' => $e->getTraceAsString(),
        ]);

        return back()
            ->with('error', 'Failed to create door color: ' . $e->getMessage())
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'nullable|boolean',
        ]);

        $doorColor->product_catalog_id = $request->product_catalog_id;
        $doorColor->product_label = $request->product_label;
        $doorColor->status = $request->status ?? 0;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('door_colors', 'public');
            $doorColor->image = $imagePath;
        }

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

