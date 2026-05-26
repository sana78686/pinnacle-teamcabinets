<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderEnhancedDetail;
use App\Models\Quote;
use App\Models\ShippingQuote;
use App\Models\StockCheckRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class OrderAdminListService
{
    /** @var array<string, string> */
    public const USER_TYPE_FILTERS = [
        '' => 'All User',
        'representatives' => 'Representatives',
        'distributors' => 'Distributors',
        'dealers' => 'Dealers',
        'showrooms' => 'Showrooms',
    ];

    public const ORDER_STATUSES = ['PROCESSING', 'PAID', 'PENDING', 'CANCELLED', 'COMPLETED'];

    public function adminListQuery(): Builder
    {
        return Order::query()
            ->with(['user:id,name,email,company_name,user_type'])
            ->latest('id');
    }

    public function applyUserTypeFilter(Builder $query, ?string $userType): Builder
    {
        if ($userType === null || $userType === '') {
            return $query;
        }

        return $query->whereHas('user', fn (Builder $q) => $q->where('user_type', $userType));
    }

    /**
     * @param  array<int, int>  $orderIds
     * @return array<int, array{label: string, id: int}>
     */
    public function sourceBadgesForOrderIds(array $orderIds): array
    {
        $orderIds = array_values(array_filter(array_map('intval', $orderIds)));
        if ($orderIds === []) {
            return [];
        }

        $badges = [];

        foreach ($orderIds as $orderId) {
            $badge = $this->resolveSourceBadgeFromWorkspaceTables($orderId);
            if ($badge) {
                $badges[$orderId] = $badge;
            }
        }

        if (Schema::hasTable('order_enhanced_details')) {
            $details = OrderEnhancedDetail::query()
                ->whereIn('order_id', $orderIds)
                ->where('state', 1)
                ->get();

            foreach ($details as $detail) {
                $orderId = (int) $detail->order_id;
                if ($orderId <= 0) {
                    continue;
                }

                $mqId = (int) ($detail->mq_id ?? 0);
                $scId = (int) ($detail->sc_id ?? 0);

                if ($mqId > 0) {
                    $badges[$orderId] = $this->resolveMqBadge($mqId) ?? ['label' => 'Q #', 'id' => $mqId];
                } elseif ($scId > 0) {
                    $badges[$orderId] = ['label' => 'SC #', 'id' => $scId];
                }
            }
        }

        return $badges;
    }

    /**
     * @return array{label: string, id: int}|null
     */
    protected function resolveSourceBadgeFromWorkspaceTables(int $orderId): ?array
    {
        $badge = null;

        if ($this->workspaceHasOrderLink(StockCheckRequest::class, 'stock_check_requests')) {
            $scId = (int) StockCheckRequest::query()
                ->where($this->orderLinkColumn('stock_check_requests'), $orderId)
                ->value('id');
            if ($scId > 0) {
                $badge = ['label' => 'SC #', 'id' => $scId];
            }
        }

        if ($this->workspaceHasOrderLink(ShippingQuote::class, 'shipping_quotes')) {
            $sqId = (int) ShippingQuote::query()
                ->where($this->orderLinkColumn('shipping_quotes'), $orderId)
                ->value('id');
            if ($sqId > 0) {
                $badge = ['label' => 'SQ #', 'id' => $sqId];
            }
        }

        if ($this->workspaceHasOrderLink(Quote::class, 'quotes')) {
            $qId = (int) Quote::query()
                ->where($this->orderLinkColumn('quotes'), $orderId)
                ->value('id');
            if ($qId > 0) {
                $badge = ['label' => 'Q #', 'id' => $qId];
            }
        }

        return $badge;
    }

    protected function workspaceHasOrderLink(string $modelClass, string $table): bool
    {
        return class_exists($modelClass)
            && Schema::hasTable($table)
            && Schema::hasColumn($table, $this->orderLinkColumn($table));
    }

    protected function orderLinkColumn(string $table): string
    {
        if (Schema::hasColumn($table, 'orders_id')) {
            return 'orders_id';
        }

        return 'order_id';
    }

    /**
     * @return array{label: string, id: int}|null
     */
    protected function resolveMqBadge(int $mqId): ?array
    {
        if (Schema::hasTable('quotes') && Quote::query()->whereKey($mqId)->exists()) {
            return ['label' => 'Q #', 'id' => $mqId];
        }

        if (Schema::hasTable('shipping_quotes') && ShippingQuote::query()->whereKey($mqId)->exists()) {
            return ['label' => 'SQ #', 'id' => $mqId];
        }

        return null;
    }

    public function formatCiDate(?\DateTimeInterface $date): string
    {
        return $date ? $date->format('M, j Y') : '—';
    }

    public function formatWeight(Order $order): string
    {
        $weight = $order->sub_total_weight ?? '0';
        $weight = is_array($weight) ? '0' : (string) $weight;
        $weight = str_ireplace('lbl', 'lbs', $weight);
        $weight = trim(str_replace(['"', '[', ']'], '', $weight));

        if ($weight === '') {
            return '0 lbs';
        }

        if (! str_contains(strtolower($weight), 'lb')) {
            $weight .= ' lbs';
        }

        return $weight;
    }

    public function formatAmount(Order $order): string
    {
        $amount = (float) ($order->order_amount ?? $order->grand_total_cost ?? 0);

        return '$'.number_format($amount, 2);
    }

    public function customerName(Order $order): string
    {
        return Str::title(trim((string) ($order->user?->name ?? $order->user_email ?? '—')));
    }

    public function customerEmail(Order $order): string
    {
        $email = trim((string) ($order->user?->email ?? $order->user_email ?? ''));

        if ($email === '') {
            return '—';
        }

        if (str_contains($email, ',')) {
            $email = trim(explode(',', $email)[0]);
        }

        return $email;
    }

    public function customerType(Order $order): string
    {
        $type = (string) ($order->user?->user_type ?? '');

        if (in_array($type, ['affiliate', 'sub-affiliate'], true)) {
            return 'Customer';
        }

        return $type !== '' ? Str::title(str_replace(['-', '_'], ' ', $type)) : '—';
    }

    public function companyName(Order $order): string
    {
        $name = trim((string) ($order->user?->company_name ?? ''));

        return $name !== '' ? $name : 'N/A';
    }

    public function jobName(Order $order): string
    {
        $job = $order->job_name;
        if (is_array($job)) {
            return implode(', ', $job);
        }

        return (string) ($job ?? '—');
    }

    public function statusSelectClass(string $status): string
    {
        return match (strtoupper($status)) {
            'PAID' => 'tc-order-status-select--paid',
            'PENDING' => 'tc-order-status-select--pending',
            'CANCELLED' => 'tc-order-status-select--cancelled',
            'COMPLETED' => 'tc-order-status-select--completed',
            'PROCESSING' => 'tc-order-status-select--processing',
            default => 'tc-order-status-select--default',
        };
    }
}
