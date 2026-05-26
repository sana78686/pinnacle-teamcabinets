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

        if (Schema::hasColumn('shipping_quotes', 'is_shipping_updated')) {
            return;
        }

        Schema::table('shipping_quotes', function (Blueprint $table) {
            $table->boolean('is_shipping_updated')->default(false)->after('shipping_cost');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('shipping_quotes') || ! Schema::hasColumn('shipping_quotes', 'is_shipping_updated')) {
            return;
        }

        Schema::table('shipping_quotes', function (Blueprint $table) {
            $table->dropColumn('is_shipping_updated');
        });
    }
};
