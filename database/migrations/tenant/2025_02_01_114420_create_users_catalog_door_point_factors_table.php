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
        if (Schema::hasTable('users_catalog_door_point_factors')) {
            return;
        }

        Schema::create('users_catalog_door_point_factors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_catalog_visibility_id')->nullable();
            $table->foreign('user_catalog_visibility_id', 'ucdpf_ucv_fk')
                ->references('id')->on('users_catalog_visibilities')->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('catalog_id')->nullable()->constrained('product_catalogs')->nullOnDelete();
            $table->string('door_style'); // Door style
            $table->decimal('factor', 8, 2)->nullable(); // Factor value (nullable)
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_catalog_door_point_factors');
    }
};
