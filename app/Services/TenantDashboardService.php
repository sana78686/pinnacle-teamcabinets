<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Quote;
use App\Models\User;
use Illuminate\Support\Collection;

class TenantDashboardService
{
    /**
     * @return array<string, mixed>
     */
    public function adminStats(): array
    {
        return [
            'unapproved_users' => User::query()->where('is_verified_by_admin', false)->count(),
            'approved_users' => User::query()->where('is_verified_by_admin', true)->count(),
            'total_users' => User::query()->count(),
            'total_orders' => Order::query()->count(),
            'pending_shipping_orders' => Order::query()->where('shipping_status', 'pending')->count(),
            'total_products' => Product::query()->count(),
            'total_quotes' => Quote::query()->count(),
            'dealer_count' => $this->countByRole('Dealer'),
            'representative_count' => $this->countByRole('Representative'),
            'distributor_count' => $this->countByRole('Distributor'),
            'showroom_count' => $this->countByRole('Showroom'),
        ];
    }

    /** @return Collection<int, Order> */
    public function recentOrders(int $limit = 5): Collection
    {
        $workspace = app(OrderWorkspaceService::class);

        return $workspace
            ->listQuery(Order::class, auth()->user())
            ->with(['user.roles'])
            ->take($limit)
            ->get();
    }

    protected function countByRole(string $role): int
    {
        try {
            return User::role($role)->count();
        } catch (\Throwable) {
            return 0;
        }
    }
}
