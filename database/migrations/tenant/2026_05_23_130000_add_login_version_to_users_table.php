<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        if (! Schema::hasColumn('users', 'login_version')) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedInteger('login_version')->default(0);
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'login_version')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('login_version');
            });
        }
    }
};
