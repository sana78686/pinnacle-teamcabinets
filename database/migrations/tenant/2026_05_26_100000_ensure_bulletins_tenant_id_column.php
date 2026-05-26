<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('bulletins')) {
            return;
        }

        if (! Schema::hasColumn('bulletins', 'tenant_id')) {
            Schema::table('bulletins', function (Blueprint $table) {
                $table->string('tenant_id')->nullable()->after('id');
                $table->foreign('tenant_id')->references('id')->on('tenants')->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('bulletins') || ! Schema::hasColumn('bulletins', 'tenant_id')) {
            return;
        }

        Schema::table('bulletins', function (Blueprint $table) {
            $table->dropForeign(['tenant_id']);
            $table->dropColumn('tenant_id');
        });
    }
};
