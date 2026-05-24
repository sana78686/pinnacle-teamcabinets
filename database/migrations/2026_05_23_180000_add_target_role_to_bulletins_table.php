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

        if (! Schema::hasColumn('bulletins', 'target_role')) {
            Schema::table('bulletins', function (Blueprint $table) {
                $table->string('target_role')->nullable()->after('user_option');
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('bulletins') || ! Schema::hasColumn('bulletins', 'target_role')) {
            return;
        }

        Schema::table('bulletins', function (Blueprint $table) {
            $table->dropColumn('target_role');
        });
    }
};
