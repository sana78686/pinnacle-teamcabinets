<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Services\OrderWorkspaceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TenantQuotesController extends Controller
{
    public function __construct(
        protected OrderWorkspaceService $workspace,
    ) {}

    public function index(): View
    {
        $records = $this->workspace
            ->listQuery(Quote::class, Auth::user())
            ->paginate(tenant_list_per_page())
            ->withQueryString();

        $view = Auth::user()->hasRole('Admin')
            ? 'tenants.quotes.index'
            : 'tenants.representative_modals.quotes.index';

        return view($view, compact('records'));
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('tenant_order_workspace');
    }

    public function edit(string $id){

        return view('tenants.quotes.edit');
    }

    public function show(string $id){

        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.quotes.show');
        }
        else
        {
            return view('tenants.representative_modals.quotes.show');
        }
        // return view('tenants.quotes.show');
    }



    public function deleted_quotes_list()

    {
        // $data['product_section'] = ProductSection::onlyTrashed()->get();
        return view('tenants.quotes.deleted_quotes_list');
    }

    public function restoreDeletedproductsection($id)
    {
        // $product_section = ProductSection::onlyTrashed()->findOrFail($id);
        // if (!$product_section) {
        //     session()->flash('error', 'Product Section cannot found.');
        //     return redirect()->back();
        // }
        // $product_section->restore(); // Restore the user
        // return redirect()->route('tenant_deleted_product_section_list')
        //     ->with('success', 'product_section.'.$product_section->name.'. Restored successfully');
    }

    public function shipping_quotes_create(): RedirectResponse
    {
        return redirect()->route('tenant_order_workspace');
    }

    public function shipping_quotes_edit(string $id){
        return view('tenants.quotes.edit_shipping_quotes');
    }
    public function shipping_quotes_show(){
        if(Auth::user()->hasRole('Admin'))
        {
            return view('tenants.quotes.show_shipping_quotes');
        }
        else
        {
            return view('tenants.representative_modals.quotes.show_shipping_quotes');
        }
        // return view('tenants.quotes.show_shipping_quotes');
    }
    public function deleted_shipping_quotes_list()

    {
        // $data['product_section'] = ProductSection::onlyTrashed()->get();
        return view('tenants.quotes.deleted_shipping_quotes_list');
    }

    public function store(Request $request): RedirectResponse
    {
        return redirect()->route('tenant_order_workspace')
            ->with('info', 'Use the order workspace: pick catalog → door style → build cart → Save quote.');
    }
}
