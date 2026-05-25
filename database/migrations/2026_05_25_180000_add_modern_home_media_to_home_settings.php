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
            if (! Schema::hasColumn('home_settings', 'modern_hero_video')) {
                $table->string('modern_hero_video', 512)->nullable()->after('banner_image');
            }
            if (! Schema::hasColumn('home_settings', 'modern_hero_poster')) {
                $table->string('modern_hero_poster', 512)->nullable()->after('modern_hero_video');
            }
            if (! Schema::hasColumn('home_settings', 'modern_factory_video')) {
                $table->string('modern_factory_video', 512)->nullable()->after('modern_hero_poster');
            }
            if (! Schema::hasColumn('home_settings', 'modern_factory_poster')) {
                $table->string('modern_factory_poster', 512)->nullable()->after('modern_factory_video');
            }
            if (! Schema::hasColumn('home_settings', 'modern_slideshow_interval_ms')) {
                $table->unsignedSmallInteger('modern_slideshow_interval_ms')->nullable()->after('modern_factory_poster');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('home_settings')) {
            return;
        }

        Schema::table('home_settings', function (Blueprint $table) {
            foreach ([
                'modern_hero_video',
                'modern_hero_poster',
                'modern_factory_video',
                'modern_factory_poster',
                'modern_slideshow_interval_ms',
            ] as $col) {
                if (Schema::hasColumn('home_settings', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
