<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductCatalog;
use App\Models\Quote;
use App\Models\ShippingQuote;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;

class QuoteWorkspaceService
{
    public function __construct(
        protected OrderCartPersistenceService $cartPersistence,
    ) {}

    public function userMayAccess(Model $record, User $user): bool
    {
        return $user->hasRole('Admin') || (int) $record->user_id === (int) $user->id;
    }

    /**
     * @return array{catalog_id: int, door_id: int}|null
     */
    public function resolveCatalogAndDoor(Model $record): ?array
    {
        $catalogId = (int) ($record->product_catalog_id ?? 0);
        $doorId = (int) ($record->door_color_id ?? 0);

        if ($catalogId <= 0 || $doorId <= 0) {
            $productId = $this->firstProductIdFromRooms($record->rooms ?? []);
            if ($productId) {
                $product = Product::query()->find($productId);
                $catalogId = $catalogId ?: (int) ($product?->product_catalog_id ?? 0);
                $doorId = $doorId ?: (int) ($product?->door_color_id ?? 0);
            }
        }

        if ($catalogId <= 0) {
            return null;
        }

        if ($doorId <= 0) {
            $doorId = (int) (\App\Models\DoorColors::query()
                ->where('product_catalog_id', $catalogId)
                ->where('status', 1)
                ->orderBy('id')
                ->value('id') ?? 0);
        }

        if ($doorId <= 0) {
            return null;
        }

        return ['catalog_id' => $catalogId, 'door_id' => $doorId];
    }

    public function restoreToWorkspace(Model $record, User $user): RedirectResponse
    {
        $resolved = $this->resolveCatalogAndDoor($record);
        $listRoute = $record instanceof ShippingQuote ? 'tenant_shipping_quotes_index' : 'tenant_quotes_index';

        if (! $resolved) {
            return redirect()
                ->route($listRoute)
                ->with('error', 'Cannot reopen this record: catalog or door style is missing. Start a new order from Create Order.');
        }

        $rooms = $this->normalizeRoomsForCart($record->rooms ?? []);

        $this->cartPersistence->save($user, $resolved['catalog_id'], [
            'job_name' => $record->job_name,
            'room_data' => $rooms,
            'cart_product_weight' => $this->formatWeight($record->sub_total_weight),
            'all_cart_total' => (float) ($record->grand_total_cost ?? $record->sub_total_cost ?? 0),
            'is_assemble' => $record->assemble_cabinets_check ?? 'no',
            'order_comment' => $this->plainComment($record),
            'door_label' => $record->product_img_name,
            'door_image' => $record->product_img_src,
        ]);

        if ($record instanceof ShippingQuote) {
            session(['editing_shipping_quote_id' => $record->id]);
            session()->forget('editing_quote_id');
        } else {
            session(['editing_quote_id' => $record->id]);
            session()->forget('editing_shipping_quote_id');
        }

        return redirect()->route('tenant_order_workspace_build', [
            'catalog' => $resolved['catalog_id'],
            'door' => $resolved['door_id'],
        ])->with('success', 'Loaded into the order workspace. You can update and save again.');
    }

    public function displayRecordName(Model $record): string
    {
        if (! empty($record->quote_name)) {
            return $record->quote_name;
        }

        $comment = (string) ($record->comment ?? '');
        $prefix = $record instanceof ShippingQuote ? 'Shipping quote:' : 'Quote:';

        if (preg_match('/^'.preg_quote($prefix, '/').'\s*(.+?)(?:\n|$)/i', $comment, $m)) {
            return trim($m[1]);
        }

        if (preg_match('/^Quote:\s*(.+?)(?:\n|$)/', $comment, $m)) {
            return trim($m[1]);
        }

        return $record->job_name ?: '—';
    }

    public function catalogLabel(Model $record): string
    {
        if ($record->product_catalog_id) {
            return ProductCatalog::query()->whereKey($record->product_catalog_id)->value('name') ?? 'Catalog #'.$record->product_catalog_id;
        }

        return '—';
    }

    public function billName(Model $record): string
    {
        return $record->user?->name ?? $record->user_email ?? '—';
    }

    public function shipName(Model $record): string
    {
        return $record->user?->name ?? $record->user_email ?? '—';
    }

    /**
     * @param  array<int, mixed>  $rooms
     */
    protected function firstProductIdFromRooms(array $rooms): ?int
    {
        foreach ($rooms as $room) {
            foreach ($room['products'] ?? [] as $line) {
                if (! empty($line['product_id'])) {
                    return (int) $line['product_id'];
                }
            }
        }

        return null;
    }

    /**
     * @param  array<int, mixed>  $rooms
     * @return array<int, array<string, mixed>>
     */
    protected function normalizeRoomsForCart(array $rooms): array
    {
        $out = [];
        $idx = 1;
        foreach ($rooms as $room) {
            if (empty($room['room_name']) && empty($room['products'])) {
                continue;
            }
            $out[] = [
                'room_index' => (int) ($room['room_index'] ?? $idx),
                'room_name' => (string) ($room['room_name'] ?? ''),
                'products' => $room['products'] ?? [],
            ];
            $idx++;
        }

        return $out;
    }

    protected function plainComment(Model $record): string
    {
        $comment = (string) ($record->comment ?? '');

        return trim(preg_replace('/^(Quote|Shipping quote):\s*.+?(?:\n\n|\n|$)/is', '', $comment) ?? $comment);
    }

    protected function formatWeight(mixed $weight): string
    {
        $w = trim((string) ($weight ?? '0'));

        return str_contains(strtolower($w), 'lbs') ? $w : $w.' lbs';
    }
}
