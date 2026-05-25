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
        if (Schema::hasTable('door_colors')) {
            return;
        }

        Schema::create('door_colors', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->foreignId('product_catalog_id')->nullable()->constrained('product_catalogs')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('product_label')->nullable();
            $table->string('image')->nullable();
            $table->boolean('status')->default(1);
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('door_colors');
    }
};
