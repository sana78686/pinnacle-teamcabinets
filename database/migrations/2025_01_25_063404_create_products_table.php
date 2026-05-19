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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreignId('product_catalog_id')->nullable()->constrained('product_catalogs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('product_section_id')->nullable()->constrained('product_sections')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('door_color_id')->nullable()->constrained('door_colors')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('label')->nullable();
            $table->string('sku')->nullable();
            $table->string('weight')->nullable();
            $table->string('cost')->nullable();
            $table->string('assemble_cost')->default(0.00);
            $table->string('qty')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->date('manufacture_date')->nullable();
            $table->string('label_1')->nullable();
            $table->string('value_1')->nullable();
            $table->string('label_2')->nullable();
            $table->string('value_2')->nullable();
            $table->string('label_3')->nullable();
            $table->string('value_3')->nullable();
            $table->string('label_4')->nullable();
            $table->string('value_4')->nullable();
            $table->string('label_5')->nullable();
            $table->string('value_5')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
