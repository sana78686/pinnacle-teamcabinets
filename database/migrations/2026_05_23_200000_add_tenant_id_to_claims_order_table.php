<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('claims_order') || Schema::hasColumn('claims_order', 'tenant_id')) {
            return;
        }

        Schema::table('claims_order', function (Blueprint $table) {
            $table->string('tenant_id')->nullable()->after('id');
            $table->index('tenant_id');
        });

        if (Schema::hasTable('tenants') && function_exists('tenant') && tenant()) {
            DB::table('claims_order')
                ->whereNull('tenant_id')
                ->update(['tenant_id' => tenant()->getTenantKey()]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('claims_order') || ! Schema::hasColumn('claims_order', 'tenant_id')) {
            return;
        }

        Schema::table('claims_order', function (Blueprint $table) {
            $table->dropIndex(['claims_order_tenant_id_index']);
            $table->dropColumn('tenant_id');
        });
    }
};
