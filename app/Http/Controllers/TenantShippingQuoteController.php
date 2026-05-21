<?php

namespace App\Http\Controllers;

use App\Models\ShippingQuote;
use App\Services\OrderWorkspaceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TenantShippingQuoteController extends Controller
{
    public function __construct(
        protected OrderWorkspaceService $workspace,
    ) {}

    public function index(): View
    {
        $records = $this->workspace
            ->listQuery(ShippingQuote::class, Auth::user())
            ->paginate(tenant_list_per_page())
            ->withQueryString();

        $view = Auth::user()->hasRole('Admin')
            ? 'tenants.quotes.shipping_quotes_list'
            : 'tenants.representative_modals.quotes.shipping_quotes_list';

        return view($view, compact('records'));
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('tenant_order_workspace')
            ->with('info', 'Use the order workspace: pick catalog → door style → build cart → Request shipping quote.');
    }
}
