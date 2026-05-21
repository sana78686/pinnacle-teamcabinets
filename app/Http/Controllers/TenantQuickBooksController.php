<?php

namespace App\Http\Controllers;

use App\Services\QuickBooksOAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantQuickBooksController extends Controller
{
    public function index(QuickBooksOAuthService $quickBooks): View
    {
        $setting = \App\Models\TenantQuickBooksSetting::query()->first();

        return view('tenants.setting.manage_quickbooks', [
            'setting' => $setting,
            'configured' => $quickBooks->isConfigured(),
        ]);
    }

    public function connect(QuickBooksOAuthService $quickBooks): RedirectResponse
    {
        if (! $quickBooks->isConfigured()) {
            return redirect()->route('tenant_quickbooks_index')
                ->with('error', 'QuickBooks is not configured on the server. Set QUICKBOOKS_CLIENT_ID, QUICKBOOKS_CLIENT_SECRET, and QUICKBOOKS_REDIRECT_URI in .env.');
        }

        return redirect()->away($quickBooks->authorizationUrl());
    }

    public function callback(Request $request, QuickBooksOAuthService $quickBooks): RedirectResponse
    {
        if ($request->get('state') !== session('quickbooks_oauth_state')) {
            return redirect()->route('tenant_quickbooks_index')
                ->with('error', 'Invalid OAuth state. Please try connecting again.');
        }

        if ($request->filled('error')) {
            return redirect()->route('tenant_quickbooks_index')
                ->with('error', 'QuickBooks authorization was denied or failed.');
        }

        $code = $request->get('code');
        $realmId = $request->get('realmId');

        if (! $code || ! $realmId) {
            return redirect()->route('tenant_quickbooks_index')
                ->with('error', 'Missing authorization code from QuickBooks.');
        }

        try {
            $quickBooks->exchangeCode($code, $realmId);
            session()->forget('quickbooks_oauth_state');

            return redirect()->route('tenant_quickbooks_index')
                ->with('success', 'QuickBooks connected successfully.');
        } catch (\Throwable $e) {
            report($e);

            return redirect()->route('tenant_quickbooks_index')
                ->with('error', 'Could not complete QuickBooks connection: '.$e->getMessage());
        }
    }

    public function disconnect(QuickBooksOAuthService $quickBooks): RedirectResponse
    {
        $quickBooks->disconnect();

        return redirect()->route('tenant_quickbooks_index')
            ->with('success', 'QuickBooks disconnected.');
    }
}
