<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-user admin nav order (shared DB: php artisan migrate).
 * Tenant-folder copy: database/migrations/tenant/2026_05_24_140000_create_user_nav_menu_orders_table.php
 */
return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('user_nav_menu_orders')) {
            return;
        }

        Schema::create('user_nav_menu_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->json('menu_order');
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_nav_menu_orders');
    }
};
