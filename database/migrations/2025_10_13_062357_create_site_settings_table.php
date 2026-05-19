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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id', 36);

            // ===== General Settings =====
            $table->string('logo')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('contactus_phone')->nullable();
            $table->string('contactus_email')->nullable();
            $table->string('newuser_phone')->nullable();
            $table->string('newuser_email')->nullable();
            $table->string('address')->nullable();

            // ===== Social Media Links =====
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();


            // ===== Relationships =====
            $table->foreign('tenant_id')
                ->references('id')->on('tenants')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
