<?php

namespace App\Http\Controllers;

use App\Models\DoorColors;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\ProductSection;
use App\Models\Quote;
use App\Models\ShippingQuote;
use App\Models\StockCheckRequest;
use App\Mail\StockCheckAdminMail;
use App\Mail\StockCheckUserMail;
use App\Services\OrderCartPersistenceService;
use App\Services\OrderWorkspaceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TenantCreateOrderController extends Controller
{
    public function __construct(
        protected OrderWorkspaceService $workspace,
        protected OrderCartPersistenceService $cartPersistence,
    ) {}

    public function catalog(): View
    {
        $catalogs = ProductCatalog::query()->where('status', 1)->orderBy('name')->get();

        return view('tenants.orders.standalone.catalog', [
            'catalogs' => $catalogs,
            'step' => 1,
        ]);
    }

    /** Legacy URL — redirect to CI-style build (catalog → multi-room, door on same page). */
    public function doors(int $catalogId): RedirectResponse
    {
        return redirect()->route('tenant_order_workspace_build', $catalogId);
    }

    public function buildLegacyDoorUrl(int $catalogId, int $doorId): RedirectResponse
    {
        return redirect()->route('tenant_order_workspace_build', [
            'catalog' => $catalogId,
            'door' => $doorId,
        ]);
    }

    public function build(int $catalogId, Request $request): View|RedirectResponse
    {
        $catalog = ProductCatalog::query()->where('status', 1)->findOrFail($catalogId);
        $doorColors = DoorColors::query()
            ->where('product_catalog_id', $catalog->id)
            ->where('status', 1)
            ->orderBy('product_label')
            ->get();

        if ($doorColors->isEmpty()) {
            return redirect()
                ->route('tenant_order_workspace')
                ->with('error', 'No door styles are configured for this catalog.');
        }

        $door = $doorColors->firstWhere('id', (int) $request->query('door'))
            ?? $doorColors->first();

        $user = $request->user();

        return view('tenants.orders.workspace.build', [
            'catalog' => $catalog,
            'door' => $door,
            'doorColors' => $doorColors,
            'sections' => $this->productSectionsFor($catalog, $door),
            'savedCart' => $user ? $this->cartPersistence->load($user->id, $catalog->id) : null,
            'shippingPopup' => other_page_content('shipping_pop_up'),
            'stockShippingPopup' => other_page_content('stock_check_shipping_pop_up'),
            'shipTerms' => tax_value('ship_quote_terms_and_condition', ''),
        ]);
    }

    public function accordionSearch(Request $request, int $catalogId, int $doorId): View
    {
        $catalog = ProductCatalog::query()->where('status', 1)->findOrFail($catalogId);
        $door = DoorColors::query()->findOrFail($doorId);
        $sections = $this->productSectionsFor($catalog, $door);

        if ($request->filled('sku')) {
            $term = $request->sku;
            $sections = $sections->map(function (ProductSection $section) use ($term, $catalog, $door) {
                $filtered = $section->products->filter(function (Product $p) use ($term) {
                    return stripos($p->sku, $term) !== false || stripos($p->label, $term) !== false;
                });
                $clone = clone $section;
                $clone->setRelation('products', $filtered->values());

                return $clone;
            })->filter(fn (ProductSection $s) => $s->products->isNotEmpty());
        }

        return view('tenants.orders.workspace.partials.product-accordion', [
            'sections' => $sections,
            'door' => $door,
        ]);
    }

    public function autoSaveCart(Request $request, int $catalogId): JsonResponse
    {
        $user = $request->user();
        $this->cartPersistence->save($user, $catalogId, [
            'job_name' => $request->input('job_name'),
            'room_data' => $request->input('room_data', []),
            'cart_product_weight' => $request->input('cart_product_weight'),
            'all_cart_total' => $request->input('all_cart_total', 0),
            'is_assemble' => $request->input('is_assemble'),
            'order_comment' => $request->input('order_comment'),
            'door_label' => $request->input('door_label'),
            'door_image' => $request->input('door_image'),
        ]);

        return response()->json(['ok' => true]);
    }

    public function clearCart(Request $request, int $catalogId): RedirectResponse
    {
        if ($request->user()) {
            $this->cartPersistence->clear($request->user()->id, $catalogId);
        }
        session()->forget(['workspace_checkout', 'job_name', 'rooms', 'cart']);

        return redirect()->route('tenant_order_workspace_build', [
            'catalog' => $catalogId,
            'door' => $request->query('door'),
        ]);
    }

    public function storePrint(Request $request): JsonResponse
    {
        return $this->persist($request, Order::class, 'tenant_order_workspace_print_page', 'Order ready to print.');
    }

    public function storeProcess(Request $request): JsonResponse
    {
        try {
            $payload = $this->workspace->parsePayload($request);
            session(['workspace_checkout' => $payload]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => collect($e->errors())->flatten()->first() ?? 'Validation failed.',
            ], 422);
        }

        return response()->json([
            'message' => 'Proceeding to checkout.',
            'redirect' => route('tenant_order_workspace_checkout'),
        ]);
    }

    public function checkout(Request $request): View
    {
        $payload = session('workspace_checkout', []);

        return view('tenants.orders.workspace.checkout', ['payload' => $payload]);
    }

    public function printOrder(int $id): View
    {
        $order = Order::query()->with('user')->findOrFail($id);

        return view('tenants.orders.workspace.print', ['order' => $order]);
    }

    /**
     * @return Collection<int, ProductSection>
     */
    protected function productSectionsFor(ProductCatalog $catalog, DoorColors $door): Collection
    {
        return ProductSection::query()
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
                'list_description' => $p->sku.'-'.($p->doorColor?->product_label ?? ''),
                'description' => trim($p->sku.' — '.($p->doorColor?->product_label ?? '').' — '.($p->description ?? '')),
                'weight' => (float) preg_replace('/[^\d.]/', '', (string) $p->weight),
                'cost' => (float) preg_replace('/[^\d.]/', '', (string) $p->cost),
                'assemble_cost' => (float) preg_replace('/[^\d.]/', '', (string) $p->assemble_cost),
                'qty' => $p->qty,
            ]),
        ]);
    }

    public function storeOrder(Request $request): JsonResponse
    {
        return $this->persist($request, Order::class, 'tenant_order_list', 'Order processed successfully.');
    }

    public function storeQuote(Request $request): JsonResponse
    {
        return $this->persist($request, Quote::class, 'tenant_quotes_index', 'Quote saved successfully.');
    }

    public function storeShippingQuote(Request $request): JsonResponse
    {
        $request->merge(['shipping_status' => 'yes']);

        return $this->persist($request, ShippingQuote::class, 'tenant_shipping_quotes_index', 'Shipping quote request saved successfully.');
    }

    public function storeStockCheck(Request $request): JsonResponse
    {
        return $this->persist($request, StockCheckRequest::class, 'tenant_stock_check_index', 'Stock check request submitted successfully.', 'pending');
    }

    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $modelClass
     */
    protected function persist(
        Request $request,
        string $modelClass,
        string $redirectRoute,
        string $message,
        ?string $defaultShippingStatus = null,
    ): JsonResponse {
        $record = null;
        try {
            $payload = $this->workspace->parsePayload($request, $defaultShippingStatus);
            $record = $this->workspace->createRecord($modelClass, $payload);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => collect($e->errors())->flatten()->first() ?? 'Validation failed.',
            ], 422);
        }

        $redirectParams = ['id' => $record->id ?? null];

        return response()->json([
            'message' => $message,
            'redirect' => $redirectRoute === 'tenant_order_workspace_print_page' && isset($record)
                ? route('tenant_order_workspace_print_page', $record->id)
                : route($redirectRoute),
        ]);
    }
}
