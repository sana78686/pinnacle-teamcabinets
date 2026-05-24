<?php

namespace App\Services;

use App\Models\CartData;
use App\Models\User;

class OrderCartPersistenceService
{
    public function load(int $userId, int $catalogId): ?array
    {
        $row = CartData::query()
            ->where('user_id', $userId)
            ->where('product_catalog_id', $catalogId)
            ->first();

        if (! $row) {
            return null;
        }

        $roomData = $row->room_data;
        if (is_string($roomData)) {
            $roomData = json_decode($roomData, true) ?? [];
        }

        return [
            'job_name' => $row->job_name,
            'room_data' => is_array($roomData) ? $roomData : [],
            'cart_product_weight' => $row->cart_product_weight,
            'all_cart_total' => (float) $row->all_cart_total,
            'is_assemble' => $row->is_assemble ? 'yes' : 'no',
            'order_comment' => $row->order_comment,
            'door_label' => $row->product_img_name,
            'door_image' => $row->product_img_src,
            'product_description_val' => $row->product_description_val,
        ];
    }

    public function save(User $user, int $catalogId, array $state): CartData
    {
        $roomData = $state['room_data'] ?? [];
        $addedIds = $this->collectProductIds($roomData);
        $assemble = $state['is_assemble'] ?? null;
        $isAssemble = in_array($assemble, ['yes', '1', 1, true], true) ? 1 : 0;

        return CartData::query()->updateOrCreate(
            [
                'user_id' => $user->id,
                'product_catalog_id' => $catalogId,
            ],
            [
                'tenant_id' => $user->tenant_id ?? tenant('id'),
                'product_img_src' => $state['door_image'] ?? $state['product_img_src'] ?? null,
                'product_img_name' => $state['door_label'] ?? $state['product_img_name'] ?? null,
                'product_description_val' => $state['product_description_val'] ?? null,
                'room_data' => $roomData,
                'added_product_ids' => json_encode($addedIds),
                'cart_product_weight' => $state['cart_product_weight'] ?? '0 lbs',
                'all_cart_total' => $state['all_cart_total'] ?? 0,
                'job_name' => $state['job_name'] ?? null,
                'order_comment' => $state['order_comment'] ?? null,
                'affiliate_id' => (int) ($state['affiliate_id'] ?? 0),
                'is_assemble' => $isAssemble,
            ]
        );
    }

    public function clear(int $userId, int $catalogId): void
    {
        CartData::query()
            ->where('user_id', $userId)
            ->where('product_catalog_id', $catalogId)
            ->delete();
    }

    /** Remove every persisted workspace cart row for this user. */
    public function clearAllForUser(int $userId): void
    {
        CartData::query()
            ->where('user_id', $userId)
            ->delete();
    }

    /**
     * @param  array<int, mixed>  $roomData
     * @return array<int, int>
     */
    protected function collectProductIds(array $roomData): array
    {
        $ids = [];
        foreach ($roomData as $room) {
            foreach ($room['products'] ?? [] as $line) {
                if (! empty($line['product_id'])) {
                    $ids[] = (int) $line['product_id'];
                }
            }
        }

        return array_values(array_unique($ids));
    }
}
