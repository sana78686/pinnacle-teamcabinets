<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('stock_check_requests')) {
            return;
        }

        if (Schema::hasColumn('stock_check_requests', 'total_pallets')) {
            return;
        }

        Schema::table('stock_check_requests', function (Blueprint $table) {
            $table->unsignedSmallInteger('total_pallets')->default(1)->after('pallets_cost');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('stock_check_requests') || ! Schema::hasColumn('stock_check_requests', 'total_pallets')) {
            return;
        }

        Schema::table('stock_check_requests', function (Blueprint $table) {
            $table->dropColumn('total_pallets');
        });
    }
};
