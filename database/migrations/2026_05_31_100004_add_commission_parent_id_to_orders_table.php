<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * CI my_orders.parent_id for commission chain (distinct from any other parent semantics).
     * Mirror: database/migrations/tenant/2026_05_31_100004_add_commission_parent_id_to_orders_table.php
     */
    public function up(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'commission_parent_id')) {
                $table->unsignedBigInteger('commission_parent_id')->nullable()->after('rep_id');
            }
        });

        if (Schema::hasColumn('orders', 'parent_id') && Schema::hasColumn('orders', 'commission_parent_id')) {
            DB::table('orders')
                ->whereNull('commission_parent_id')
                ->whereNotNull('parent_id')
                ->update(['commission_parent_id' => DB::raw('parent_id')]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'commission_parent_id')) {
                $table->dropColumn('commission_parent_id');
            }
        });
    }
};
