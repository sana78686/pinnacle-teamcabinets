<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('site_settings')) {
            Schema::table('site_settings', function (Blueprint $table) {
                if (! Schema::hasColumn('site_settings', 'favicon')) {
                    $table->string('favicon')->nullable()->after('logo');
                }
                if (! Schema::hasColumn('site_settings', 'site_meta_title')) {
                    $table->string('site_meta_title')->nullable()->after('address');
                }
                if (! Schema::hasColumn('site_settings', 'site_meta_description')) {
                    $table->text('site_meta_description')->nullable()->after('site_meta_title');
                }
                if (! Schema::hasColumn('site_settings', 'site_meta_keywords')) {
                    $table->string('site_meta_keywords')->nullable()->after('site_meta_description');
                }
                if (! Schema::hasColumn('site_settings', 'og_image')) {
                    $table->string('og_image')->nullable()->after('site_meta_keywords');
                }
            });
        }

        if (Schema::hasTable('pages')) {
            Schema::table('pages', function (Blueprint $table) {
                if (! Schema::hasColumn('pages', 'meta_keywords')) {
                    $table->string('meta_keywords')->nullable()->after('meta_description');
                }
                if (! Schema::hasColumn('pages', 'og_image')) {
                    $table->string('og_image')->nullable()->after('meta_keywords');
                }
            });
        }

        if (Schema::hasTable('home_settings')) {
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
    }

    public function down(): void
    {
        if (Schema::hasTable('site_settings')) {
            Schema::table('site_settings', function (Blueprint $table) {
                foreach (['favicon', 'site_meta_title', 'site_meta_description', 'site_meta_keywords', 'og_image'] as $col) {
                    if (Schema::hasColumn('site_settings', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('pages')) {
            Schema::table('pages', function (Blueprint $table) {
                foreach (['meta_keywords', 'og_image'] as $col) {
                    if (Schema::hasColumn('pages', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('home_settings')) {
            Schema::table('home_settings', function (Blueprint $table) {
                foreach (['meta_title', 'meta_description', 'meta_keywords'] as $col) {
                    if (Schema::hasColumn('home_settings', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
