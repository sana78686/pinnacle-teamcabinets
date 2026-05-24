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
use App\Services\OrderCartPersistenceService;
use App\Services\OrderPricingService;
use App\Services\OrderWorkspaceCheckoutService;
use App\Services\OrderWorkspaceNotificationService;
use App\Services\TenantNotificationService;
use App\Services\OrderWorkspaceService;
use App\Services\QuoteWorkspaceService;
use App\Services\PaytracePaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TenantCreateOrderController extends Controller
{
    public function __construct(
        protected OrderWorkspaceService $workspace,
        protected OrderCartPersistenceService $cartPersistence,
        protected OrderPricingService $pricing,
        protected OrderWorkspaceCheckoutService $checkout,
        protected OrderWorkspaceNotificationService $notifications,
        protected PaytracePaymentService $paytrace,
        protected QuoteWorkspaceService $quoteWorkspace,
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
        $user = $request->user()->load('roles');

        if (! $this->pricing->userMayAccessCatalog($user, $catalog->id)) {
            return redirect()
                ->route('tenant_order_workspace')
                ->with('error', 'You do not have access to this catalog.');
        }

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

        $pricingContext = $this->pricing->contextFor($user, $catalog->id, $door->id);

        $savedCart = $this->enrichSavedCartForEditing(
            $this->cartPersistence->load($user->id, $catalog->id),
            $user
        );

        return view('tenants.orders.workspace.build', [
            'catalog' => $catalog,
            'door' => $door,
            'doorColors' => $doorColors,
            'sections' => $this->productSectionsFor($catalog, $door, $user),
            'savedCart' => $savedCart,
            'editingQuoteId' => session('editing_quote_id'),
            'editingShippingQuoteId' => session('editing_shipping_quote_id'),
            'pricingContext' => $pricingContext,
            'shippingPopup' => other_page_content('shipping_pop_up'),
            'stockShippingPopup' => other_page_content('stock_check_shipping_pop_up'),
            'shipTerms' => tax_value('ship_quote_terms_and_condition', ''),
        ]);
    }

    public function accordionSearch(Request $request, int $catalogId, int $doorId): View
    {
        $catalog = ProductCatalog::query()->where('status', 1)->findOrFail($catalogId);
        $door = DoorColors::query()->findOrFail($doorId);
        $user = $request->user()->load('roles');
        $sections = $this->productSectionsFor($catalog, $door, $user);

        if ($request->filled('sku')) {
            $term = $request->sku;
            $sections = $sections->map(function (ProductSection $section) use ($term) {
                $filtered = $section->products->filter(function (Product $p) use ($term) {
                    return stripos((string) $p->sku, $term) !== false || stripos((string) $p->label, $term) !== false;
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
            $this->cartPersistence->clearAllForUser($request->user()->id);
        }
        session()->forget(['workspace_checkout', 'job_name', 'rooms', 'cart', 'cart_data']);

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
            $cartData = $this->checkout->buildSessionCartData($payload, $request);
            session([
                'workspace_checkout' => $payload,
                'cart_data' => $cartData,
            ]);
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

    public function checkout(Request $request): View|RedirectResponse
    {
        $cartData = session('cart_data', []);
        if (empty($cartData['job_name'])) {
            return redirect()
                ->route('tenant_order_workspace')
                ->with('error', 'Your checkout session expired. Please build the cart again.');
        }

        $payload = session('workspace_checkout', []);
        $user = $request->user()->load(['country', 'state']);
        $shipState = (string) ($cartData['ship_to_state'] ?? $user->state?->name ?? '');
        $shipCounty = (string) ($cartData['ship_to_county'] ?? $user->county_name ?? '');
        $salesTaxPercent = $this->checkout->salesTaxPercentForLocation($shipState, $shipCounty, $user);
        $feeConfig = $this->checkout->paymentFeeConfig();

        $subTotal = (float) ($payload['totals']['sub_total_cost'] ?? 0);
        $assembleTotal = (float) ($payload['totals']['sub_total_assemble_cost'] ?? 0);
        $shippingCost = (float) ($payload['shipping_cost'] ?? $cartData['order_shipping_cost'] ?? 0);
        $isShippingQuote = (int) ($cartData['is_shipping_quote'] ?? 0) > 0;
        $shippingQuoteId = session('shipping_quote_checkout_id');
        $shippingBreakdown = json_decode((string) ($cartData['shipping_charges_arr'] ?? '[]'), true) ?: [];

        $checkoutTotals = $this->checkout->calculateCheckoutTotals(
            $subTotal,
            $assembleTotal,
            $salesTaxPercent,
            'Credit Card',
            $shippingCost
        );

        $savings = $this->checkout->paymentSavings($subTotal, $assembleTotal, $salesTaxPercent, $shippingCost);

        return view('tenants.orders.workspace.checkout', [
            'cartData' => $cartData,
            'payload' => $payload,
            'salesTaxPercent' => $salesTaxPercent,
            'feeConfig' => $feeConfig,
            'checkoutTotals' => $checkoutTotals,
            'paymentSavings' => $savings,
            'subTotal' => $subTotal,
            'assembleTotal' => $assembleTotal,
            'weight' => $payload['totals']['sub_total_weight'] ?? 0,
            'assembleYes' => ($payload['assemble'] ?? 'no') === 'yes' || (int) ($cartData['is_assemble'] ?? 0) === 1,
            'shippingCost' => $shippingCost,
            'shippingBreakdown' => $shippingBreakdown,
            'isShippingQuote' => $isShippingQuote,
            'shippingQuoteId' => $shippingQuoteId,
            'backToCartUrl' => $isShippingQuote && $shippingQuoteId
                ? route('tenant_shipping_quotes_show', $shippingQuoteId)
                : route('tenant_order_workspace'),
            'backToCartDisabled' => $isShippingQuote,
            'states' => $this->checkout->usStateOptions(),
            'floridaCounties' => $this->checkout->floridaCountyOptions(),
            'catalogId' => $cartData['catalogue'] ?? null,
        ]);
    }

    public function checkoutSalesTax(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ship_state' => 'required|string|max:120',
            'ship_county' => 'nullable|string|max:120',
        ]);

        $user = $request->user();
        $percent = $this->checkout->salesTaxPercentForLocation(
            $validated['ship_state'],
            (string) ($validated['ship_county'] ?? ''),
            $user
        );

        return response()->json(['sales_tax_percent' => $percent]);
    }

    public function checkoutSubmit(Request $request): RedirectResponse
    {
        $cartData = session('cart_data', []);
        $payload = session('workspace_checkout', []);
        if (empty($cartData) || empty($payload)) {
            return redirect()->route('tenant_order_workspace')->with('error', 'Checkout session expired.');
        }

        try {
            $this->checkout->validateCheckout($request);
        } catch (ValidationException $e) {
            return redirect()
                ->route('tenant_order_workspace_checkout')
                ->withErrors($e->errors())
                ->withInput();
        }

        $user = $request->user()->load(['country', 'state']);
        $subTotal = (float) ($payload['totals']['sub_total_cost'] ?? 0);
        $assembleTotal = (float) ($payload['totals']['sub_total_assemble_cost'] ?? 0);
        $salesTaxPercent = (float) ($request->input('updated_sales_tax') ?: $this->checkout->salesTaxPercentForLocation(
            (string) $request->input('ship_state'),
            (string) $request->input('ship_county'),
            $user
        ));
        $paymentType = (string) $request->input('credit_or_not_credit_card');
        $paymentMethod = $this->checkout->resolvePaymentLabel(
            $paymentType,
            $request->input('payment_method')
        );
        $shippingCost = (float) ($payload['shipping_cost'] ?? $cartData['order_shipping_cost'] ?? 0);

        $checkoutTotals = $this->checkout->calculateCheckoutTotals(
            $subTotal,
            $assembleTotal,
            $salesTaxPercent,
            $paymentMethod,
            $shippingCost
        );

        $grandTotal = $checkoutTotals['grand_total'];
        $transactionId = null;
        $orderStatus = 'PENDING';
        $paytraceResponse = '';

        if ($paymentType === 'by_credit_card') {
            $result = $this->paytrace->charge('credit_card', $grandTotal, [
                'card_number' => $request->input('card_number'),
                'expiry_date' => $request->input('expiry_date'),
                'cvv_number' => $request->input('cvv_number'),
                'billing_name' => trim($request->input('checkout_fname').' '.$request->input('checkout_lname')),
                'billing_address' => $request->input('checkout_address'),
                'billing_city' => $request->input('checkout_city'),
                'billing_state' => $request->input('checkout_state'),
                'billing_zip' => $request->input('checkout_zipcode'),
            ]);
            if (! $result['success']) {
                return redirect()
                    ->route('tenant_order_workspace_checkout')
                    ->withInput()
                    ->with('error', $result['status_message']);
            }
            $transactionId = $result['transaction_id'] ?? null;
            $orderStatus = 'PAID';
            $paytraceResponse = $result['status_message'];
        } elseif ($paymentType === 'by_debit_card') {
            $result = $this->paytrace->charge('debit_card', $grandTotal, [
                'card_number' => $request->input('debit_card_number'),
                'expiry_date' => $request->input('debit_expiry_date'),
                'cvv_number' => $request->input('debit_cvv_number'),
                'billing_name' => trim($request->input('debit_checkout_fname').' '.$request->input('debit_checkout_lname')),
                'billing_address' => $request->input('debit_checkout_address'),
                'billing_city' => $request->input('debit_checkout_city'),
                'billing_state' => $request->input('debit_checkout_state'),
                'billing_zip' => $request->input('debit_checkout_zipcode'),
            ]);
            if (! $result['success']) {
                return redirect()
                    ->route('tenant_order_workspace_checkout')
                    ->withInput()
                    ->with('error', $result['status_message']);
            }
            $transactionId = $result['transaction_id'] ?? null;
            $orderStatus = 'PAID';
            $paytraceResponse = $result['status_message'];
        } elseif ($paymentType === 'pay_ach') {
            $result = $this->paytrace->charge('ach', $grandTotal, [
                'account_number' => $request->input('account_number'),
                'routing_number' => $request->input('route_number'),
                'billing_name' => trim($request->input('ach_checkout_fname').' '.$request->input('ach_checkout_lname')),
                'billing_address' => $request->input('ach_checkout_address'),
                'billing_city' => $request->input('ach_checkout_city'),
                'billing_state' => $request->input('ach_checkout_state'),
                'billing_zip' => $request->input('ach_checkout_zipcode'),
            ]);
            if (! $result['success']) {
                return redirect()
                    ->route('tenant_order_workspace_checkout')
                    ->withInput()
                    ->with('error', $result['status_message']);
            }
            $transactionId = $result['check_transaction_id'] ?? $result['transaction_id'] ?? null;
            $orderStatus = 'PAID';
            $paytraceResponse = $result['status_message'];
        }

        $order = Order::create([
            'job_name' => $payload['job_name'],
            'rooms' => $payload['rooms'],
            'assemble_cabinets_check' => $payload['assemble'] ?? 'no',
            'shipping_status' => 'pending',
            'comment' => $payload['comment'] ?? '',
            'user_id' => $user->id,
            'user_address' => $this->workspace->formatUserAddress($user),
            'user_email' => $user->email,
            'user_phone' => $user->phone,
            'fuel_tax' => (string) $checkoutTotals['fuel_percent'],
            'fuel_charges' => $checkoutTotals['fuel_amount'],
            'fuel_charges_pertcentage' => (string) $checkoutTotals['fuel_percent'],
            'sales_tax' => (string) $salesTaxPercent,
            'sub_total_cost' => $subTotal,
            'sub_total_weight' => $payload['totals']['sub_total_weight'] ?? 0,
            'sub_total_assemble_cost' => $assembleTotal,
            'grand_total_cost' => $grandTotal,
            'order_amount' => $grandTotal,
            'amount' => $checkoutTotals['amount_before_tax'] + $checkoutTotals['sales_tax_amount'],
            'shipping_cost' => $shippingCost > 0 ? (string) $shippingCost : $request->input('self_ship', 'pickup'),
            'order_payment_type' => $paymentMethod,
            'transaction_pro_id' => $transactionId,
            'status' => $orderStatus,
            'paytrace_response' => $paytraceResponse,
            'credit_card_charges' => $checkoutTotals['credit_card_charges'] + $checkoutTotals['debit_card_charges'],
            'ach_charges' => $checkoutTotals['ach_charges'],
        ]);

        $cartData = array_merge($cartData, [
            'bill_to_name' => $request->input('bill_to_name'),
            'bill_to_address' => $request->input('bill_to_address'),
            'bill_to_email' => $request->input('bill_to_email'),
            'bill_to_phone' => $request->input('bill_to_phone'),
            'bill_to_city' => $request->input('bill_to_city'),
            'bill_to_county' => $request->input('bill_to_county'),
            'bill_to_state' => $request->input('bill_to_state'),
            'bill_to_zipcode' => $request->input('bill_to_zip'),
            'bill_to_country' => $request->input('bill_to_country'),
            'ship_to_name' => $request->input('ship_to_name'),
            'ship_to_address' => $request->input('ship_to_address'),
            'ship_to_city' => $request->input('ship_city'),
            'ship_to_county' => $request->input('ship_county'),
            'ship_to_state' => $request->input('ship_state'),
            'ship_to_zipcode' => $request->input('ship_zip'),
            'ship_to_country' => $request->input('ship_country'),
            'ship_to_email' => $request->input('ship_to_email'),
            'ship_to_phone' => $request->input('ship_to_phone'),
        ]);

        try {
            $this->notifications->sendOrderPlacedEmails($order, $user, $checkoutTotals, $cartData);
        } catch (\Throwable) {
            // Templates may be missing; order is still saved.
        }

        session()->forget(['workspace_checkout', 'cart_data', 'shipping_quote_checkout_id']);

        TenantNotificationService::flashToast(
            'Order #'.$order->id.' placed successfully! You can file a claim from this order when needed.',
            'success',
            'Order placed',
            route('tenant_order_show', $order->id, false),
        );

        return redirect()->route('tenant_order_show', $order->id);
    }

    public function printOrder(int $id): View
    {
        $order = Order::query()->with('user')->findOrFail($id);

        return view('tenants.orders.workspace.print', ['order' => $order]);
    }

    /**
     * @return Collection<int, ProductSection>
     */
    protected function productSectionsFor(ProductCatalog $catalog, DoorColors $door, $user): Collection
    {
        $context = $this->pricing->contextFor($user, $catalog->id, $door->id);

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

        return $this->pricing->applyPricingToSections($sections, $context);
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
        return $this->persist($request, StockCheckRequest::class, 'tenant_stock_check_show', 'Stock check request submitted successfully.', 'pending');
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
        $clearCart = $this->shouldClearWorkspaceCart($modelClass);
        try {
            $payload = $this->workspace->parsePayload($request, $defaultShippingStatus);
            $payload = $this->mergeWorkspaceMeta($request, $payload);

            $record = $this->resolveWorkspaceRecord($request, $modelClass, $payload);
            $this->sendActionEmails($modelClass, $payload, $record);

            if ($clearCart) {
                $this->clearWorkspaceCart($request);
                session()->forget(['editing_quote_id', 'editing_shipping_quote_id', 'editing_stock_check_id']);
            }
        } catch (ValidationException $e) {
            return response()->json([
                'message' => collect($e->errors())->flatten()->first() ?? 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'message' => config('app.debug') ? $e->getMessage() : 'Could not save. Please try again.',
            ], 500);
        }

        $redirect = $this->persistRedirectUrl($redirectRoute, $record);

        return response()->json([
            'message' => $message,
            'clear_cart' => $clearCart,
            'redirect' => $redirect,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    protected function persistRedirectUrl(string $redirectRoute, $record): string
    {
        $recordId = $record?->id;

        if ($redirectRoute === 'tenant_order_workspace_print_page' && $recordId) {
            return route('tenant_order_workspace_print_page', $recordId);
        }

        if (in_array($redirectRoute, [
            'tenant_shipping_quotes_show',
            'tenant_quotes_show',
            'tenant_stock_check_show',
        ], true) && $recordId) {
            return route($redirectRoute, $recordId);
        }

        return route($redirectRoute);
    }

    protected function mergeWorkspaceMeta(Request $request, array $payload): array
    {
        return array_merge($payload, [
            'product_catalog_id' => (int) $request->input('catalog_id'),
            'door_color_id' => (int) $request->input('door_id'),
            'product_img_src' => $request->input('product_img_src'),
            'product_img_name' => $request->input('product_img_name'),
        ]);
    }

    /**
     * @param  class-string<\Illuminate\Database\Eloquent\Model>  $modelClass
     */
    protected function resolveWorkspaceRecord(Request $request, string $modelClass, array $payload)
    {
        $quoteId = (int) ($request->input('quote_saved_id') ?: session('editing_quote_id'));
        $shippingQuoteId = (int) ($request->input('shipping_quote_saved_id') ?: session('editing_shipping_quote_id'));
        $stockCheckId = (int) ($request->input('stock_check_saved_id') ?: session('editing_stock_check_id'));

        if ($modelClass === Quote::class && $quoteId > 0) {
            $quote = Quote::query()->findOrFail($quoteId);
            if ((int) $quote->user_id !== (int) $request->user()->id && ! $request->user()->hasRole('Admin')) {
                abort(403);
            }

            return $this->workspace->updateRecord($quote, $payload);
        }

        if ($modelClass === ShippingQuote::class && $shippingQuoteId > 0) {
            $shippingQuote = ShippingQuote::query()->findOrFail($shippingQuoteId);
            if ((int) $shippingQuote->user_id !== (int) $request->user()->id && ! $request->user()->hasRole('Admin')) {
                abort(403);
            }

            return $this->workspace->updateRecord($shippingQuote, $payload);
        }

        if ($modelClass === StockCheckRequest::class && $stockCheckId > 0) {
            $stockCheck = StockCheckRequest::query()->findOrFail($stockCheckId);
            if ((int) $stockCheck->user_id !== (int) $request->user()->id && ! $request->user()->hasRole('Admin')) {
                abort(403);
            }

            return $this->workspace->updateRecord($stockCheck, $payload);
        }

        return $this->workspace->createRecord($modelClass, $payload);
    }

    protected function shouldClearWorkspaceCart(string $modelClass): bool
    {
        return in_array($modelClass, [Quote::class, ShippingQuote::class, StockCheckRequest::class], true);
    }

    protected function clearWorkspaceCart(Request $request): void
    {
        $user = $request->user();
        $catalogId = (int) $request->input('catalog_id');

        if ($user && $catalogId > 0) {
            $this->cartPersistence->clear($user->id, $catalogId);
        }

        session()->forget(['workspace_checkout', 'cart_data']);
    }

    /**
     * When reopening a quote/shipping quote, ensure cart comment matches the saved record.
     *
     * @param  array<string, mixed>|null  $savedCart
     * @return array<string, mixed>|null
     */
    protected function enrichSavedCartForEditing(?array $savedCart, $user): ?array
    {
        $cart = $savedCart ?? [];

        $quoteId = (int) session('editing_quote_id');
        if ($quoteId > 0) {
            $quote = Quote::query()->find($quoteId);
            if ($quote && $this->quoteWorkspace->userMayAccess($quote, $user)) {
                $cart['order_comment'] = $this->quoteWorkspace->workspaceCommentForCart($quote);
            }
        }

        $shippingQuoteId = (int) session('editing_shipping_quote_id');
        if ($shippingQuoteId > 0) {
            $shippingQuote = ShippingQuote::query()->find($shippingQuoteId);
            if ($shippingQuote && $this->quoteWorkspace->userMayAccess($shippingQuote, $user)) {
                $cart['order_comment'] = $this->quoteWorkspace->workspaceCommentForCart($shippingQuote);
            }
        }

        $stockCheckId = (int) session('editing_stock_check_id');
        if ($stockCheckId > 0) {
            $stockCheck = StockCheckRequest::query()->find($stockCheckId);
            if ($stockCheck && $this->quoteWorkspace->userMayAccess($stockCheck, $user)) {
                $cart['order_comment'] = $this->quoteWorkspace->workspaceCommentForCart($stockCheck);
            }
        }

        return $cart !== [] ? $cart : null;
    }

    protected function sendActionEmails(string $modelClass, array $payload, $record): void
    {
        $user = $payload['user'] ?? null;
        if (! $user) {
            return;
        }

        try {
            if ($modelClass === Quote::class) {
                $this->notifications->sendQuoteSavedEmails($record, $user, $payload);
            }
            if ($modelClass === ShippingQuote::class) {
                $costs = $payload['shipping_costs'] ?? [];
                $this->notifications->sendShippingQuoteEmails($record, $user, $costs);
            }
            if ($modelClass === StockCheckRequest::class) {
                $withShipping = ! empty($payload['shipping_costs']);
                $this->notifications->sendStockCheckEmails(
                    $record,
                    $user,
                    $payload['shipping_costs'] ?? [],
                    $withShipping
                );
            }
        } catch (\Throwable) {
            // Email templates may be missing in some tenants; do not block save.
        }
    }
}
