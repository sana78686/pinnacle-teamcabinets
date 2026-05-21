<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tenant_quickbooks_settings')) {
            Schema::create('tenant_quickbooks_settings', function (Blueprint $table) {
                $table->id();
                $table->string('tenant_id', 36);
                $table->string('realm_id')->nullable();
                $table->text('access_token')->nullable();
                $table->text('refresh_token')->nullable();
                $table->timestamp('token_expires_at')->nullable();
                $table->string('environment', 20)->default('sandbox');
                $table->timestamp('connected_at')->nullable();
                $table->timestamps();

                $table->unique('tenant_id');
                $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_quickbooks_settings');
    }
};
