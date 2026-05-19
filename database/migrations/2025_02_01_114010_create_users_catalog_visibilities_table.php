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
        if (! Schema::hasTable('users_catalog_visibilities')) {
            Schema::create('users_catalog_visibilities', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
                $table->foreignId('catalog_id')->constrained('product_catalogs')->cascadeOnDelete();
                $table->softDeletes();
                $table->timestamps();

                $table->unique(['user_id', 'catalog_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_catalog_visibilities');
    }
};
