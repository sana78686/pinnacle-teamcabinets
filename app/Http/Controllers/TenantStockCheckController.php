<?php

namespace App\Http\Controllers;

use App\Models\StockCheckRequest;
use App\Services\AdminRecordViewService;
use App\Services\OrderWorkspaceNotificationService;
use App\Services\OrderWorkspaceService;
use App\Services\QuoteWorkspaceService;
use App\Services\StockCheckAdminViewService;
use App\Support\TenantListPaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class TenantStockCheckController extends Controller
{
    public function __construct(
        protected OrderWorkspaceService $workspace,
        protected QuoteWorkspaceService $recordWorkspace,
        protected StockCheckAdminViewService $stockAdminView,
    ) {}

    public function index(Request $request): View
    {
        $perPage = TenantListPaginator::perPage($request);
        $search = TenantListPaginator::search($request);
        $query = StockCheckRequest::query()
            ->select($this->listColumns())
            ->with(['user:id,name,email,company_name'])
            ->orderByDesc('id');

        if (! Auth::user()->isAdmin()) {
            $query->where('user_id', Auth::id());
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('job_name', 'like', '%'.$search.'%')
                    ->orWhere('bill_to_name', 'like', '%'.$search.'%')
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', '%'.$search.'%')
                            ->orWhere('email', 'like', '%'.$search.'%')
                            ->orWhere('company_name', 'like', '%'.$search.'%');
                    });
            });
        }

        $data = [
            'stock_check_requests' => $query->paginate($perPage)->withQueryString(),
            'perPage' => $perPage,
            'search' => $search,
        ];

        if (Auth::user()->isAdmin()) {
            return view('tenants.stock_check.index', $data);
        }

        return view('tenants.representative_modals.stock_check.index', $data);
    }

    public function show(Request $request, string $id, AdminRecordViewService $adminView): View
    {
        $stockCheck = StockCheckRequest::query()->with('user')->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($stockCheck, Auth::user())) {
            abort(403);
        }

        $viewingOrgData = $request->query('view') === 'org';
        $rooms = $viewingOrgData
            ? $stockCheck->normalizedOriginalRooms()
            : $stockCheck->normalizedRooms();

        if (Auth::user()->isAdmin()) {
            $adminView->markViewed($stockCheck, Auth::user());

            return view('tenants.stock_check.show', $this->stockAdminView->viewData($stockCheck, $rooms, $viewingOrgData));
        }

        return view('tenants.representative_modals.stock_check.show', [
            'stock_check_request' => $stockCheck,
            'rooms' => $rooms,
        ]);
    }

    public function edit(string $id, AdminRecordViewService $adminView): RedirectResponse
    {
        $stockCheck = StockCheckRequest::query()->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($stockCheck, Auth::user())) {
            abort(403);
        }

        $adminView->markViewed($stockCheck, Auth::user());

        return $this->recordWorkspace->restoreToWorkspace($stockCheck, Auth::user());
    }

    public function update(Request $request, string $id): JsonResponse|RedirectResponse
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $stockCheck = StockCheckRequest::query()->findOrFail($id);

        if ($this->stockAdminView->isShippingRequired($stockCheck)) {
            $validated = $request->validate([
                'total_pallets' => 'required|integer|min:1|max:999',
                'delivery_cost' => 'required|numeric|min:0',
                'liftgate_cost' => 'required|numeric|min:0',
                'unload_cost' => 'required|numeric|min:0',
                'miscellaneous_cost' => 'required|numeric|min:0',
            ]);

            $this->stockAdminView->applyDetailedShippingUpdate($stockCheck, $validated);
        } else {
            $validated = $request->validate([
                'shipping_charges' => 'required|numeric|min:0',
            ]);

            $this->stockAdminView->applySimpleShippingUpdate($stockCheck, (float) $validated['shipping_charges']);
        }

        app(AdminRecordViewService::class)->markViewed($stockCheck, Auth::user());

        app(OrderWorkspaceNotificationService::class)->sendStockCheckUpdatedAdminEmail(
            $stockCheck->fresh(),
            Auth::user()
        );

        if ($request->expectsJson()) {
            return response()->json(['status' => true]);
        }

        return redirect()
            ->route('tenant_stock_check_show', $stockCheck->id)
            ->with('success', 'Stock check request updated successfully.');
    }

    public function print(string $id): View
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $stockCheck = StockCheckRequest::query()->with('user')->findOrFail($id);
        $rooms = $stockCheck->normalizedRooms();

        return view('tenants.stock_check.print', [
            'stock_check_request' => $stockCheck,
            'rooms' => $rooms,
            'lines' => $this->stockAdminView->viewData($stockCheck, $rooms)['lines'],
        ]);
    }

    public function sendWarehouseEmail(Request $request, string $id): JsonResponse
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $stockCheck = StockCheckRequest::query()->findOrFail($id);
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $sent = $this->stockAdminView->sendWarehouseEmail($stockCheck, $validated['email']);

        return response()->json(['status' => $sent]);
    }

    public function destroy(string $id): RedirectResponse
    {
        $stockCheck = StockCheckRequest::query()->findOrFail($id);

        if (! $this->recordWorkspace->userMayAccess($stockCheck, Auth::user())) {
            abort(403);
        }

        $stockCheck->delete();

        return redirect()
            ->route('tenant_stock_check_index')
            ->with('success', 'Stock check quote has been deleted successfully.');
    }

    public function deleted_stock_check_list(): View
    {
        return view('tenants.stock_check.deleted_stock_check_list');
    }

  public function restoreDeletedproductsection($id)
    {
        //
    }

    /** @return array<int, string> */
    protected function listColumns(): array
    {
        $columns = [
            'id',
            'job_name',
            'user_id',
            'user_address',
            'user_email',
            'created_at',
            'updated_at',
            'admin_viewed_at',
            'shipping_cost',
        ];

        foreach (['bill_to_name', 'is_approved', 'completion_date'] as $column) {
            if (Schema::hasColumn('stock_check_requests', $column)) {
                $columns[] = $column;
            }
        }

        return $columns;
    }
}
