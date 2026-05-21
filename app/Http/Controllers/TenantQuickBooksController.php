<?php

namespace App\Http\Controllers;

use App\Services\QuickBooksOAuthService;
use Illuminate\Http\JsonResponse;
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
            'defaultRedirectUri' => $quickBooks->defaultRedirectUri(),
        ]);
    }

    public function storeCredentials(Request $request, QuickBooksOAuthService $quickBooks): RedirectResponse
    {
        $request->validate([
            'client_id' => 'required|string|max:255',
            'client_secret' => 'required|string|max:500',
            'redirect_uri' => 'required|url|max:512',
            'qb_environment' => 'required|in:sandbox,production',
        ]);

        $quickBooks->saveCredentials($request->only([
            'client_id',
            'client_secret',
            'redirect_uri',
            'qb_environment',
        ]));

        return redirect()
            ->route('tenant_quickbooks_index')
            ->with('success', 'QuickBooks API credentials saved for this tenant.');
    }

    public function testConnection(QuickBooksOAuthService $quickBooks): JsonResponse
    {
        $result = $quickBooks->testConnection();

        return response()->json($result, $result['ok'] ? 200 : 422);
    }

    public function connect(QuickBooksOAuthService $quickBooks): RedirectResponse
    {
        if (! $quickBooks->isConfigured()) {
            return redirect()->route('tenant_quickbooks_index')
                ->with('error', 'Save QuickBooks Client ID, Secret, and Redirect URI below first.');
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
