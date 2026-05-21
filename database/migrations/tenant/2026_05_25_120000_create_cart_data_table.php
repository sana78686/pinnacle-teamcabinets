<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * cart_data — legacy CI Team Cabinets (mirror of database/migrations copy).
 * Shared DB: php artisan migrate and/or php artisan tenants:migrate
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cart_data')) {
            return;
        }

        Schema::create('cart_data', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('product_catalog_id')->default(0);
            $table->text('product_img_src')->nullable();
            $table->string('product_img_name', 150)->nullable();
            $table->text('product_description_val')->nullable();
            $table->longText('room_data')->nullable();
            $table->text('added_product_ids')->nullable();
            $table->string('cart_product_weight', 150)->default('0 lbs');
            $table->decimal('all_cart_total', 12, 2)->default(0);
            $table->text('job_name')->nullable();
            $table->text('order_comment')->nullable();
            $table->unsignedBigInteger('affiliate_id')->default(0);
            $table->unsignedTinyInteger('is_assemble')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->unique(['user_id', 'product_catalog_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_data');
    }
};
