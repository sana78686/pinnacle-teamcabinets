<?php

namespace App\Http\Controllers;

use App\Models\ContactQuery;
use App\Services\AdminRecordViewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TenantContactQueryController extends Controller
{
    public function index(): View
    {
        $perPage = max(5, min(100, (int) request('per_page', tenant_list_per_page())));
        $search = trim((string) request('search', ''));

        $queries = ContactQuery::query()
            ->when($search !== '', function ($q) use ($search) {
                $q->where(function ($inner) use ($search) {
                    $inner->where('name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            })
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('tenants.contact_queries.index', compact('queries', 'perPage', 'search'));
    }

    public function show(ContactQuery $contactQuery): View
    {
        app(AdminRecordViewService::class)->markViewed($contactQuery);

        return view('tenants.contact_queries.show', ['query' => $contactQuery]);
    }

    public function destroy(ContactQuery $contactQuery): RedirectResponse
    {
        $contactQuery->delete();

        return redirect()->route('tenant_contact_queries_index')
            ->with('success', 'Contact message deleted.');
    }
}
