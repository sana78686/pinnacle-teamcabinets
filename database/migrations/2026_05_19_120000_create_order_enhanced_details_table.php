<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('order_enhanced_details')) {
            return;
        }

        Schema::create('order_enhanced_details', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable()->index();
            $table->unsignedBigInteger('sc_id')->default(0)->index();
            $table->unsignedBigInteger('mq_id')->default(0)->index();
            $table->unsignedBigInteger('order_id')->default(0)->index();
            $table->string('customer_paid', 10)->default('No');
            $table->string('team_paid', 10)->default('No');
            $table->string('vendor', 255)->nullable();
            $table->string('vendor_sc_q', 255)->nullable();
            $table->string('vendor_sale_order', 255)->nullable();
            $table->string('vendor_amount', 50)->nullable();
            $table->string('sub_total', 50)->nullable();
            $table->string('tax', 50)->nullable();
            $table->string('fuel_charges', 50)->nullable();
            $table->string('shipping', 50)->nullable();
            $table->string('miscellaneous', 50)->nullable();
            $table->string('delivery', 50)->nullable();
            $table->unsignedInteger('stock_check_status')->default(1);
            $table->unsignedTinyInteger('state')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_enhanced_details');
    }
};
