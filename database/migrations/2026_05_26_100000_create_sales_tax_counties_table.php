<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sales_tax_counties')) {
            return;
        }

        Schema::create('sales_tax_counties', function (Blueprint $table) {
            $table->id();
            $table->string('counties', 200);
            $table->unsignedInteger('state_id');
            $table->float('tax');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_tax_counties');
    }
};
