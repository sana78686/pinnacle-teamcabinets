<?php

namespace App\Http\Controllers;

use App\Models\DoorColors;
use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\ProductSection;
use App\Support\MediaUpload;
use App\Support\PublicUploadedFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProductSetupApiController extends Controller
{
  /** @var array<string, class-string<Model>> */
  protected array $types = [
    'catalogs' => ProductCatalog::class,
    'categories' => ProductSection::class,
    'door-styles' => DoorColors::class,
    'products' => Product::class,
  ];

  public function meta(string $type): JsonResponse
  {
    $this->assertType($type);

    return response()->json([
      'catalogs' => ProductCatalog::query()->orderBy('name')->get(['id', 'name']),
      'categories' => ProductSection::query()->orderBy('cabinets_name')->get(['id', 'cabinets_name']),
      'door_styles' => DoorColors::query()->orderBy('product_label')->get(['id', 'product_label', 'product_catalog_id']),
    ]);
  }

  public function index(Request $request, string $type): JsonResponse
  {
    $this->assertType($type);
    $modelClass = $this->types[$type];

    $query = $modelClass::query()->latest('id');

    if ($type === 'door-styles') {
      $query->with('productCatalog:id,name');
    }
    if ($type === 'products') {
      $query->with(['productCatalog:id,name', 'productCategory:id,cabinets_name', 'doorColor:id,product_label']);
    }

    $paginator = $query->paginate(tenant_list_per_page())->withQueryString();

    return response()->json([
      'data' => collect($paginator->items())->map(fn ($row) => $this->serialize($type, $row)),
      'meta' => [
        'current_page' => $paginator->currentPage(),
        'last_page' => $paginator->lastPage(),
        'per_page' => $paginator->perPage(),
        'total' => $paginator->total(),
      ],
    ]);
  }

  public function show(string $type, int $id): JsonResponse
  {
    $this->assertType($type);
    $modelClass = $this->types[$type];
    $record = $modelClass::query()->findOrFail($id);

    if ($type === 'door-styles') {
      $record->load('productCatalog:id,name');
    }
    if ($type === 'products') {
      $record->load(['productCatalog:id,name', 'productCategory:id,cabinets_name', 'doorColor:id,product_label']);
    }

    return response()->json(['data' => $this->serialize($type, $record, true)]);
  }

  public function store(Request $request, string $type): JsonResponse
  {
    $this->assertType($type);
    $record = match ($type) {
      'catalogs' => $this->storeCatalog($request),
      'categories' => $this->storeCategory($request),
      'door-styles' => $this->storeDoorStyle($request),
      'products' => $this->storeProduct($request),
    };

    return response()->json([
      'message' => ucfirst(str_replace('-', ' ', $type)).' saved successfully.',
      'data' => $this->serialize($type, $record, true),
    ], 201);
  }

  public function update(Request $request, string $type, int $id): JsonResponse
  {
    $this->assertType($type);
    $record = match ($type) {
      'catalogs' => $this->updateCatalog($request, $id),
      'categories' => $this->updateCategory($request, $id),
      'door-styles' => $this->updateDoorStyle($request, $id),
      'products' => $this->updateProduct($request, $id),
    };

    return response()->json([
      'message' => ucfirst(str_replace('-', ' ', $type)).' updated successfully.',
      'data' => $this->serialize($type, $record, true),
    ]);
  }

  public function destroy(string $type, int $id): JsonResponse
  {
    $this->assertType($type);
    $modelClass = $this->types[$type];
    $record = $modelClass::query()->findOrFail($id);
    $record->delete();

    return response()->json(['message' => 'Deleted successfully.']);
  }

  protected function storeCatalog(Request $request): ProductCatalog
  {
    $request->validate(array_merge([
      'name' => 'required|string|max:255',
    ], MediaUpload::imageFieldRules('image'), MediaUpload::pdfFieldRules('pdf')));

    $catalog = new ProductCatalog;
    $catalog->name = $request->name;
    $catalog->image = PublicUploadedFile::resolve($request, 'image', null, 'uploads/catalogs/images');
    $catalog->pdf = PublicUploadedFile::resolve($request, 'pdf', null, 'uploads/catalogs/pdfs');
    $catalog->created_by = Auth::id();
    $catalog->status = 1;
    $catalog->save();

    return $catalog;
  }

  protected function updateCatalog(Request $request, int $id): ProductCatalog
  {
    $catalog = ProductCatalog::query()->findOrFail($id);
    $request->validate(array_merge([
      'name' => 'required|string|max:255',
    ], MediaUpload::imageFieldRules('image'), MediaUpload::pdfFieldRules('pdf')));

    $catalog->name = $request->name;
    $catalog->image = PublicUploadedFile::resolve($request, 'image', $catalog->image, 'uploads/catalogs/images');
    $catalog->pdf = PublicUploadedFile::resolve($request, 'pdf', $catalog->pdf, 'uploads/catalogs/pdfs');
    $catalog->save();

    return $catalog;
  }

  protected function storeCategory(Request $request): ProductSection
  {
    $request->validate(['cabinets_name' => 'required|string|max:255']);
    $section = new ProductSection;
    $section->cabinets_name = $request->cabinets_name;
    $section->save();

    return $section;
  }

  protected function updateCategory(Request $request, int $id): ProductSection
  {
    $request->validate(['cabinets_name' => 'required|string|max:255']);
    $section = ProductSection::query()->findOrFail($id);
    $section->cabinets_name = $request->cabinets_name;
    $section->save();

    return $section;
  }

  protected function storeDoorStyle(Request $request): DoorColors
  {
    $request->validate([
      'product_catalog_id' => 'required|integer|exists:product_catalogs,id',
      'product_label' => 'required|string|max:255',
      ...MediaUpload::imageFieldRules('image'),
      'status' => 'nullable|boolean',
    ]);

    $data = [
      'product_catalog_id' => $request->product_catalog_id,
      'product_label' => $request->product_label,
      'status' => $request->boolean('status', true) ? 1 : 0,
      'tenant_id' => Auth::user()->tenant_id,
      'created_by' => Auth::id(),
      'updated_by' => Auth::id(),
      'image' => PublicUploadedFile::resolve($request, 'image', null, 'uploads/door_style'),
    ];

    return DoorColors::query()->create($data);
  }

  protected function updateDoorStyle(Request $request, int $id): DoorColors
  {
    $door = DoorColors::query()->findOrFail($id);
    $request->validate([
      'product_catalog_id' => 'required|integer|exists:product_catalogs,id',
      'product_label' => 'required|string|max:255',
      ...MediaUpload::imageFieldRules('image'),
      'status' => 'nullable|boolean',
    ]);

    $door->product_catalog_id = $request->product_catalog_id;
    $door->product_label = $request->product_label;
    $door->status = $request->boolean('status', (bool) $door->status) ? 1 : 0;
    $door->image = PublicUploadedFile::resolve($request, 'image', $door->image, 'uploads/door_style');
    $door->updated_by = Auth::id();
    $door->save();
    $door->load('productCatalog:id,name');

    return $door;
  }

  protected function storeProduct(Request $request): Product
  {
    $request->validate(array_merge([
      'catalog_id' => 'required|integer|exists:product_catalogs,id',
      'section_id' => 'required|integer|exists:product_sections,id',
      'door_color_id' => 'required|integer|exists:door_colors,id',
      'label' => 'required|string|max:255',
      'sku' => 'required|string|max:255',
      'weight' => 'required|string|max:50',
      'cost' => 'required|string|max:50',
      'assemble_cost' => 'nullable|string|max:50',
      'qty' => 'nullable|string|max:50',
      'description' => 'nullable|string',
    ], MediaUpload::imageFieldRules('image')));

    $product = new Product;
    $product->product_catalog_id = $request->catalog_id;
    $product->product_section_id = $request->section_id;
    $product->door_color_id = $request->door_color_id;
    $product->label = $request->label;
    $product->sku = $request->sku;
    $product->weight = $request->weight;
    $product->cost = $request->cost;
    $product->assemble_cost = $request->assemble_cost;
    $product->qty = $request->qty;
    $product->description = $request->description;
    $product->image = PublicUploadedFile::resolve($request, 'image', null, 'uploads/products/images');
    $product->save();
    $product->load(['productCatalog:id,name', 'productCategory:id,cabinets_name', 'doorColor:id,product_label']);

    return $product;
  }

  protected function updateProduct(Request $request, int $id): Product
  {
    $product = Product::query()->findOrFail($id);
    $request->validate(array_merge([
      'catalog_id' => 'required|integer|exists:product_catalogs,id',
      'section_id' => 'required|integer|exists:product_sections,id',
      'door_color_id' => 'required|integer|exists:door_colors,id',
      'label' => 'required|string|max:255',
      'sku' => 'required|string|max:255',
      'weight' => 'required|string|max:50',
      'cost' => 'required|string|max:50',
      'assemble_cost' => 'nullable|string|max:50',
      'qty' => 'nullable|string|max:50',
      'description' => 'nullable|string',
    ], MediaUpload::imageFieldRules('image')));

    $product->product_catalog_id = $request->catalog_id;
    $product->product_section_id = $request->section_id;
    $product->door_color_id = $request->door_color_id;
    $product->label = $request->label;
    $product->sku = $request->sku;
    $product->weight = $request->weight;
    $product->cost = $request->cost;
    $product->assemble_cost = $request->assemble_cost;
    $product->qty = $request->qty;
    $product->description = $request->description;
    $product->image = PublicUploadedFile::resolve($request, 'image', $product->image, 'uploads/products/images');
    $product->save();
    $product->load(['productCatalog:id,name', 'productCategory:id,cabinets_name', 'doorColor:id,product_label']);

    return $product;
  }

  protected function serialize(string $type, Model $row, bool $detail = false): array
  {
    return match ($type) {
      'catalogs' => array_merge([
        'id' => $row->id,
        'name' => $row->name,
        'image_url' => $row->image_url,
        'pdf_url' => $row->pdf_url,
        'pdf_view_url' => $row->pdf ? route('tenant_product_catalog_pdf', $row->id) : null,
        'status' => (int) ($row->status ?? 1),
      ], $detail ? $this->mediaLinkFields($row, 'image', 'pdf') : []),
      'categories' => [
        'id' => $row->id,
        'cabinets_name' => $row->cabinets_name,
      ],
      'door-styles' => array_merge([
        'id' => $row->id,
        'product_catalog_id' => $row->product_catalog_id,
        'catalog_name' => $row->productCatalog?->name,
        'product_label' => $row->product_label,
        'image_url' => $row->image_url,
        'status' => (bool) $row->status,
      ], $detail ? $this->mediaLinkFields($row, 'image') : []),
      'products' => array_merge([
        'id' => $row->id,
        'catalog_id' => $row->product_catalog_id,
        'section_id' => $row->product_section_id,
        'door_color_id' => $row->door_color_id,
        'catalog_name' => $row->productCatalog?->name,
        'category_name' => $row->productCategory?->cabinets_name,
        'door_style_name' => $row->doorColor?->product_label,
        'label' => $row->label,
        'sku' => $row->sku,
        'weight' => $row->weight,
        'cost' => $row->cost,
        'assemble_cost' => $row->assemble_cost,
        'qty' => $row->qty,
        'description' => $detail ? $row->description : null,
        'image_url' => $row->image_url ?? ProductCatalog::publicAssetUrl($row->image),
      ], $detail ? $this->mediaLinkFields($row, 'image') : []),
      default => [],
    };
  }

  /** @return array<string, string> */
  protected function mediaLinkFields(Model $row, string $imageField, ?string $pdfField = null): array
  {
    $out = [];
    $image = (string) ($row->{$imageField} ?? '');
    if ($image !== '') {
      $out[$imageField.'_link'] = PublicUploadedFile::isExternalUrl($image) ? $image : '';
    }
    if ($pdfField !== null) {
      $pdf = (string) ($row->{$pdfField} ?? '');
      if ($pdf !== '') {
        $out[$pdfField.'_link'] = PublicUploadedFile::isExternalUrl($pdf) ? $pdf : '';
      }
    }

    return $out;
  }

  protected function assertType(string $type): void
  {
    if (! isset($this->types[$type])) {
      throw ValidationException::withMessages(['type' => ['Invalid product setup type.']]);
    }
  }
}
