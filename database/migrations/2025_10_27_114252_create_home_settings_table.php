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
        Schema::create('home_settings', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id');
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('banner_image')->nullable();
            $table->string('benner_title')->nullable();
            $table->text('benner_description')->nullable();
            $table->string('aboutus_image')->nullable();
            $table->string('aboutus_title')->nullable();
            $table->text('aboutus_description')->nullable();
            $table->string('card_one_title')->nullable();
            $table->text('card_one_description')->nullable();
            $table->string('card_two_title')->nullable();
            $table->text('card_two_description')->nullable();
            $table->string('card_three_title')->nullable();
            $table->text('card_three_description')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_settings');
    }
};
