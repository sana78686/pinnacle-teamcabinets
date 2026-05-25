<?php

namespace App\Services;

use App\Models\ManageCommission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

/**
 * CI manage_commissions — per-user gross_sales for commission reports.
 */
class ManageCommissionService
{
    public function parseGrossSales(mixed $value): float
    {
        if ($value === null || $value === '') {
            return 0.0;
        }

        $clean = preg_replace('/[^\d.-]/', '', (string) $value);

        return round((float) $clean, 4);
    }

    public function grossSalesForUser(User $user): float
    {
        $user->loadMissing('manageCommission');

        if ($user->manageCommission !== null) {
            return (float) $user->manageCommission->gross_sales;
        }

        if (filled($user->gross_sale)) {
            return $this->parseGrossSales($user->gross_sale);
        }

        return 0.0;
    }

    public function syncForUser(User $user, mixed $grossSales): ManageCommission
    {
        $amount = $this->parseGrossSales($grossSales);

        $row = ManageCommission::query()->updateOrCreate(
            ['user_id' => $user->id],
            ['gross_sales' => $amount]
        );

        $this->syncLegacyUserColumn($user, $amount);

        return $row;
    }

    public function ensureForUser(User $user, mixed $grossSales = 0): ManageCommission
    {
        $existing = ManageCommission::query()->where('user_id', $user->id)->first();
        if ($existing) {
            return $existing;
        }

        return $this->syncForUser($user, $grossSales);
    }

    public function syncFromRequest(User $user, Request $request): ManageCommission
    {
        if (! $request->has('gross_sale')) {
            return $this->ensureForUser($user, 0);
        }

        return $this->syncForUser($user, $request->input('gross_sale'));
    }

    /** Backfill rows for users created before manage_commissions migration. */
    public function backfillMissingRows(): int
    {
        if (! Schema::hasTable('manage_commissions')) {
            return 0;
        }

        $created = 0;
        User::query()
            ->select('id', 'gross_sale')
            ->orderBy('id')
            ->chunkById(200, function ($users) use (&$created) {
                foreach ($users as $user) {
                    if (ManageCommission::query()->where('user_id', $user->id)->exists()) {
                        continue;
                    }
                    $this->syncForUser($user, $user->gross_sale ?? 0);
                    $created++;
                }
            });

        return $created;
    }

    protected function syncLegacyUserColumn(User $user, float $amount): void
    {
        if (! Schema::hasColumn('users', 'gross_sale')) {
            return;
        }

        $user->forceFill(['gross_sale' => (string) $amount])->saveQuietly();
    }
}
