<?php

namespace App\Http\Controllers;

use App\Services\TenantPanelSearchService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TenantPanelSearchController extends Controller
{
    public function __invoke(Request $request, TenantPanelSearchService $search): JsonResponse
    {
        $request->validate([
            'q' => 'nullable|string|max:80',
        ]);

        $query = (string) $request->input('q', '');

        return response()->json([
            'results' => $search->suggest($query),
        ]);
    }
}
