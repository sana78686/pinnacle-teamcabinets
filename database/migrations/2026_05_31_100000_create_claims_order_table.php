<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('claims_order')) {
            return;
        }

        Schema::create('claims_order', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable();
            $table->json('claims_product_val');
            $table->text('claims_order_message');
            $table->text('claims_order_image')->nullable();
            $table->unsignedBigInteger('claims_order_id');
            $table->unsignedBigInteger('claims_order_user_id');
            $table->boolean('is_viewed')->default(false);
            $table->timestamp('admin_viewed_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('claims_order_id');
            $table->index('claims_order_user_id');
            $table->index('tenant_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claims_order');
    }
};
