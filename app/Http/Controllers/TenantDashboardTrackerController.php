<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Quote;
use App\Models\StockCheckRequest;
use App\Services\AdminRecordViewService;
use App\Services\TenantOrderTrackerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TenantDashboardTrackerController extends Controller
{
    public function update(Request $request, TenantOrderTrackerService $tracker): JsonResponse
    {
        $request->validate([
            'order_id' => 'nullable|integer',
            'sc_id' => 'nullable|integer',
            'mq_id' => 'nullable|integer',
        ]);

        $tracker->updateRow($request->all());

        return response()->json(['ok' => true]);
    }

    public function markViewed(Request $request, AdminRecordViewService $views): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:order,quote,stock_check',
            'id' => 'required|integer|min:1',
        ]);

        $model = match ($request->type) {
            'order' => Order::query()->find($request->id),
            'quote' => Quote::query()->find($request->id),
            'stock_check' => StockCheckRequest::query()->find($request->id),
        };

        if ($model) {
            $views->markViewed($model);
        }

        return response()->json(['ok' => true]);
    }
}
