<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tables = [
        'orders',
        'quotes',
        'shipping_quotes',
        'stock_check_requests',
        'users',
    ];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || Schema::hasColumn($table, 'admin_viewed_at')) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->timestamp('admin_viewed_at')->nullable()->after('updated_at');
            });

            DB::table($table)
                ->whereNull('admin_viewed_at')
                ->update(['admin_viewed_at' => DB::raw('COALESCE(updated_at, created_at, NOW())')]);
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'admin_viewed_at')) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropColumn('admin_viewed_at');
            });
        }
    }
};
