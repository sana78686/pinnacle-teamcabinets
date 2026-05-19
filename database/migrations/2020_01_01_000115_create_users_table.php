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

          if (!Schema::hasTable('users')){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('tenant_id')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
            $table->string('company_name')->nullable();
            $table->string('username')->nullable();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('domain_name')->nullable()->unique();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->foreignId('country_id')->nullable();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('city_id')->nullable();
            $table->foreignId('county_id')->nullable();
            $table->string('city_name')->nullable();
            $table->string('county_name')->nullable();
            $table->string('phone')->nullable();
            $table->string('logo')->nullable();
            $table->string('last_login')->nullable();
            $table->boolean('agreed_terms')->default(0);
            $table->boolean('is_taxable_user')->default(0);
            $table->boolean('is_super_user')->default(0);
            $table->boolean('have_Separate_domain')->default(0);
            $table->enum('status', ['active', 'deactive'])->default('active');
            $table->boolean('is_verified_by_admin')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('updated_by')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->rememberToken();
            $table->boolean('is_privete')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

    }

    if (!Schema::hasTable('password_reset_tokens')){
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

    }


    if (!Schema::hasTable('sessions')){
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
