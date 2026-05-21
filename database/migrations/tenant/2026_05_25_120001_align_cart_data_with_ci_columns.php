<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('cart_data')) {
            return;
        }

        Schema::table('cart_data', function (Blueprint $table) {
            if (! Schema::hasColumn('cart_data', 'product_img_src')) {
                $table->text('product_img_src')->nullable()->after('product_catalog_id');
            }
            if (! Schema::hasColumn('cart_data', 'product_img_name')) {
                $table->string('product_img_name', 150)->nullable()->after('product_img_src');
            }
            if (! Schema::hasColumn('cart_data', 'product_description_val')) {
                $table->text('product_description_val')->nullable()->after('product_img_name');
            }
            if (! Schema::hasColumn('cart_data', 'added_product_ids')) {
                $table->text('added_product_ids')->nullable()->after('room_data');
            }
            if (! Schema::hasColumn('cart_data', 'affiliate_id')) {
                $table->unsignedBigInteger('affiliate_id')->default(0)->after('order_comment');
            }
            if (Schema::hasColumn('cart_data', 'door_label')) {
                $table->dropColumn(['door_label', 'door_image']);
            }
        });
    }

    public function down(): void
    {
        // Non-destructive alignment migration.
    }
};
