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
        if (! Schema::hasTable('users_catalog_door_point_factors')) {
            Schema::create('users_catalog_door_point_factors', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_catalog_visibility_id')->nullable()
                    ->constrained('users_catalog_visibilities')->nullOnDelete();
                $table->foreignId('catalog_id')->constrained('product_catalogs')->cascadeOnDelete();
                $table->string('door_style');
                $table->decimal('factor', 8, 2)->nullable();
                $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_catalog_door_point_factors');
    }
};
