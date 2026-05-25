<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\HierarchyService;
use App\Services\TenantPermissionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class TenantHierarchyController extends Controller
{
    public function __construct(
        protected HierarchyService $hierarchyService,
    ) {}

    public function index(Request $request): View|JsonResponse
    {
        $this->ensureAdmin($request);

        $tree = $this->hierarchyService->buildHierarchyTree();
        $reps = $this->hierarchyService->getRepresentatives();
        $admin = $this->hierarchyService->getAdmin();
        $allUsers = $this->hierarchyService->allHierarchyUsers();

        $payload = array_merge($tree, [
            'representatives' => $reps->map(fn (User $r) => [
                'id' => $r->id,
                'name' => trim($r->name) ?: $r->username,
            ])->values(),
            'all_users' => $allUsers,
            'admin_id' => $admin?->id,
        ]);

        if ($request->expectsJson()) {
            return response()->json($payload);
        }

        return view('tenants.hierarchy.index', [
            'vueConfig' => [
                'csrf' => csrf_token(),
                'dataUrl' => route('tenant_hierarchy_index'),
                'connectRepUrl' => route('tenant_hierarchy_connect_rep'),
                'connectToRepUrl' => route('tenant_hierarchy_connect_to_rep'),
                'disconnectUrl' => route('tenant_hierarchy_disconnect'),
                'exportShowroomsUrl' => route('tenant_hierarchy_export_showrooms'),
                'exportDealersUrl' => route('tenant_hierarchy_export_dealers'),
                'exportDistributorsUrl' => route('tenant_hierarchy_export_distributors'),
            ],
        ]);
    }

    public function connectRepToAdmin(Request $request): JsonResponse
    {
        $this->ensureAdmin($request);

        $validated = $request->validate(['user_id' => 'required|exists:users,id']);
        $user = User::query()->findOrFail($validated['user_id']);

        if (! $user->isRepresentative() && $user->getCiRole() !== 'representatives') {
            return response()->json(['success' => false, 'message' => 'User must be a representative.'], 422);
        }

        $admin = $this->hierarchyService->getAdmin();
        if (! $admin) {
            return response()->json(['success' => false, 'message' => 'No admin user found.'], 422);
        }

        $this->hierarchyService->connectUserToParent((int) $user->id, (int) $admin->id);

        return response()->json(['success' => true, 'message' => 'Representative connected successfully.']);
    }

    public function connectToRep(Request $request): JsonResponse
    {
        $this->ensureAdmin($request);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'rep_id' => 'required|exists:users,id',
        ]);

        $user = User::query()->findOrFail($validated['user_id']);
        $rep = User::query()->findOrFail($validated['rep_id']);

        if (! in_array($user->getCiRole(), ['showrooms', 'dealers', 'distributors'], true)) {
            return response()->json(['success' => false, 'message' => 'User must be a showroom, dealer, or distributor.'], 422);
        }

        if (! $rep->isRepresentative() && $rep->getCiRole() !== 'representatives') {
            return response()->json(['success' => false, 'message' => 'Parent must be a representative.'], 422);
        }

        $this->hierarchyService->connectUserToParent((int) $user->id, (int) $rep->id);

        return response()->json(['success' => true, 'message' => 'User connected successfully.']);
    }

    public function disconnect(Request $request): JsonResponse
    {
        $this->ensureAdmin($request);

        $validated = $request->validate(['user_id' => 'required|exists:users,id']);
        $this->hierarchyService->disconnectUser((int) $validated['user_id']);

        return response()->json(['success' => true, 'message' => 'User disconnected.']);
    }

    public function exportShowroomConnections(Request $request): StreamedResponse
    {
        $this->ensureAdmin($request);

        $tree = $this->hierarchyService->buildHierarchyTree()['rep_show_data'];
        $filename = 'Representative_Showroom_Connection'.now()->format('Ymd').'.csv';

        return $this->streamHierarchyCsv($tree, ['Representative', 'Showroom', 'Affiliate'], $filename);
    }

    public function exportDealerConnections(Request $request): StreamedResponse
    {
        $this->ensureAdmin($request);

        $tree = $this->hierarchyService->buildHierarchyTree()['rep_dealer_data'];
        $filename = 'Representative_Dealer_Connection'.now()->format('Ymd').'.csv';

        return $this->streamHierarchyCsv($tree, ['Representative', 'Dealer', 'Affiliate'], $filename);
    }

    public function exportDistributorConnections(Request $request): StreamedResponse
    {
        $this->ensureAdmin($request);

        $tree = $this->hierarchyService->buildHierarchyTree()['rep_distri_data'];
        $filename = 'Representative_Distributor_Connection'.now()->format('Ymd').'.csv';

        return $this->streamHierarchyCsv($tree, ['Representative', 'Distributor', 'Affiliate'], $filename);
    }

    /**
     * @param  array<string, array<string, array<int, array{id: int, name: string}>>>  $tree
     */
    protected function streamHierarchyCsv(array $tree, array $headers, string $filename): StreamedResponse
    {
        return response()->streamDownload(function () use ($tree, $headers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $headers);

            if ($tree === []) {
                fclose($handle);

                return;
            }

            foreach ($tree as $repName => $children) {
                fputcsv($handle, [$repName]);
                foreach ($children as $childName => $affiliates) {
                    fputcsv($handle, ['', $childName]);
                    foreach ($affiliates as $affiliate) {
                        fputcsv($handle, ['', '', $affiliate['name'] ?? '']);
                    }
                }
            }

            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    protected function ensureAdmin(Request $request): void
    {
        $user = $request->user();
        if (! $user || ! TenantPermissionService::userIsAdmin($user)) {
            abort(403, 'Admin access required.');
        }
    }
}
