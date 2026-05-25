<?php

namespace App\Observers;

use App\Models\Order;
use App\Services\OrderWorkspaceNotificationService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class OrderObserver
{
    public function updated(Order $order): void
    {
        if (! Schema::hasColumn($order->getTable(), 'status') || ! $order->wasChanged('status')) {
            return;
        }

        try {
            app(OrderWorkspaceNotificationService::class)->sendOrderStatusChangedEmail(
                $order,
                (string) $order->getOriginal('status')
            );
        } catch (\Throwable $e) {
            Log::warning('Order status email failed: '.$e->getMessage(), ['order_id' => $order->id]);
        }
    }
}
