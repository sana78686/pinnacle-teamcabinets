<?php

namespace App\Services;

use App\Models\ClaimsOrder;
use App\Models\Order;
use App\Models\Quote;
use App\Models\ShippingQuote;
use App\Models\StockCheckRequest;
use App\Models\User;
use App\Services\SupportChatService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class TenantNavBadgeService
{
    public function __construct(
        protected SupportChatService $supportChat,
    ) {}

    public function countsForUser(User $user): array
    {
        $supportCount = $this->supportChat->unreadCountForUser($user);

        if (! $this->userSeesNavBadges($user)) {
            return array_merge($this->emptyCounts(), [
                'support_chat' => $supportCount,
                'support_chat_list' => $supportCount,
            ]);
        }

        $listKeys = config('tenant_nav_badges.list_keys', []);
        $dbCounts = $this->unviewedRecordCounts();
        $notifCounts = array_fill_keys($listKeys, 0);

        foreach ($user->unreadNotifications()->get() as $notification) {
            $key = $notification->data['list_key'] ?? null;
            if ($key && isset($notifCounts[$key])) {
                $notifCounts[$key]++;
            }
        }

        $counts = [];
        foreach ($listKeys as $key) {
            $counts[$key] = max($dbCounts[$key] ?? 0, $notifCounts[$key] ?? 0);
        }

        $parents = config('tenant_nav_badges.parents', []);
        $parentCounts = [];
        foreach ($parents as $parent => $keys) {
            $parentCounts[$parent] = 0;
            foreach ($keys as $key) {
                $parentCounts[$parent] += $counts[$key] ?? 0;
            }
        }

        $counts['support_chat_list'] = max($counts['support_chat_list'] ?? 0, $supportCount);
        $parentCounts['support_chat'] = $counts['support_chat_list'];

        return array_merge($parentCounts, $counts);
    }

    public function markListSeen(User $user, string $listKey): void
    {
        if (! $this->userSeesNavBadges($user)) {
            return;
        }

        foreach ($user->unreadNotifications()->get() as $notification) {
            if (($notification->data['list_key'] ?? null) === $listKey) {
                $notification->markAsRead();
            }
        }
    }

    public function markRecordSeen(User $user, Model $record, ?string $listKey = null): void
    {
        if (! $this->userSeesNavBadges($user)) {
            return;
        }

        $listKey ??= $this->listKeyForModel($record);
        $recordId = (string) $record->getKey();

        foreach ($user->unreadNotifications()->get() as $notification) {
            $data = $notification->data;
            $key = $data['list_key'] ?? null;
            $url = (string) ($data['url'] ?? '');

            if ($listKey && $key !== $listKey) {
                continue;
            }

            if ($url !== '' && $this->notificationUrlMatchesRecord($url, $recordId, $record)) {
                $notification->markAsRead();
            }
        }
    }

    protected function notificationUrlMatchesRecord(string $url, string $recordId, Model $record): bool
    {
        if ($recordId === '') {
            return false;
        }

        if (str_contains($url, '/'.$recordId) || str_ends_with($url, '/'.$recordId)) {
            return true;
        }

        $suffix = '(/|$|\?|#)';
        $patterns = match ($record::class) {
            StockCheckRequest::class => [
                '~stock_check[/\-]'.preg_quote($recordId, '~').$suffix.'~i',
            ],
            Quote::class => [
                '~quotes?[/\-]'.preg_quote($recordId, '~').$suffix.'~i',
            ],
            ShippingQuote::class => [
                '~shipping[_\-]?quotes?[/\-]'.preg_quote($recordId, '~').$suffix.'~i',
            ],
            Order::class => [
                '~orders?[/\-]'.preg_quote($recordId, '~').$suffix.'~i',
            ],
            default => [],
        };

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url)) {
                return true;
            }
        }

        return false;
    }

    protected function unviewedRecordCounts(): array
    {
        $counts = [
            'users_list' => 0,
            'orders_list' => 0,
            'quotes_list' => 0,
            'shipping_quotes_list' => 0,
            'stock_check_list' => 0,
            'claims_list' => 0,
            'support_chat_list' => 0,
        ];

        if (Schema::hasColumn('users', 'admin_viewed_at')) {
            $counts['users_list'] = User::query()
                ->whereNull('admin_viewed_at')
                ->where('is_super_user', 0)
                ->where(function ($query) {
                    try {
                        $query->whereDoesntHave('roles', fn ($role) => $role->where('name', 'admin'));
                    } catch (\Throwable) {
                        // roles may be unavailable during setup
                    }
                })
                ->count();
        }

        if (Schema::hasColumn('orders', 'admin_viewed_at')) {
            $counts['orders_list'] = Order::query()->whereNull('admin_viewed_at')->count();
        }

        if (Schema::hasColumn('quotes', 'admin_viewed_at')) {
            $counts['quotes_list'] = Quote::query()->whereNull('admin_viewed_at')->count();
        }

        if (Schema::hasColumn('shipping_quotes', 'admin_viewed_at')) {
            $counts['shipping_quotes_list'] = ShippingQuote::query()->whereNull('admin_viewed_at')->count();
        }

        if (Schema::hasTable('stock_check_requests') && Schema::hasColumn('stock_check_requests', 'admin_viewed_at')) {
            $counts['stock_check_list'] = StockCheckRequest::query()->whereNull('admin_viewed_at')->count();
        }

        if (Schema::hasColumn('claims_order', 'admin_viewed_at')) {
            $counts['claims_list'] = ClaimsOrder::query()->whereNull('admin_viewed_at')->count();
        }

        return $counts;
    }

    protected function listKeyForModel(Model $record): ?string
    {
        return match ($record::class) {
            User::class => 'users_list',
            Order::class => 'orders_list',
            Quote::class => 'quotes_list',
            ShippingQuote::class => 'shipping_quotes_list',
            StockCheckRequest::class => 'stock_check_list',
            ClaimsOrder::class => 'claims_list',
            default => null,
        };
    }

    protected function userSeesNavBadges(User $user): bool
    {
        if ($user->is_super_user) {
            return true;
        }

        try {
            return $user->isAdmin();
        } catch (\Throwable) {
            return false;
        }
    }

    protected function emptyCounts(): array
    {
        $out = [];
        foreach (config('tenant_nav_badges.parents', []) as $parent => $_) {
            $out[$parent] = 0;
        }
        foreach (config('tenant_nav_badges.list_keys', []) as $key) {
            $out[$key] = 0;
        }

        return $out;
    }
}
