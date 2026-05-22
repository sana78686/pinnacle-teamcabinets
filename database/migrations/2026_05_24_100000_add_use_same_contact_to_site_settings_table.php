<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('site_settings')) {
            return;
        }

        if (! Schema::hasColumn('site_settings', 'use_same_contact')) {
            Schema::table('site_settings', function (Blueprint $table) {
                $table->boolean('use_same_contact')->default(true)->after('newuser_email');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('site_settings') && Schema::hasColumn('site_settings', 'use_same_contact')) {
            Schema::table('site_settings', function (Blueprint $table) {
                $table->dropColumn('use_same_contact');
            });
        }
    }
};
