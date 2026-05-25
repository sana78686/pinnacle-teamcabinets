<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Services\CommissionReportService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TenantCommissionReportController extends Controller
{
  /** @var array<string, string> CI user_type => label */
  protected array $userTypeOptions = [
    'representatives' => 'Representatives',
    'distributors' => 'Distributors',
    'dealers' => 'Dealers',
    'showrooms' => 'Showrooms',
  ];

  public function __construct(
    protected CommissionReportService $reportService,
  ) {}

  public function index(Request $request): View|JsonResponse
  {
    if (! $this->isAdminUser($request->user())) {
      return $this->myReport($request);
    }

    $filters = $request->only(['rep_id', 'from', 'to']);
    $data = $this->reportService->formattedData($filters);
    $representatives = $this->representativeOptions();

    if ($request->expectsJson()) {
      return response()->json([
        'data' => $data,
        'representatives' => $representatives,
      ]);
    }

    return view('tenants.commission_report.commission_report_list', [
      'vueConfig' => $this->listVueConfig($request, false),
    ]);
  }

  public function myReport(Request $request): View|JsonResponse
  {
    $user = $request->user();
    $filters = $request->only(['from', 'to']);

    if ($this->isRepresentative($user)) {
      $filters['rep_id'] = $user->id;
    } else {
      $filters['parent_id'] = $user->id;
    }

    $data = $this->reportService->formattedData($filters);

    if ($request->expectsJson()) {
      return response()->json(['data' => $data]);
    }

    return view('tenants.commission_report.commission_report_list', [
      'vueConfig' => $this->listVueConfig($request, true),
    ]);
  }

  public function export(Request $request): StreamedResponse
  {
    $user = $request->user();
  $filters = $request->only(['rep_id', 'from', 'to']);

    if (! $this->isAdminUser($user)) {
      if ($this->isRepresentative($user)) {
        $filters['rep_id'] = $user->id;
      } else {
        $filters['parent_id'] = $user->id;
      }
    }

    $isSingleRep = ! empty($filters['rep_id']);
    $rows = $this->reportService->formattedData($filters);

    $filename = 'Commissions_Report_CSV'.now()->format('Ymd').'.csv';
    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ];

    $callback = function () use ($rows, $isSingleRep) {
      $handle = fopen('php://output', 'w');

      fputcsv($handle, [
        'Order By', 'Customer Name', 'Invoice Number', 'Job Name',
        'Invoice Date', 'Door Style', 'List Price',
        'Customer PF', 'Customer Cost',
        'Affiliation PF', 'Affiliation Cost', 'Affiliation Commission',
        'Representative PF', 'Representative Cost', 'Representative Commission',
      ]);

      $totalCommission = 0.0;

      foreach ($rows as $order) {
        $firstLine = true;
        foreach ($order['door_lines'] as $line) {
          fputcsv($handle, [
            $firstLine ? $order['order_id'] : '',
            $firstLine ? ($order['customer_name'] ?? '') : '',
            $firstLine ? ($order['invoice_number'] ?? '') : '',
            $firstLine ? ($order['job_name'] ?? '') : '',
            $firstLine ? ($order['invoice_date'] ?? '') : '',
            $line['door_style'],
            number_format((float) $line['list_price'], 2),
            $line['user_door_factor'],
            number_format((float) $line['user_door_price'], 2),
            $line['parent_door_factor'] ?: 'N/A',
            $line['parent_cost_display'] ?? ($line['parent_door_price'] ? number_format((float) $line['parent_door_price'], 2) : 'N/A'),
            $line['aff_commission_display'] ?? ($line['aff_commission'] ? number_format((float) $line['aff_commission'], 2) : 'N/A'),
            $line['rep_door_factor'] ?: 'N/A',
            $line['rep_cost_display'] ?? ($line['rep_door_price'] ? number_format((float) $line['rep_door_price'], 2) : 'N/A'),
            $line['rep_commission_display'] ?? ($line['rep_commission'] ? number_format((float) $line['rep_commission'], 2) : 'N/A'),
          ]);
          $totalCommission += (float) $line['aff_commission'] + (float) $line['rep_commission'];
          $firstLine = false;
        }
      }

      if ($isSingleRep) {
        fputcsv($handle, array_merge(
          array_fill(0, 14, ''),
          ['Total Commission: '.number_format($totalCommission, 2)]
        ));
      }

      fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
  }

  public function destroy(string $id): JsonResponse
  {
    $order = Order::query()->findOrFail($id);
    $order->update(['state' => 0]);

    return response()->json(['success' => true]);
  }

  public function deleted_commission_report_list(Request $request): View|JsonResponse
  {
    $filters = array_merge($request->only(['rep_id', 'from', 'to']), ['state' => 0]);
    $data = $this->reportService->formattedData($filters);

    if ($request->expectsJson()) {
      return response()->json(['data' => $data]);
    }

    return view('tenants.commission_report.deleted_commission_report_list', [
      'vueConfig' => $this->listVueConfig($request, false, true),
    ]);
  }

  public function restore(string $id): JsonResponse
  {
    $order = Order::query()->findOrFail($id);
    $order->update(['state' => 1]);

    return response()->json(['success' => true]);
  }

  public function userTypeList(Request $request): View|JsonResponse
  {
    $userType = (string) $request->input('user_type', '');
    $rows = $userType !== ''
      ? $this->reportService->userTypeList($userType)
      : [];

    if ($request->expectsJson()) {
      return response()->json(['data' => $rows]);
    }

    return view('tenants.commission_report.user_type_list', [
      'userTypes' => $this->userTypeOptions,
      'selectedType' => $userType,
      'rows' => $rows,
    ]);
  }

  public function savingReport(Request $request): View|JsonResponse
  {
    if (! $this->isAdminUser($request->user())) {
      abort(403);
    }

    $filters = array_merge(
      $this->reportService->defaultWeeklyRange(),
      $request->only(['rep_id', 'from', 'to'])
    );
    if (($filters['rep_id'] ?? '') === 'all') {
      unset($filters['rep_id']);
    }

    $data = $this->reportService->formattedData($filters);
    $representatives = $this->representativeOptions();

    if ($request->expectsJson()) {
      return response()->json([
        'data' => $data,
        'representatives' => $representatives,
        'range' => $filters,
      ]);
    }

    return view('tenants.commission_report.saving_report', [
      'vueConfig' => $this->savingReportVueConfig($request, $filters),
      'filters' => $filters,
      'representatives' => $representatives,
    ]);
  }

  public function exportSavingReport(Request $request): StreamedResponse
  {
    if (! $this->isAdminUser($request->user())) {
      abort(403);
    }

    $filters = array_merge(
      $this->reportService->defaultWeeklyRange(),
      $request->only(['rep_id', 'from', 'to'])
    );
    if (($filters['rep_id'] ?? '') === 'all') {
      unset($filters['rep_id']);
    }

    $rows = $this->reportService->formattedData($filters);
    $filename = 'Admin_Saving_Report_'.now()->format('Ymd').'.csv';

    $headers = [
      'Content-Type' => 'text/csv',
      'Content-Disposition' => "attachment; filename=\"{$filename}\"",
    ];

    $callback = function () use ($rows) {
      $handle = fopen('php://output', 'w');
      fputcsv($handle, [
        'Invoice #', 'Customer', 'Invoice Date', 'Door Style', 'List Price',
        'Customer Cost', 'Aff Commission', 'Rep Commission',
        'Mfg Comm', 'Rep Comm', 'Aff Comm', 'Sub-Aff Comm',
      ]);

      foreach ($rows as $order) {
        $firstLine = true;
        foreach ($order['door_lines'] as $line) {
          fputcsv($handle, [
            $firstLine ? ($order['invoice_number'] ?? '') : '',
            $firstLine ? ($order['customer_name'] ?? '') : '',
            $firstLine ? ($order['invoice_date'] ?? '') : '',
            $line['door_style'],
            number_format((float) ($line['product_actual_price'] ?? $line['list_price'] ?? 0), 2),
            number_format((float) $line['user_door_price'], 2),
            $line['aff_commission_display'] ?? 'N/A',
            $line['rep_commission_display'] ?? 'N/A',
            $firstLine ? number_format((float) $order['mfg_comm'], 2) : '',
            $firstLine ? number_format((float) $order['rep_comm'], 2) : '',
            $firstLine ? number_format((float) $order['aff_comm'], 2) : '',
            $firstLine ? number_format((float) $order['sub_aff_commission'], 2) : '',
          ]);
          $firstLine = false;
        }
      }

      fclose($handle);
    };

    return response()->stream($callback, 200, $headers);
  }

  /**
   * @return array<string, mixed>
   */
  protected function listVueConfig(Request $request, bool $scoped, bool $deleted = false): array
  {
    return [
      'csrf' => csrf_token(),
      'scoped' => $scoped,
      'deleted' => $deleted,
      'showRepFilter' => ! $scoped && $this->isAdminUser($request->user()),
      'dataUrl' => $deleted
        ? route('tenant_deleted_commission_report_list')
        : ($scoped ? route('tenant_commission_report_my') : route('tenant_commission_report_index')),
      'exportUrl' => route('tenant_commission_report_export'),
      'destroyUrl' => route('tenant_commission_report_destroy', ['id' => '__ID__']),
      'restoreUrl' => route('tenant_commission_report_restore', ['id' => '__ID__']),
      'orderShowUrl' => route('tenant_order_show', ['id' => '__ID__']),
    ];
  }

  protected function isAdminUser(?User $user): bool
  {
    if (! $user) {
      return false;
    }

    return $user->isAdmin() || $user->hasRole('super-admin');
  }

  protected function isRepresentative(User $user): bool
  {
    return $user->isRepresentative() || $user->hasRole('representatives');
  }

  /**
   * @return array<int, array{id: int, name: string}>
   */
  protected function representativeOptions(): array
  {
    return User::query()
      ->where(function ($q) {
        $q->where('user_type', 'representatives')
          ->orWhereHas('roles', fn ($r) => $r->where('name', 'representatives'));
      })
      ->orderBy('name')
      ->get(['id', 'name'])
      ->map(fn (User $u) => ['id' => $u->id, 'name' => $u->name])
      ->values()
      ->all();
  }

  /**
   * @param  array<string, mixed>  $filters
   * @return array<string, mixed>
   */
  protected function savingReportVueConfig(Request $request, array $filters): array
  {
    return [
      'csrf' => csrf_token(),
      'savingReport' => true,
      'showRepFilter' => true,
      'filters' => $filters,
      'dataUrl' => route('tenant_commission_report_saving'),
      'exportUrl' => route('tenant_commission_report_saving_export'),
      'orderShowUrl' => route('tenant_order_show', ['id' => '__ID__']),
    ];
  }
}
