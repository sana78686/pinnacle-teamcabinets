<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * CI warehouse pick list print marks order picked.
     * Mirror: database/migrations/tenant/2026_05_31_100005_add_picked_fields_to_orders_table.php
     */
    public function up(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'is_picked')) {
                $table->boolean('is_picked')->default(false)->after('state');
            }
            if (! Schema::hasColumn('orders', 'picked_at')) {
                $table->timestamp('picked_at')->nullable()->after('is_picked');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            foreach (['is_picked', 'picked_at'] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
