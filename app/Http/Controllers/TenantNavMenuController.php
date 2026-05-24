<?php

namespace App\Http\Controllers;

use App\Services\TenantAdminNavService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TenantNavMenuController extends Controller
{
    public function __construct(
        protected TenantAdminNavService $navMenu,
    ) {}

    public function edit(Request $request): View
    {
        abort_unless(tenant_user_is_panel_admin(), 403);

        return view('tenants.settings.nav-menu', [
            'navItems' => $this->navMenu->customizableItemsForUser($request->user()),
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        abort_unless(tenant_user_is_panel_admin(), 403);

        $validated = $request->validate([
            'order' => 'required|array',
            'order.*' => 'required|string|max:64',
        ]);

        $this->navMenu->saveOrderForUser($request->user(), $validated['order']);

        return response()->json([
            'ok' => true,
            'message' => 'Navigation order saved.',
        ]);
    }

    public function reset(Request $request): JsonResponse
    {
        abort_unless(tenant_user_is_panel_admin(), 403);

        $this->navMenu->resetOrderForUser($request->user());

        return response()->json([
            'ok' => true,
            'message' => 'Navigation reset to default.',
            'items' => $this->navMenu->customizableItemsForUser($request->user()),
        ]);
    }
}
