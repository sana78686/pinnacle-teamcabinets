<?php

namespace App\Http\Controllers;

use App\Services\CatalogSalesAnalyticsService;
use Illuminate\Http\JsonResponse;

class TenantDashboardAnalyticsController extends Controller
{
    public function catalogSales(CatalogSalesAnalyticsService $analytics): JsonResponse
    {
        return response()->json(['data' => $analytics->catalogSalesByPeriod()]);
    }
}
