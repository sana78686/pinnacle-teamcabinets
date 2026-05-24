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
                // MySQL: FK on tenant_id uses the unique index — drop FK before dropping unique.
                $hasTenantFk = collect(Schema::getForeignKeys('tenant_smtp_settings'))
                    ->contains(fn (array $fk) => in_array('tenant_id', $fk['columns'] ?? [], true));

                if ($hasTenantFk) {
                    Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                        $table->dropForeign(['tenant_id']);
                    });
                }

                Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                    $table->dropUnique(['tenant_id']);
                });

                $indexesAfter = collect(Schema::getIndexes('tenant_smtp_settings'))->pluck('name');
                if (! $indexesAfter->contains('tenant_smtp_settings_tenant_id_index')) {
                    Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                        $table->index('tenant_id');
                    });
                }

                if ($hasTenantFk && Schema::hasTable('tenants')) {
                    Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                        $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
                    });
                }
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

        if (Schema::hasTable('tenant_smtp_settings')) {
            if (Schema::hasColumn('tenant_smtp_settings', 'deleted_at')) {
                Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                    $table->dropSoftDeletes();
                });
            }

            $indexes = collect(Schema::getIndexes('tenant_smtp_settings'))->pluck('name');
            if (! $indexes->contains('tenant_smtp_settings_tenant_id_unique')) {
                $hasTenantFk = collect(Schema::getForeignKeys('tenant_smtp_settings'))
                    ->contains(fn (array $fk) => in_array('tenant_id', $fk['columns'] ?? [], true));

                if ($hasTenantFk) {
                    Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                        $table->dropForeign(['tenant_id']);
                    });
                }

                if ($indexes->contains('tenant_smtp_settings_tenant_id_index')) {
                    Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                        $table->dropIndex(['tenant_id']);
                    });
                }

                Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                    $table->unique('tenant_id');
                });

                if ($hasTenantFk && Schema::hasTable('tenants')) {
                    Schema::table('tenant_smtp_settings', function (Blueprint $table) {
                        $table->foreign('tenant_id')->references('id')->on('tenants')->cascadeOnDelete();
                    });
                }
            }
        }
    }
};
