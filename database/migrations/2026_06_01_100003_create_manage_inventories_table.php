<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('manage_inventories')) {
            return;
        }

        Schema::create('manage_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('sku')->nullable();
            $table->integer('quantity')->default(0);
            $table->string('status', 20)->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manage_inventories');
    }
};
