<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Models\TaxValues;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class OrderWorkspaceService
{
    /**
     * @return array{job_name: string, rooms: array, assemble: string, shipping_status: string, comment: ?string, user: User, totals: array}
     */
    public function parsePayload(Request $request, ?string $defaultShippingStatus = 'pending'): array
    {
        if ($request->isJson()) {
            $request->merge($request->json()->all());
        }

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
                'products' => collect($room['products'])->map(function ($p) {
                    $val1 = ! empty($p['checkbox_val1']);
                    $val2 = ! empty($p['checkbox_val2']);
                    $status = $p['checkbox_status'] ?? 'none';
                    if ($val1 && $val2) {
                        $status = 'both';
                    } elseif ($val1) {
                        $status = 'single';
                    } elseif ($val2) {
                        $status = 'double';
                    }

                    return [
                        'product_id' => (int) $p['product_id'],
                        'quantity' => max(1, (int) ($p['quantity'] ?? 1)),
                        'cost' => isset($p['cost']) ? (float) $p['cost'] : null,
                        'cost1' => isset($p['cost1']) ? (float) $p['cost1'] : null,
                        'weight' => isset($p['weight']) ? (float) $p['weight'] : null,
                        'assemble_cost' => isset($p['assemble_cost']) ? (float) $p['assemble_cost'] : null,
                        'sku' => $p['sku'] ?? null,
                        'label' => $p['label'] ?? null,
                        'checkbox_val1' => $val1 ? 1 : 0,
                        'checkbox_val2' => $val2 ? 1 : 0,
                        'checkbox_status' => $status,
                    ];
                })->values()->all(),
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

        $shippingCosts = null;
        if (($validated['shipping_status'] ?? '') === 'yes' && $request->filled('ship_quote_delivery_type')) {
            $shippingCosts = app(OrderWorkspaceShippingService::class)->calculate([
                'delivery_type' => $request->input('ship_quote_delivery_type'),
                'liftgate' => $request->input('ship_quote_liftgate_req'),
                'unload_type' => $request->input('ship_quote_unload_type'),
            ]);
            $weight = (float) ($totals['sub_total_weight'] ?? 0);
            $surcharge = app(OrderWorkspaceCheckoutService::class)->weightShippingSurcharge($weight);
            if ($surcharge > 0 && is_array($shippingCosts)) {
                $shippingCosts['shipping_cost'] = ($shippingCosts['shipping_cost'] ?? 0) + $surcharge;
            }
        }

        $comment = isset($validated['comment']) ? trim((string) $validated['comment']) : '';
        $quoteName = trim($validated['quote_name'] ?? '');
        if ($quoteName !== '') {
            $prefix = 'Quote: '.$quoteName;
            if ($comment === '') {
                $comment = $prefix;
            } elseif (! str_starts_with($comment, $prefix)
                && ! preg_match('/^(?:Quote|Shipping quote):/iu', $comment)) {
                $comment = trim($prefix."\n".$comment);
            }
        }
        $comment = $comment !== '' ? $comment : null;

        return [
            'job_name' => $validated['job_name'],
            'rooms' => $roomsPayload,
            'assemble' => $assembleValue,
            'shipping_status' => $validated['shipping_status'] ?? $defaultShippingStatus,
            'comment' => $comment,
            'quote_name' => $validated['quote_name'] ?? null,
            'user' => $user,
            'totals' => $totals,
            'fuel_tax' => $fuelTax?->option_value,
            'user_address' => $this->formatUserAddress($user),
            'shipping_costs' => $shippingCosts,
            'ship_quote_type' => $request->input('ship_quote_type'),
        ];
    }

    public function formatUserAddress(User $user): string
    {
        $parts = [
            trim((string) ($user->address ?? '')),
            trim((string) ($user->city_name ?? $user->city?->name ?? '')),
            trim((string) ($user->county_name ?? $user->county?->name ?? '')),
            $user->state_id ? trim((string) ($user->state?->name ?? '')) : '',
            trim((string) ($user->zip_code ?? '')),
            $this->resolveUserCountryName($user),
        ];

        return implode(', ', array_values(array_filter($parts, fn (string $p) => $p !== '')));
    }

    protected function resolveUserCountryName(User $user): string
    {
        $name = trim((string) ($user->country_name ?? ''));
        if ($name !== '') {
            return $name;
        }

        if ($user->relationLoaded('country') && $user->country) {
            return trim((string) ($user->country->name ?? ''));
        }

        if ($user->country_id) {
            $user->loadMissing('country');

            return trim((string) ($user->country?->name ?? ''));
        }

        return '';
    }

    /**
     * Print / quote letterhead from Site Settings + tenant record (CI-style company block).
     *
     * @return array{
     *     company_name: string,
     *     logo_url: string,
     *     address_line: string,
     *     phone: string,
     *     email: string,
     *     website_url: string,
     *     website_label: string
     * }
     */
    public function printLetterhead(): array
    {
        $settings = SiteSetting::forCurrentTenant();
        $tenant = tenant();

        $companyName = trim((string) (tenant('company_name') ?? tenant('name') ?? ''));
        if ($companyName === '') {
            $companyName = (string) config('app.name', 'Company');
        }

        $addressLine = trim((string) ($settings->address ?? ''));
        if ($addressLine === '' && $tenant) {
            $addressLine = implode(', ', array_values(array_filter([
                trim((string) ($tenant->address ?? '')),
                trim((string) ($tenant->city ?? '')),
                trim((string) ($tenant->state ?? '')),
                trim((string) ($tenant->zip_code ?? '')),
                trim((string) ($tenant->country ?? '')),
            ], fn (string $p) => $p !== '')));
        }

        $phone = trim((string) ($settings->phone ?? ($tenant->phone ?? '')));
        $email = trim((string) ($settings->email ?? ($tenant->email ?? '')));

        $websiteUrl = route('cms.page');
        $websiteLabel = (string) (parse_url($websiteUrl, PHP_URL_HOST) ?: $websiteUrl);

        return [
            'company_name' => $companyName,
            'logo_url' => tenant_brand_logo_url(),
            'address_line' => $addressLine,
            'phone' => $phone,
            'email' => $email,
            'website_url' => $websiteUrl,
            'website_label' => $websiteLabel,
        ];
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
                $lineCost = (float) ($line['cost'] ?? 0);
                if ($lineCost <= 0) {
                    $lineCost = (float) preg_replace('/[^\d.]/', '', (string) $productData->cost);
                }
                $lineWeight = (float) ($line['weight'] ?? 0);
                if ($lineWeight <= 0) {
                    $lineWeight = (float) preg_replace('/[^\d.]/', '', (string) $productData->weight);
                }
                $lineAssemble = (float) ($line['assemble_cost'] ?? 0);
                if ($lineAssemble <= 0) {
                    $lineAssemble = (float) preg_replace('/[^\d.]/', '', (string) $productData->assemble_cost);
                }
                $totalAssemble += $lineAssemble * $qty;
                $subTotalCost += $lineCost * $qty;
                $subTotalWeight += $lineWeight * $qty;
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
        $attrs = [
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
            'sub_total_assemble_cost' => (string) ($payload['totals']['sub_total_assemble_cost'] ?? 0),
            'grand_total_cost' => $payload['totals']['grand_total_cost'],
        ];

        if (! empty($payload['shipping_costs'])) {
            $costs = $payload['shipping_costs'];
            $table = (new $modelClass)->getTable();
            $shippingAttrs = [
                'delivery_cost' => $costs['delivery_cost'],
                'liftgate_cost' => $costs['liftgate_cost'],
                'unload_cost' => $costs['unload_cost'],
                'pallets_cost' => $costs['pallets_cost'],
                'shipping_cost' => $costs['shipping_cost'],
            ];
            if (Schema::hasColumn($table, 'total_pallets')) {
                $shippingAttrs['total_pallets'] = $costs['total_pallets'] ?? 1;
            }
            if ($modelClass === \App\Models\ShippingQuote::class && Schema::hasColumn($table, 'is_shipping_updated')) {
                $shippingAttrs['is_shipping_updated'] = false;
            }
            $attrs = array_merge($attrs, $shippingAttrs);
            $cabinetGrandTotal = (float) ($payload['totals']['grand_total_cost'] ?? 0);
            $attrs['grand_total_cost'] = $modelClass === \App\Models\ShippingQuote::class
                ? (string) $cabinetGrandTotal
                : (string) ($cabinetGrandTotal + ($costs['shipping_cost'] ?? 0));
        }

        if (in_array($modelClass, [\App\Models\Quote::class, \App\Models\ShippingQuote::class, \App\Models\StockCheckRequest::class], true)) {
            $attrs = array_merge($attrs, array_filter([
                'quote_name' => $payload['quote_name'] ?? null,
                'product_catalog_id' => $payload['product_catalog_id'] ?? null,
                'door_color_id' => $payload['door_color_id'] ?? null,
                'product_img_src' => $payload['product_img_src'] ?? null,
                'product_img_name' => $payload['product_img_name'] ?? null,
            ], fn ($v) => $v !== null && $v !== ''));
        }

        if ($modelClass === \App\Models\StockCheckRequest::class) {
            if (\Illuminate\Support\Facades\Schema::hasColumn((new \App\Models\StockCheckRequest)->getTable(), 'original_rooms')) {
                $attrs['original_rooms'] = $payload['rooms'];
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn((new \App\Models\StockCheckRequest)->getTable(), 'bill_to_name')) {
                $attrs['bill_to_name'] = $payload['user']->name ?? null;
            }
            if (\Illuminate\Support\Facades\Schema::hasColumn((new \App\Models\StockCheckRequest)->getTable(), 'is_approved')) {
                $attrs['is_approved'] = false;
            }
        }

        /** @var Model $record */
        $record = $modelClass::create($attrs);

        return $record;
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    public function updateRecord(Model $record, array $payload): Model
    {
        $attrs = [
            'job_name' => $payload['job_name'],
            'rooms' => $payload['rooms'],
            'assemble_cabinets_check' => $payload['assemble'],
            'shipping_status' => $payload['shipping_status'],
            'comment' => $payload['comment'],
            'fuel_tax' => $payload['fuel_tax'],
            'sub_total_cost' => $payload['totals']['sub_total_cost'],
            'sub_total_weight' => $payload['totals']['sub_total_weight'],
            'sub_total_assemble_cost' => (string) ($payload['totals']['sub_total_assemble_cost'] ?? 0),
            'grand_total_cost' => $payload['totals']['grand_total_cost'],
        ];

        if ($record instanceof \App\Models\Quote || $record instanceof \App\Models\ShippingQuote || $record instanceof \App\Models\StockCheckRequest) {
            $attrs = array_merge($attrs, array_filter([
                'quote_name' => $payload['quote_name'] ?? null,
                'product_catalog_id' => $payload['product_catalog_id'] ?? null,
                'door_color_id' => $payload['door_color_id'] ?? null,
                'product_img_src' => $payload['product_img_src'] ?? null,
                'product_img_name' => $payload['product_img_name'] ?? null,
            ], fn ($v) => $v !== null && $v !== ''));
        }

        if ($record instanceof \App\Models\StockCheckRequest && empty($record->original_rooms)) {
            $attrs['original_rooms'] = $payload['rooms'];
        }

        $record->update($attrs);

        return $record;
    }

    /**
     * @param  class-string<Model>  $modelClass
     */
    /**
     * @param  class-string<Model>  $modelClass
     * @return list<string>
     */
    public static function workspaceListColumns(string $modelClass): array
    {
        $model = new $modelClass;
        $table = $model->getTable();
        $connection = $model->getConnectionName();

        $columns = [
            'id',
            'job_name',
            'quote_name',
            'comment',
            'user_id',
            'user_email',
            'grand_total_cost',
            'sub_total_weight',
            'assemble_cabinets_check',
            'shipping_status',
            'created_at',
            'updated_at',
            'admin_viewed_at',
        ];

        if ($modelClass === Order::class) {
            $columns = array_merge($columns, [
                'order_amount',
                'status',
                'transaction_pro_id',
            ]);
        }

        $schema = $connection
            ? Schema::connection($connection)
            : Schema::connection(config('database.default'));

        return array_values(array_filter(
            $columns,
            static fn (string $column): bool => $schema->hasColumn($table, $column)
        ));
    }

    public function listQuery(string $modelClass, User $user): \Illuminate\Database\Eloquent\Builder
    {
        $query = $modelClass::query()
            ->select(self::workspaceListColumns($modelClass))
            ->with(['user:id,name,email,company_name,user_type'])
            ->latest('id');

        if (! $user->isAdmin()) {
            $query->where('user_id', $user->id);
        }

        return $query;
    }
}
