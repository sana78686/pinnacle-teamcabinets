<?php

namespace App\Services;

use App\Models\Order;
use App\Models\ShippingQuote;
use App\Models\StockCheckRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

class TenantHeaderAlertService
{
    public const WINDOW_HOURS = 24;

    /**
     * @return array<int, array{key: string, message: string, url: string, type: string}>
     */
    public function alertsFor(User $user): array
    {
        if ($this->userIsPanelAdmin($user)) {
            return $this->adminAlerts();
        }

        return $this->userAlerts($user);
    }

    /**
     * @return array<int, array{key: string, message: string, url: string, type: string}>
     */
    protected function adminAlerts(): array
    {
        $since = $this->windowStart();
        $alerts = [];

        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'admin_viewed_at')) {
            $count = Order::query()
                ->where('created_at', '>=', $since)
                ->whereNull('admin_viewed_at')
                ->count();

            if ($count > 0) {
                $alerts[] = $this->alert(
                    'new_orders',
                    $this->countedMessage('Alert: New order received', $count),
                    route('tenant_order_list'),
                    'order',
                );
            }
        }

        if (Schema::hasTable('shipping_quotes') && Schema::hasColumn('shipping_quotes', 'admin_viewed_at')) {
            $count = ShippingQuote::query()
                ->where('created_at', '>=', $since)
                ->whereNull('admin_viewed_at')
                ->count();

            if ($count > 0) {
                $alerts[] = $this->alert(
                    'new_shipping_quotes',
                    $this->countedMessage('Alert: New shipping quote request', $count),
                    route('tenant_shipping_quotes_index'),
                    'shipping',
                );
            }
        }

        if (Schema::hasTable('stock_check_requests') && Schema::hasColumn('stock_check_requests', 'admin_viewed_at')) {
            $count = StockCheckRequest::query()
                ->where('created_at', '>=', $since)
                ->whereNull('admin_viewed_at')
                ->count();

            if ($count > 0) {
                $alerts[] = $this->alert(
                    'new_stock_checks',
                    $this->countedMessage('Alert: New stock check request', $count),
                    route('tenant_stock_check_index'),
                    'stock',
                );
            }
        }

        return $alerts;
    }

    /**
     * @return array<int, array{key: string, message: string, url: string, type: string}>
     */
    protected function userAlerts(User $user): array
    {
        $since = $this->windowStart();
        $alerts = [];

        if (Schema::hasTable('shipping_quotes') && Schema::hasColumn('shipping_quotes', 'user_viewed_at')) {
            $count = ShippingQuote::query()
                ->where('user_id', $user->id)
                ->where('shipping_status', 'yes')
                ->whereNull('user_viewed_at')
                ->where('updated_at', '>=', $since)
                ->whereColumn('updated_at', '>', 'created_at')
                ->whereRaw('CAST(COALESCE(shipping_cost, 0) AS DECIMAL(12,2)) > 0')
                ->count();

            if ($count > 0) {
                $alerts[] = $this->alert(
                    'shipping_quote_response',
                    $this->countedMessage('Alert: Your shipping quote has been updated', $count),
                    route('tenant_shipping_quotes_index'),
                    'shipping',
                );
            }
        }

        if (Schema::hasTable('stock_check_requests') && Schema::hasColumn('stock_check_requests', 'user_viewed_at')) {
            $count = StockCheckRequest::query()
                ->where('user_id', $user->id)
                ->whereNull('user_viewed_at')
                ->where(function ($query) use ($since) {
                    $query->where(function ($approved) use ($since) {
                        $approved->where('is_approved', true)
                            ->orWhereNotNull('completion_date');
                    })->where(function ($when) use ($since) {
                        $when->where('completion_date', '>=', $since)
                            ->orWhere('updated_at', '>=', $since);
                    });
                })
                ->count();

            if ($count > 0) {
                $alerts[] = $this->alert(
                    'stock_check_response',
                    $this->countedMessage('Alert: Your stock check has been updated', $count),
                    route('tenant_stock_check_index'),
                    'stock',
                );
            }
        }

        return $alerts;
    }

    protected function windowStart(): Carbon
    {
        return now()->subHours(self::WINDOW_HOURS);
    }

    /**
     * @return array{key: string, message: string, url: string, type: string}
     */
    protected function alert(string $key, string $message, string $url, string $type): array
    {
        return [
            'key' => $key,
            'message' => $message,
            'url' => $url,
            'type' => $type,
        ];
    }

    protected function countedMessage(string $base, int $count): string
    {
        return $count > 1 ? $base.' ('.$count.')' : $base;
    }

    protected function userIsPanelAdmin(User $user): bool
    {
        if ((int) ($user->is_super_user ?? 0) === 1) {
            return true;
        }

        try {
            return $user->isAdmin();
        } catch (\Throwable) {
            return false;
        }
    }
}
