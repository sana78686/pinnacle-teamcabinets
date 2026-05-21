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

        if (! Schema::hasColumn('home_settings', 'faqs')) {
            Schema::table('home_settings', function (Blueprint $table) {
                $table->json('faqs')->nullable()->after('card_three_description');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('home_settings') && Schema::hasColumn('home_settings', 'faqs')) {
            Schema::table('home_settings', function (Blueprint $table) {
                $table->dropColumn('faqs');
            });
        }
    }
};
