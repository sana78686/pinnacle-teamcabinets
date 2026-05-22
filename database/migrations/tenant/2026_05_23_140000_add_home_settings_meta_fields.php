<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('home_settings')) {
            return;
        }

        Schema::table('home_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('home_settings', 'meta_title')) {
                $table->string('meta_title')->nullable();
            }
            if (! Schema::hasColumn('home_settings', 'meta_description')) {
                $table->text('meta_description')->nullable();
            }
            if (! Schema::hasColumn('home_settings', 'meta_keywords')) {
                $table->string('meta_keywords')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('home_settings')) {
            return;
        }

        Schema::table('home_settings', function (Blueprint $table) {
            foreach (['meta_title', 'meta_description', 'meta_keywords'] as $col) {
                if (Schema::hasColumn('home_settings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
