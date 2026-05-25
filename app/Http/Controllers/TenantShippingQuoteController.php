<?php

namespace App\Http\Controllers;

use App\Models\ShippingQuote;
use App\Services\AdminRecordViewService;
use App\Services\OrderWorkspaceService;
use App\Services\QuoteWorkspaceService;
use App\Services\ShippingQuoteAdminViewService;
use App\Services\TenantNavBadgeService;
use App\Support\TenantListPaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TenantShippingQuoteController extends Controller
{
    public function __construct(
        protected OrderWorkspaceService $workspace,
        protected QuoteWorkspaceService $recordWorkspace,
        protected ShippingQuoteAdminViewService $shippingAdminView,
    ) {}

    public function index(Request $request, TenantNavBadgeService $navBadges): View
    {
        $perPage = TenantListPaginator::perPage($request);
        $search = TenantListPaginator::search($request);
        $query = $this->workspace->listQuery(ShippingQuote::class, Auth::user());

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('job_name', 'like', '%'.$search.'%')
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', '%'.$search.'%')
                            ->orWhere('email', 'like', '%'.$search.'%');
                    });
            });
        }

        $records = $query->paginate($perPage)->withQueryString();

        $view = Auth::user()->isAdmin()
            ? 'tenants.quotes.shipping_quotes_list'
            : 'tenants.representative_modals.quotes.shipping_quotes_list';

        return view($view, compact('records', 'perPage', 'search'));
    }

    public function show(string $id, AdminRecordViewService $adminView): View
    {
        $record = ShippingQuote::query()->with('user')->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($record, Auth::user())) {
            abort(403);
        }

        $adminView->markViewed($record, Auth::user());

        if (Auth::user()->isAdmin()) {
            return view('tenants.quotes.show_shipping_quotes', [
                'adminView' => $this->shippingAdminView->viewData($record),
            ]);
        }

        return view('tenants.representative_modals.quotes.show_shipping_quotes', [
            'userView' => $this->shippingAdminView->viewData($record),
            'canProceedToCheckout' => $this->shippingAdminView->canProceedToCheckout($record),
            'proceedCheckoutRoute' => route('tenant_shipping_quotes_proceed_checkout', $record->id),
        ]);
    }

    public function proceedToCheckout(string $id): RedirectResponse
    {
        $record = ShippingQuote::query()->with('user')->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($record, Auth::user())) {
            abort(403);
        }

        if (! $this->shippingAdminView->canProceedToCheckout($record)) {
            return redirect()
                ->route('tenant_shipping_quotes_show', $record->id)
                ->with('error', 'Shipping charges are not ready yet. Please wait for an administrator to complete your quote.');
        }

        try {
            $session = $this->shippingAdminView->buildCheckoutSession($record, Auth::user());
        } catch (\InvalidArgumentException $e) {
            return redirect()
                ->route('tenant_shipping_quotes_show', $record->id)
                ->with('error', $e->getMessage());
        }

        session([
            'workspace_checkout' => $session['payload'],
            'cart_data' => $session['cartData'],
            'shipping_quote_checkout_id' => $record->id,
        ]);

        return redirect()->route('tenant_order_workspace_checkout');
    }

    public function updateShippingCosts(Request $request, string $id): RedirectResponse
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $record = ShippingQuote::query()->findOrFail($id);

        $validated = $request->validate([
            'total_pallets' => 'required|integer|min:1|max:999',
            'delivery_cost' => 'required|numeric|min:0',
            'liftgate_cost' => 'required|numeric|min:0',
            'unload_cost' => 'required|numeric|min:0',
            'miscellaneous_cost' => 'required|numeric|min:0',
        ]);

        $this->shippingAdminView->applyAdminShippingUpdate($record, $validated);

        app(AdminRecordViewService::class)->markViewed($record, Auth::user());

        return redirect()
            ->route('tenant_shipping_quotes_show', $record->id)
            ->with('success', 'Shipping quote charges updated successfully.');
    }

    public function edit(string $id, AdminRecordViewService $adminView): RedirectResponse
    {
        $record = ShippingQuote::query()->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($record, Auth::user())) {
            abort(403);
        }

        $adminView->markViewed($record, Auth::user());

        return $this->recordWorkspace->restoreToWorkspace($record, Auth::user());
    }

    public function destroy(string $id): RedirectResponse
    {
        $record = ShippingQuote::query()->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($record, Auth::user())) {
            abort(403);
        }

        $record->delete();

        return redirect()
            ->route('tenant_shipping_quotes_index')
            ->with('success', 'Shipping quote deleted successfully.');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('tenant_order_workspace')
            ->with('info', 'Use the order workspace: pick catalog → door style → build cart → Request shipping quote.');
    }

    /**
     * @return array<string, mixed>
     */
    protected function detailViewData(ShippingQuote $record): array
    {
        return [
            'record' => $record,
            'recordLabel' => 'Shipping quote',
            'nameRowLabel' => 'Shipping quote name',
            'recordName' => $this->recordWorkspace->displayRecordName($record),
            'catalogLabel' => $this->recordWorkspace->catalogLabel($record),
            'doorLabel' => $record->product_img_name ?? '—',
            'billName' => $this->recordWorkspace->billName($record),
            'shipName' => $this->recordWorkspace->shipName($record),
            'rooms' => $record->rooms ?? [],
            'listRoute' => 'tenant_shipping_quotes_index',
            'editRoute' => 'tenant_shipping_quotes_edit',
        ];
    }
}
