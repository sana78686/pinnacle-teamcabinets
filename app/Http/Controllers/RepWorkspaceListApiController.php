<?php

namespace App\Http\Controllers;

use App\Models\ClaimsOrder;
use App\Models\Order;
use App\Models\Quote;
use App\Models\ShippingQuote;
use App\Models\StockCheckRequest;
use App\Services\ClaimWorkspaceService;
use App\Services\OrderWorkspaceService;
use App\Services\QuoteWorkspaceService;
use App\Support\RepWorkspaceVueConfig;
use App\Support\TenantListPaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RepWorkspaceListApiController extends Controller
{
  /** @var array<string, class-string> */
  protected array $models = [
    'orders' => Order::class,
    'quotes' => Quote::class,
    'shipping-quotes' => ShippingQuote::class,
    'stock-check' => StockCheckRequest::class,
  ];

  public function index(Request $request, string $type): JsonResponse
  {
    $this->assertType($type);
    $user = Auth::user();
    $search = TenantListPaginator::search($request);

    if ($type === 'claims') {
      return $this->indexClaims($request, $user, $search);
    }

    $workspace = app(OrderWorkspaceService::class);
    $query = $workspace->listQuery($this->models[$type], $user);

    if ($search !== '') {
      $query->where(function ($q) use ($search) {
        $q->where('job_name', 'like', '%'.$search.'%')
          ->orWhereHas('user', function ($u) use ($search) {
            $u->where('name', 'like', '%'.$search.'%')
              ->orWhere('email', 'like', '%'.$search.'%');
          });
      });
    }

    $paginator = $query->paginate(TenantListPaginator::perPage($request))->withQueryString();

    return response()->json([
      'data' => collect($paginator->items())->map(fn ($row) => $this->serializeWorkspace($row)),
      'meta' => [
        'current_page' => $paginator->currentPage(),
        'last_page' => $paginator->lastPage(),
        'per_page' => $paginator->perPage(),
        'total' => $paginator->total(),
      ],
    ]);
  }

  public function destroy(string $type, int $id, QuoteWorkspaceService $records): JsonResponse
  {
    $this->assertType($type);

    if ($type === 'claims') {
      abort(404);
    }

    $modelClass = $this->models[$type];
    $record = $modelClass::query()->findOrFail($id);

    if (! $records->userMayAccess($record, Auth::user())) {
      abort(403);
    }

    $record->delete();

    return response()->json(['message' => 'Record deleted successfully.']);
  }

  protected function indexClaims(Request $request, $user, string $search): JsonResponse
  {
    $query = app(ClaimWorkspaceService::class)->listQuery($user);

    if ($search !== '') {
      $query->where(function ($q) use ($search) {
        $q->where('claims_order_message', 'like', '%'.$search.'%')
          ->orWhere('claims_order_id', 'like', '%'.$search.'%');
      });
    }

    $paginator = $query->paginate(TenantListPaginator::perPage($request))->withQueryString();

    return response()->json([
      'data' => collect($paginator->items())->map(fn (ClaimsOrder $row) => [
        'id' => $row->id,
        'claims_order_id' => $row->claims_order_id,
        'claims_order_message' => Str::limit((string) $row->claims_order_message, 80),
        'customer_name' => $row->claimant?->name ?? '—',
        'created_at' => $row->created_at?->format('M j, Y') ?? '—',
      ]),
      'meta' => [
        'current_page' => $paginator->currentPage(),
        'last_page' => $paginator->lastPage(),
        'per_page' => $paginator->perPage(),
        'total' => $paginator->total(),
      ],
    ]);
  }

  protected function serializeWorkspace(object $row): array
  {
    return [
      'id' => $row->id,
      'job_name' => $row->job_name ?? '—',
      'customer_name' => $row->user?->name ?? $row->user_email ?? '—',
      'grand_total_cost' => number_format((float) ($row->grand_total_cost ?? 0), 2),
      'sub_total_weight' => ($row->sub_total_weight ?? '0').' lbs',
      'assemble_cabinets_check' => ucfirst((string) ($row->assemble_cabinets_check ?? '—')),
      'shipping_status' => ucfirst((string) ($row->shipping_status ?? '—')),
      'created_at' => $row->created_at?->format('M j, Y') ?? '—',
    ];
  }

  protected function assertType(string $type): void
  {
    if (! array_key_exists($type, RepWorkspaceVueConfig::modules())) {
      abort(404);
    }
  }
}
