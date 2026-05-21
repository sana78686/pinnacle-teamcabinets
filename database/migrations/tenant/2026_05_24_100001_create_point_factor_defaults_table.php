<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('point_factor_defaults')) {
            return;
        }

        Schema::create('point_factor_defaults', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id', 36);
            $table->string('user_type', 64);
            $table->decimal('point_factor_percentage', 8, 4)->default(0);
            $table->timestamps();

            $table->unique(['tenant_id', 'user_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('point_factor_defaults');
    }
};
