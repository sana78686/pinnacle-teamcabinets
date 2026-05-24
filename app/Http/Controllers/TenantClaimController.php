<?php

namespace App\Http\Controllers;

use App\Models\ClaimsOrder;
use App\Models\Order;
use App\Services\AdminRecordViewService;
use App\Services\ClaimWorkspaceService;
use App\Services\QuoteWorkspaceService;
use App\Services\TenantNavBadgeService;
use App\Support\TenantListPaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TenantClaimController extends Controller
{
    public function __construct(
        protected ClaimWorkspaceService $claims,
        protected QuoteWorkspaceService $recordWorkspace,
    ) {}

    public function index(Request $request, TenantNavBadgeService $navBadges): View
    {
        $perPage = TenantListPaginator::perPage($request);
        $search = TenantListPaginator::search($request);
        $query = $this->claims->listQuery(Auth::user());

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('claims_order_message', 'like', '%'.$search.'%')
                    ->orWhere('claims_order_id', 'like', '%'.$search.'%')
                    ->orWhereHas('claimant', fn ($u) => $u->where('name', 'like', '%'.$search.'%'));
            });
        }

        $view = Auth::user()->hasRole('Admin')
            ? 'tenants.claims.index'
            : 'tenants.claims.rep_index';

        return view($view, [
            'claims' => $query->paginate($perPage)->withQueryString(),
            'perPage' => $perPage,
            'search' => $search,
            'isAdmin' => Auth::user()->hasRole('Admin'),
        ]);
    }

    public function create(Request $request): View|RedirectResponse
    {
        $orderId = $request->query('order_id');
        if ($orderId) {
            return redirect()->route('tenant_order_show', $orderId)
                ->with('info', 'Use the Claim button on the order to submit a claim for completed orders.');
        }

        $orders = Order::query()
            ->when(! Auth::user()->hasRole('Admin'), fn ($q) => $q->where('user_id', Auth::id()))
            ->orderByDesc('id')
            ->limit(50)
            ->get()
            ->filter(fn (Order $o) => $this->claims->orderEligibleForClaim($o));

        return view('tenants.claims.create', [
            'orders' => $orders,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'claims_order_id' => 'required|integer|exists:orders,id',
            'claims_order_message' => 'required|string|max:5000',
            'get_select_checkbox_val' => 'required|array|min:1',
            'get_select_checkbox_val.*' => 'required|string',
        ]);

        $order = Order::query()->with('user')->findOrFail($validated['claims_order_id']);

        if (! $this->recordWorkspace->userMayAccess($order, Auth::user())) {
            abort(403);
        }

        if (! $this->claims->orderEligibleForClaim($order)) {
            return redirect()
                ->route('tenant_order_show', $order->id)
                ->with('error', 'Claims are only available after the order is paid/completed.');
        }

        $imageFiles = [];
        foreach ($request->allFiles() as $key => $files) {
            if (preg_match('/^claims_order_image_(.+)$/', $key, $m)) {
                $sku = $m[1];
                $imageFiles[$sku] = is_array($files) ? $files : [$files];
            }
        }

        $products = $this->claims->parseSelectedProducts(
            $validated['get_select_checkbox_val'],
            $imageFiles
        );

        if ($products === []) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Select at least one product to include in the claim.');
        }

        $claim = $this->claims->storeClaim(
            $order,
            Auth::user(),
            $validated['claims_order_message'],
            $products
        );

        return redirect()
            ->route('tenant_claim_show', $claim->id)
            ->with('success', 'Your claim was submitted successfully. You and our team have been notified by email.');
    }

    public function show(string $id, AdminRecordViewService $adminView): View
    {
        $claim = ClaimsOrder::query()->with(['order.user', 'claimant'])->findOrFail($id);

        if (! $this->claims->userMayAccess($claim, Auth::user())) {
            abort(403);
        }

        $adminView->markViewed($claim, Auth::user());

        return view('tenants.claims.show', [
            'claim' => $claim,
            'order' => $claim->order,
            'repName' => $this->claims->representativeNameFor($claim),
            'isAdmin' => Auth::user()->hasRole('Admin'),
        ]);
    }

    public function destroy(string $id): RedirectResponse
    {
        if (! Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $claim = ClaimsOrder::query()->findOrFail($id);
        $claim->delete();

        return redirect()
            ->route('tenant_claim_index')
            ->with('success', 'Claim #'.$id.' deleted.');
    }

    public function deletedclaimList(): View
    {
        if (! Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $claims = ClaimsOrder::onlyTrashed()
            ->with(['order', 'claimant'])
            ->orderByDesc('id')
            ->paginate(TenantListPaginator::perPage(request()));

        return view('tenants.claims.deleted_claim_list', ['claims' => $claims]);
    }

    public function restoreDeletedclaim(string $id): RedirectResponse
    {
        if (! Auth::user()->hasRole('Admin')) {
            abort(403);
        }

        $claim = ClaimsOrder::onlyTrashed()->findOrFail($id);
        $claim->restore();

        return redirect()
            ->route('tenant_deleted_claim_list')
            ->with('success', 'Claim #'.$id.' restored.');
    }
}
