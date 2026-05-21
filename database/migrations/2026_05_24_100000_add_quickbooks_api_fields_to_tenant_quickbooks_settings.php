<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tenant_quickbooks_settings')) {
            return;
        }

        Schema::table('tenant_quickbooks_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('tenant_quickbooks_settings', 'client_id')) {
                $table->string('client_id')->nullable()->after('tenant_id');
            }
            if (! Schema::hasColumn('tenant_quickbooks_settings', 'client_secret')) {
                $table->text('client_secret')->nullable()->after('client_id');
            }
            if (! Schema::hasColumn('tenant_quickbooks_settings', 'redirect_uri')) {
                $table->string('redirect_uri', 512)->nullable()->after('client_secret');
            }
            if (! Schema::hasColumn('tenant_quickbooks_settings', 'qb_environment')) {
                $table->string('qb_environment', 20)->nullable()->after('redirect_uri');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('tenant_quickbooks_settings')) {
            return;
        }

        Schema::table('tenant_quickbooks_settings', function (Blueprint $table) {
            foreach (['client_id', 'client_secret', 'redirect_uri', 'qb_environment'] as $col) {
                if (Schema::hasColumn('tenant_quickbooks_settings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
