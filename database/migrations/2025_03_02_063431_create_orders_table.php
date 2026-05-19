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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->string('job_name');
            $table->json('rooms'); // Stores rooms with products under them
            $table->text('comment')->nullable();
            $table->enum('assemble_cabinets_check', ['yes', 'no']);
            $table->enum('shipping_status', ['yes', 'pending'])->default('pending');
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('user_address')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_phone')->nullable();
            $table->string('fuel_tax')->nullable();
            $table->string('sub_total_assemble_cost')->default(0.00);
            $table->string('sub_total_cost')->nullable();
            $table->string('sub_total_weight')->nullable();
            $table->string('grand_total_cost')->nullable();
            $table->string('shipping_cost')->nullable();
            $table->string('pallets_cost')->nullable();
            $table->string('delivery_cost')->nullable();
            $table->string('liftgate_cost')->nullable();
            $table->string('unload_cost')->nullable();
            $table->string('miscellaneous_cost')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
