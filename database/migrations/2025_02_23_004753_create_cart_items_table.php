<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('room_name');
            $table->string('product_label');
            $table->string('product_sku');
            $table->text('product_description');
            $table->text('product_weight');
            $table->text('product_price');
            $table->integer('quantity')->default(1);
            $table->text('total_price');
            $table->boolean('single_check')->default(false);
            $table->boolean('double_check')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
