<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        try {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropUnique(['slug']);
            });
        } catch (\Throwable) {
            // Global slug unique may already be dropped.
        }

        try {
            Schema::table('pages', function (Blueprint $table) {
                $table->unique(['tenant_id', 'slug'], 'pages_tenant_slug_unique');
            });
        } catch (\Throwable) {
            // Per-tenant slug unique may already exist.
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        try {
            Schema::table('pages', function (Blueprint $table) {
                $table->dropUnique('pages_tenant_slug_unique');
            });
        } catch (\Throwable) {
        }

        try {
            Schema::table('pages', function (Blueprint $table) {
                $table->unique('slug');
            });
        } catch (\Throwable) {
        }
    }
};
