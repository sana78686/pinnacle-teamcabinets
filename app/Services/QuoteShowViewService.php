<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Quote;
use App\Models\ShippingQuote;
use Illuminate\Database\Eloquent\Model;

class QuoteShowViewService
{
    public function __construct(
        protected OrderWorkspaceCheckoutService $checkout,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function viewDataForQuote(Quote $record): array
    {
        return $this->baseViewData($record, [
            'listRoute' => 'tenant_quotes_index',
            'editRoute' => 'tenant_quotes_edit',
            'pageTitle' => 'View Quote',
            'isShippingQuote' => false,
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function viewDataForShippingQuote(ShippingQuote $record, ShippingQuoteAdminViewService $shippingAdmin): array
    {
        return array_merge($shippingAdmin->viewData($record), [
            'pageTitle' => 'View Shipping Quote',
            'isShippingQuote' => true,
            'editRoute' => null,
        ]);
    }

    /**
     * @param  Quote|ShippingQuote  $record
     * @param  array<string, mixed>  $meta
     * @return array<string, mixed>
     */
    protected function baseViewData(Model $record, array $meta): array
    {
        $record->loadMissing(['user.country', 'user.state']);
        $user = $record->user;
        $addresses = $user ? $this->checkout->billShipAddresses($user) : $this->emptyAddresses();
        $lines = $this->buildLineItems($record->rooms ?? []);
        $assembleYes = in_array($record->assemble_cabinets_check ?? '', ['yes', '1', 1], true);

        return array_merge($addresses, $meta, [
            'record' => $record,
            'quoteName' => $this->displayName($record),
            'companyName' => $user?->company_name ?: 'N/A',
            'lines' => $lines,
            'assembleYes' => $assembleYes,
            'sub_total_weight' => (float) ($record->sub_total_weight ?? 0),
            'sub_total_price' => (float) ($record->sub_total_cost ?? 0),
            'sub_total_assemble' => (float) ($record->sub_total_assemble_cost ?? 0),
            'grand_total' => (float) ($record->grand_total_cost ?? 0),
        ]);
    }

    /**
     * @param  Quote|ShippingQuote  $record
     */
    protected function displayName(Model $record): string
    {
        if (! empty($record->quote_name)) {
            return $record->quote_name;
        }

        $comment = (string) ($record->comment ?? '');
        if (preg_match('/^Shipping quote:\s*(.+?)(?:\n|$)/i', $comment, $m)) {
            return trim($m[1]);
        }
        if (preg_match('/^Quote:\s*(.+?)(?:\n|$)/', $comment, $m)) {
            return trim($m[1]);
        }

        return $record->job_name ?? '—';
    }

    /**
     * @param  array<int, array<string, mixed>>  $rooms
     * @return array<int, array<string, mixed>>
     */
    protected function buildLineItems(array $rooms): array
    {
        $rooms = $this->checkout->normalizeRoomsFromStorage($rooms);
        $productIds = [];
        foreach ($rooms as $room) {
            foreach ($room['products'] ?? [] as $line) {
                if (! empty($line['product_id'])) {
                    $productIds[] = (int) $line['product_id'];
                }
            }
        }

        $products = Product::query()
            ->whereIn('id', array_unique($productIds))
            ->get()
            ->keyBy('id');

        $lines = [];
        foreach ($rooms as $room) {
            $roomName = $room['room_name'] ?? 'Room';
            foreach ($room['products'] ?? [] as $line) {
                $qty = max(1, (int) ($line['quantity'] ?? 1));
                $unit = (float) ($line['cost'] ?? 0);
                $weight = (float) ($line['weight'] ?? 0);
                $assemble = (float) ($line['assemble_cost'] ?? 0);
                $lineTotal = (float) ($line['line_total'] ?? 0);
                $product = $products->get((int) ($line['product_id'] ?? 0));

                if ($unit <= 0 && $product) {
                    $unit = (float) preg_replace('/[^\d.]/', '', (string) $product->cost);
                }
                if ($weight <= 0 && $product) {
                    $weight = (float) preg_replace('/[^\d.]/', '', (string) $product->weight);
                }
                if ($assemble <= 0 && $product) {
                    $assemble = (float) preg_replace('/[^\d.]/', '', (string) $product->assemble_cost);
                }
                if ($lineTotal <= 0) {
                    $lineTotal = round($unit * $qty, 2);
                }

                $sku = $line['sku'] ?? $product?->sku ?? '—';
                $description = $line['description'] ?? $line['label'] ?? $product?->description ?? $sku;
                $lines[] = [
                    'room_name' => $roomName,
                    'cabinet_name' => $sku,
                    'description' => $description,
                    'weight' => $weight,
                    'unit_price' => $unit,
                    'line_total' => $lineTotal,
                    'quantity' => $qty,
                    'assemble_cost' => round($assemble * $qty, 2),
                    'check_yellow' => ! empty($line['checkbox_val1']),
                    'check_green' => ! empty($line['checkbox_val2']),
                ];
            }
        }

        return $lines;
    }

    /**
     * @return array<string, string>
     */
    protected function emptyAddresses(): array
    {
        return [
            'bill_to_name' => '—',
            'bill_to_address' => '',
            'bill_to_email' => '',
            'bill_to_phone' => '',
            'bill_to_city' => '',
            'bill_to_county' => '',
            'bill_to_state' => '',
            'bill_to_zipcode' => '',
            'bill_to_country' => '',
            'ship_to_name' => '—',
            'ship_to_address' => '',
            'ship_to_email' => '',
            'ship_to_phone' => '',
            'ship_to_city' => '',
            'ship_to_county' => '',
            'ship_to_state' => '',
            'ship_to_zipcode' => '',
            'ship_to_country' => '',
        ];
    }
}
