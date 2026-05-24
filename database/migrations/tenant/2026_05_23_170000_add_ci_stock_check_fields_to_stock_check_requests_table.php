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

        Schema::table('stock_check_requests', function (Blueprint $table) {
            if (! Schema::hasColumn('stock_check_requests', 'bill_to_name')) {
                $table->string('bill_to_name')->nullable()->after('user_id');
            }
            if (! Schema::hasColumn('stock_check_requests', 'is_approved')) {
                $table->boolean('is_approved')->default(false)->after('shipping_cost');
            }
            if (! Schema::hasColumn('stock_check_requests', 'completion_date')) {
                $table->timestamp('completion_date')->nullable()->after('is_approved');
            }
            if (! Schema::hasColumn('stock_check_requests', 'original_rooms')) {
                $table->json('original_rooms')->nullable()->after('rooms');
            }
            if (! Schema::hasColumn('stock_check_requests', 'product_catalog_id')) {
                $table->unsignedBigInteger('product_catalog_id')->nullable()->after('original_rooms');
            }
            if (! Schema::hasColumn('stock_check_requests', 'door_color_id')) {
                $table->unsignedBigInteger('door_color_id')->nullable()->after('product_catalog_id');
            }
            if (! Schema::hasColumn('stock_check_requests', 'product_img_src')) {
                $table->string('product_img_src')->nullable()->after('door_color_id');
            }
            if (! Schema::hasColumn('stock_check_requests', 'product_img_name')) {
                $table->string('product_img_name')->nullable()->after('product_img_src');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('stock_check_requests')) {
            return;
        }

        Schema::table('stock_check_requests', function (Blueprint $table) {
            foreach ([
                'bill_to_name',
                'is_approved',
                'completion_date',
                'original_rooms',
                'product_catalog_id',
                'door_color_id',
                'product_img_src',
                'product_img_name',
            ] as $column) {
                if (Schema::hasColumn('stock_check_requests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
