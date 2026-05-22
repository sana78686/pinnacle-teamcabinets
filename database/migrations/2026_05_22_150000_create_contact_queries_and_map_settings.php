<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('contact_queries')) {
            Schema::create('contact_queries', function (Blueprint $table) {
                $table->id();
                $table->string('tenant_id')->nullable()->index();
                $table->string('name')->nullable();
                $table->string('email');
                $table->string('subject')->nullable();
                $table->text('message');
                $table->string('attachment_path')->nullable();
                $table->string('ip_address', 45)->nullable();
                $table->timestamp('admin_viewed_at')->nullable();
                $table->timestamps();
            });
        }

        if (Schema::hasTable('site_settings')) {
            Schema::table('site_settings', function (Blueprint $table) {
                if (! Schema::hasColumn('site_settings', 'contact_sidebar_title')) {
                    $table->string('contact_sidebar_title')->nullable();
                }
                if (! Schema::hasColumn('site_settings', 'map_embed_url')) {
                    $table->text('map_embed_url')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_queries');

        if (Schema::hasTable('site_settings')) {
            Schema::table('site_settings', function (Blueprint $table) {
                foreach (['contact_sidebar_title', 'map_embed_url'] as $col) {
                    if (Schema::hasColumn('site_settings', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }
    }
};
