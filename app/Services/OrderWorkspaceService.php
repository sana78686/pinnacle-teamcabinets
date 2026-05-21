<?php

namespace App\Services;

use App\Models\Product;
use App\Models\TaxValues;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class OrderWorkspaceService
{
    /**
     * @return array{job_name: string, rooms: array, assemble: string, shipping_status: string, comment: ?string, user: User, totals: array}
     */
    public function parsePayload(Request $request, ?string $defaultShippingStatus = 'pending'): array
    {
        $validated = $request->validate([
            'job_name' => 'required|string|max:255',
            'rooms' => 'required|array|min:1',
            'assemble_cabinets_check' => 'required',
            'shipping_status' => 'nullable|in:yes,pending',
            'comment' => 'nullable|string|max:500',
            'quote_name' => 'nullable|string|max:255',
            'ship_quote_delivery_type' => 'nullable|string|max:50',
            'ship_quote_liftgate_req' => 'nullable|string|max:10',
            'ship_quote_unload_type' => 'nullable|string|max:50',
            'ship_quote_type' => 'nullable|string|max:80',
        ]);

        $assembleYes = in_array($validated['assemble_cabinets_check'], ['1', 1, 'yes', true], true);
        $assembleValue = $assembleYes ? 'yes' : 'no';

        $roomsPayload = [];
        foreach ($validated['rooms'] as $room) {
            if (empty($room['room_name']) || empty($room['products'])) {
                continue;
            }
            $roomsPayload[] = [
                'room_name' => $room['room_name'],
                'products' => collect($room['products'])->map(fn ($p) => [
                    'product_id' => (int) $p['product_id'],
                    'quantity' => max(1, (int) ($p['quantity'] ?? 1)),
                    'checkbox_status' => $p['checkbox_status'] ?? 'none',
                ])->values()->all(),
            ];
        }

        if (count($roomsPayload) === 0) {
            throw ValidationException::withMessages([
                'rooms' => ['Add at least one room with products.'],
            ]);
        }

        $user = $request->user();
        $totals = $this->calculateTotals($roomsPayload, $assembleYes);
        $fuelTax = TaxValues::query()->where('option_key', 'fuel_charges_value')->first();

        return [
            'job_name' => $validated['job_name'],
            'rooms' => $roomsPayload,
            'assemble' => $assembleValue,
            'shipping_status' => $validated['shipping_status'] ?? $defaultShippingStatus,
            'comment' => $validated['comment'] ?? null,
            'user' => $user,
            'totals' => $totals,
            'fuel_tax' => $fuelTax?->option_value,
            'user_address' => $this->formatUserAddress($user),
        ];
    }

    public function formatUserAddress(User $user): string
    {
        $countryName = $user->country_id ? $user->country?->name : '';
        $stateName = $user->state_id ? $user->state?->name : '';

        return implode(', ', array_filter([
            $user->address,
            $user->city_name,
            $user->county_name,
            $stateName,
            $countryName,
        ]));
    }

    /**
     * @param  array<int, array{room_name: string, products: array}>  $roomsPayload
     * @return array{sub_total_cost: float, sub_total_weight: float, sub_total_assemble_cost: float, grand_total_cost: float}
     */
    public function calculateTotals(array $roomsPayload, bool $assembleYes): array
    {
        $totalAssemble = 0.0;
        $subTotalCost = 0.0;
        $subTotalWeight = 0.0;

        foreach ($roomsPayload as $room) {
            foreach ($room['products'] as $line) {
                $productData = Product::find($line['product_id']);
                if (! $productData) {
                    continue;
                }
                $qty = $line['quantity'];
                $totalAssemble += ((float) $productData->assemble_cost) * $qty;
                $subTotalCost += ((float) preg_replace('/[^\d.]/', '', (string) $productData->cost)) * $qty;
                $subTotalWeight += ((float) preg_replace('/[^\d.]/', '', (string) $productData->weight)) * $qty;
            }
        }

        $assembleCost = $assembleYes ? $totalAssemble : 0.0;

        return [
            'sub_total_cost' => $subTotalCost,
            'sub_total_weight' => $subTotalWeight,
            'sub_total_assemble_cost' => $assembleCost,
            'grand_total_cost' => $subTotalCost + $assembleCost,
        ];
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    public function createRecord(string $modelClass, array $payload): Model
    {
        /** @var Model $record */
        $record = $modelClass::create([
            'job_name' => $payload['job_name'],
            'rooms' => $payload['rooms'],
            'assemble_cabinets_check' => $payload['assemble'],
            'shipping_status' => $payload['shipping_status'],
            'comment' => $payload['comment'],
            'user_id' => $payload['user']->id,
            'user_address' => $payload['user_address'],
            'user_email' => $payload['user']->email,
            'user_phone' => $payload['user']->phone,
            'fuel_tax' => $payload['fuel_tax'],
            'sub_total_cost' => $payload['totals']['sub_total_cost'],
            'sub_total_weight' => $payload['totals']['sub_total_weight'],
            'sub_total_assemble_cost' => $payload['totals']['sub_total_assemble_cost'],
            'grand_total_cost' => $payload['totals']['grand_total_cost'],
        ]);

        return $record;
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    public function listQuery(string $modelClass, User $user): \Illuminate\Database\Eloquent\Builder
    {
        $query = $modelClass::query()->with('user')->latest('id');

        if (! $user->hasRole('Admin')) {
            $query->where('user_id', $user->id);
        }

        return $query;
    }
}
