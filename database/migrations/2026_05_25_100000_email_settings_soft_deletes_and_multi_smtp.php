<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('manage_emails_content') && ! Schema::hasColumn('manage_emails_content', 'deleted_at')) {
            Schema::table('manage_emails_content', function (Blueprint $table) {
                $table->softDeletes();
            });
        }

        if (Schema::hasTable('tenant_smtp_settings')) {
            Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                if (! Schema::hasColumn('tenant_smtp_settings', 'deleted_at')) {
                    $table->softDeletes();
                }
            });

            $indexes = collect(Schema::getIndexes('tenant_smtp_settings'))->pluck('name');
            if ($indexes->contains('tenant_smtp_settings_tenant_id_unique')) {
                Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                    $table->dropUnique(['tenant_id']);
                    $table->index('tenant_id');
                });
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('manage_emails_content') && Schema::hasColumn('manage_emails_content', 'deleted_at')) {
            Schema::table('manage_emails_content', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasTable('tenant_smtp_settings') && Schema::hasColumn('tenant_smtp_settings', 'deleted_at')) {
            Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};
