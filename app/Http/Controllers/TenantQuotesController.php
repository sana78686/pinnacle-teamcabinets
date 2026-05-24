<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Services\AdminRecordViewService;
use App\Services\OrderWorkspaceService;
use App\Services\QuoteShowViewService;
use App\Services\QuoteWorkspaceService;
use App\Services\TenantNavBadgeService;
use App\Support\TenantListPaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TenantQuotesController extends Controller
{
    public function __construct(
        protected OrderWorkspaceService $workspace,
        protected QuoteWorkspaceService $recordWorkspace,
    ) {}

    public function index(Request $request, TenantNavBadgeService $navBadges): View
    {
        $perPage = TenantListPaginator::perPage($request);
        $search = TenantListPaginator::search($request);
        $query = $this->workspace->listQuery(Quote::class, Auth::user());

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

        $view = Auth::user()->hasRole('Admin')
            ? 'tenants.quotes.index'
            : 'tenants.representative_modals.quotes.index';

        return view($view, compact('records', 'perPage', 'search'));
    }

    public function edit(string $id, AdminRecordViewService $adminView): RedirectResponse
    {
        $quote = Quote::query()->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($quote, Auth::user())) {
            abort(403);
        }

        $adminView->markViewed($quote, Auth::user());

        return $this->recordWorkspace->restoreToWorkspace($quote, Auth::user());
    }

    public function show(string $id, AdminRecordViewService $adminView, QuoteShowViewService $quoteShow): View
    {
        $quote = Quote::query()->with('user')->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($quote, Auth::user())) {
            abort(403);
        }

        $adminView->markViewed($quote, Auth::user());

        $view = Auth::user()->hasRole('Admin')
            ? 'tenants.quotes.show'
            : 'tenants.representative_modals.quotes.show';

        return view($view, [
            'quoteView' => $quoteShow->viewDataForQuote($quote),
        ]);
    }

    public function destroy(string $id): RedirectResponse
    {
        $quote = Quote::query()->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($quote, Auth::user())) {
            abort(403);
        }

        $quote->delete();

        return redirect()
            ->route('tenant_quotes_index')
            ->with('success', 'Quote deleted successfully.');
    }

    public function deleted_quotes_list()
    {
        return view('tenants.quotes.deleted_quotes_list');
    }

    public function restoreDeletedproductsection($id) {}

    public function deleted_shipping_quotes_list()
    {
        return view('tenants.quotes.deleted_shipping_quotes_list');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('tenant_order_workspace')
            ->with('info', 'Use the order workspace: pick catalog → door style → build cart → Save quote.');
    }
}
