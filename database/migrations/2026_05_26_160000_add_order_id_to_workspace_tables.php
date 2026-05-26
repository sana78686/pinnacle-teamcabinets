<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Mirror: database/migrations/tenant/2026_05_26_160000_add_order_id_to_workspace_tables.php
 */
return new class extends Migration
{
    /** @var array<string> */
    protected array $tables = ['stock_check_requests', 'quotes', 'shipping_quotes'];

    public function up(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) use ($table) {
                if (! Schema::hasColumn($table, 'order_id') && ! Schema::hasColumn($table, 'orders_id')) {
                    $blueprint->unsignedBigInteger('order_id')->default(0)->index()->after('user_id');
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->tables as $table) {
            if (! Schema::hasTable($table) || ! Schema::hasColumn($table, 'order_id')) {
                continue;
            }

            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropColumn('order_id');
            });
        }
    }
};
