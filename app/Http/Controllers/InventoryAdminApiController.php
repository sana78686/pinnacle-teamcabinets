<?php

namespace App\Http\Controllers;

use App\Models\ManageInventory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class InventoryAdminApiController extends Controller
{
    public function index(): JsonResponse
    {
        if (! Schema::hasTable('manage_inventories')) {
            return response()->json(['data' => []]);
        }

        $rows = ManageInventory::query()
            ->orderByDesc('id')
            ->get()
            ->map(fn (ManageInventory $row) => $this->serialize($row));

        return response()->json(['data' => $rows]);
    }

    public function store(Request $request): JsonResponse
    {
        abort_unless(Schema::hasTable('manage_inventories'), 503);

        $validated = $request->validate([
            'product_name' => 'required|string|max:255',
            'sku' => 'nullable|string|max:128',
            'quantity' => 'required|integer|min:0',
            'status' => 'nullable|in:active,inactive',
        ]);

        $item = ManageInventory::query()->create([
            'product_name' => $validated['product_name'],
            'sku' => $validated['sku'] ?? null,
            'quantity' => $validated['quantity'],
            'status' => $validated['status'] ?? 'active',
        ]);

        return response()->json([
            'success' => true,
            'data' => $this->serialize($item),
        ], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        abort_unless(Schema::hasTable('manage_inventories'), 503);

        $validated = $request->validate([
            'product_name' => 'sometimes|required|string|max:255',
            'sku' => 'nullable|string|max:128',
            'quantity' => 'sometimes|required|integer|min:0',
            'status' => 'nullable|in:active,inactive',
        ]);

        $item = ManageInventory::query()->findOrFail($id);
        $item->update($validated);

        return response()->json([
            'success' => true,
            'data' => $this->serialize($item->fresh()),
        ]);
    }

    public function destroy(int $id): JsonResponse
    {
        abort_unless(Schema::hasTable('manage_inventories'), 503);

        ManageInventory::query()->findOrFail($id)->delete();

        return response()->json(['success' => true]);
    }

    protected function serialize(ManageInventory $row): array
    {
        return [
            'id' => $row->id,
            'product_name' => $row->product_name,
            'sku' => $row->sku ?? '—',
            'quantity' => $row->quantity,
            'status' => $row->status,
            'created_at' => $row->created_at?->format('M j, Y') ?? '—',
        ];
    }
}
