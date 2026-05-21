<?php

namespace App\Http\Controllers;

use App\Models\DoorColors;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\ProductSection;
use App\Models\TaxValues;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TenantCreateOrderController extends Controller
{
    public function catalog(): View
    {
        $catalogs = ProductCatalog::query()->where('status', 1)->orderBy('name')->get();

        return view('tenants.orders.standalone.catalog', [
            'catalogs' => $catalogs,
            'step' => 1,
        ]);
    }

    public function doors(int $catalogId): View
    {
        $catalog = ProductCatalog::query()->where('status', 1)->findOrFail($catalogId);
        $doorColors = DoorColors::query()
            ->where('product_catalog_id', $catalog->id)
            ->where('status', 1)
            ->orderBy('product_label')
            ->get();

        return view('tenants.orders.standalone.doors', [
            'catalog' => $catalog,
            'doorColors' => $doorColors,
            'step' => 2,
        ]);
    }

    public function build(int $catalogId, int $doorId): View
    {
        $catalog = ProductCatalog::query()->where('status', 1)->findOrFail($catalogId);
        $door = DoorColors::query()
            ->where('product_catalog_id', $catalog->id)
            ->where('status', 1)
            ->findOrFail($doorId);

        $sections = ProductSection::query()
            ->orderBy('cabinets_name')
            ->get()
            ->map(function (ProductSection $section) use ($catalog, $door) {
                $section->setRelation(
                    'products',
                    Product::query()
                        ->where('product_section_id', $section->id)
                        ->where('product_catalog_id', $catalog->id)
                        ->where('door_color_id', $door->id)
                        ->orderBy('label')
                        ->get()
                );

                return $section;
            })
            ->filter(fn (ProductSection $section) => $section->products->isNotEmpty());

        return view('tenants.orders.standalone.build', [
            'catalog' => $catalog,
            'door' => $door,
            'sections' => $sections,
            'step' => 3,
        ]);
    }

    public function searchProducts(Request $request, int $catalogId, int $doorId): JsonResponse
    {
        $query = Product::query()
            ->with('doorColor')
            ->where('product_catalog_id', $catalogId)
            ->where('door_color_id', $doorId);

        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function ($q) use ($term) {
                $q->where('sku', 'like', "%{$term}%")
                    ->orWhere('label', 'like', "%{$term}%");
            });
        }

        $products = $query->orderBy('label')->limit(80)->get();

        return response()->json([
            'products' => $products->map(fn (Product $p) => [
                'id' => $p->id,
                'label' => $p->label,
                'sku' => $p->sku,
                'description' => trim($p->sku.' — '.($p->doorColor?->product_label ?? '').' — '.($p->description ?? '')),
                'weight' => (float) preg_replace('/[^\d.]/', '', (string) $p->weight),
                'cost' => (float) preg_replace('/[^\d.]/', '', (string) $p->cost),
                'assemble_cost' => (float) preg_replace('/[^\d.]/', '', (string) $p->assemble_cost),
                'qty' => $p->qty,
            ]),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'job_name' => 'required|string|max:255',
            'rooms' => 'required|array|min:1',
            'assemble_cabinets_check' => 'required',
            'comment' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $assembleYes = in_array($request->assemble_cabinets_check, ['1', 1, 'yes', true], true);
        $assembleValue = $assembleYes ? 'yes' : 'no';

        $roomsPayload = [];
        foreach ($request->rooms as $room) {
            if (empty($room['room_name']) || empty($room['products'])) {
                continue;
            }
            $roomsPayload[] = [
                'room_name' => $room['room_name'],
                'products' => collect($room['products'])->map(fn ($p) => [
                    'product_id' => (int) $p['product_id'],
                    'quantity' => max(1, (int) ($p['quantity'] ?? 1)),
                    'checkbox_status' => $p['checkbox_status'] ?? 'none',
                ])->values()->all(),
            ];
        }

        if (count($roomsPayload) === 0) {
            return response()->json(['message' => 'Add at least one room with products.'], 422);
        }

        $countryName = $user->country_id ? $user->country?->name : '';
        $stateName = $user->state_id ? $user->state?->name : '';
        $userAddress = implode(', ', array_filter([
            $user->address,
            $user->city_name,
            $user->county_name,
            $stateName,
            $countryName,
        ]));

        $fuelTax = TaxValues::query()->where('option_key', 'fuel_charges_value')->first();
        $totalAssemble = 0;
        $subTotalCost = 0;
        $subTotalWeight = 0;

        foreach ($roomsPayload as $room) {
            foreach ($room['products'] as $line) {
                $productData = Product::find($line['product_id']);
                if (! $productData) {
                    continue;
                }
                $qty = $line['quantity'];
                $totalAssemble += ((float) $productData->assemble_cost) * $qty;
                $subTotalCost += ((float) preg_replace('/[^\d.]/', '', (string) $productData->cost)) * $qty;
                $subTotalWeight += ((float) preg_replace('/[^\d.]/', '', (string) $productData->weight)) * $qty;
            }
        }

        $order = Order::create([
            'job_name' => $request->job_name,
            'rooms' => $roomsPayload,
            'assemble_cabinets_check' => $assembleValue,
            'shipping_status' => $request->input('shipping_status', 'pending'),
            'comment' => $request->comment,
            'user_id' => $user->id,
            'user_address' => $userAddress,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'sub_total_cost' => $subTotalCost,
            'fuel_tax' => $fuelTax?->option_value,
            'sub_total_assemble_cost' => $assembleYes ? $totalAssemble : 0,
            'grand_total_cost' => $subTotalCost + ($assembleYes ? $totalAssemble : 0),
            'sub_total_weight' => $subTotalWeight,
        ]);

        Log::info('Order created via workspace', ['order_id' => $order->id]);

        return response()->json([
            'message' => 'Order created successfully.',
            'redirect' => route('tenant_order_list'),
        ]);
    }
}
