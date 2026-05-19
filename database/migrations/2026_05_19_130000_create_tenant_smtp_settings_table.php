<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tenant_smtp_settings')) {
            Schema::create('tenant_smtp_settings', function (Blueprint $table) {
                $table->id();
                $table->string('tenant_id', 36)->unique();
                $table->string('smtp_host');
                $table->unsignedSmallInteger('smtp_port')->default(587);
                $table->string('smtp_encryption', 10)->default('tls');
                $table->string('smtp_username');
                $table->text('smtp_password');
                $table->string('from_email');
                $table->string('from_name')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->timestamp('verified_at')->nullable();
                $table->timestamps();

                $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('tenant_smtp_settings');
    }
};
