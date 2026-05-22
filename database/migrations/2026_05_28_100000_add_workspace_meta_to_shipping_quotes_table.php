<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipping_quotes', function (Blueprint $table) {
            if (! Schema::hasColumn('shipping_quotes', 'quote_name')) {
                $table->string('quote_name')->nullable()->after('job_name');
            }
            if (! Schema::hasColumn('shipping_quotes', 'product_catalog_id')) {
                $table->unsignedBigInteger('product_catalog_id')->nullable()->after('user_id');
            }
            if (! Schema::hasColumn('shipping_quotes', 'door_color_id')) {
                $table->unsignedBigInteger('door_color_id')->nullable()->after('product_catalog_id');
            }
            if (! Schema::hasColumn('shipping_quotes', 'product_img_src')) {
                $table->string('product_img_src')->nullable();
            }
            if (! Schema::hasColumn('shipping_quotes', 'product_img_name')) {
                $table->string('product_img_name')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('shipping_quotes', function (Blueprint $table) {
            $cols = ['quote_name', 'product_catalog_id', 'door_color_id', 'product_img_src', 'product_img_name'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('shipping_quotes', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
