<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('shipping_quotes')) {
            return;
        }

        if (Schema::hasColumn('shipping_quotes', 'total_pallets')) {
            return;
        }

        Schema::table('shipping_quotes', function (Blueprint $table) {
            $table->unsignedSmallInteger('total_pallets')->default(1)->after('pallets_cost');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('shipping_quotes') || ! Schema::hasColumn('shipping_quotes', 'total_pallets')) {
            return;
        }

        Schema::table('shipping_quotes', function (Blueprint $table) {
            $table->dropColumn('total_pallets');
        });
    }
};
