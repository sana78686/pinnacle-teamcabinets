<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('contact_queries')) {
            Schema::table('contact_queries', function (Blueprint $table) {
                foreach ([
                    'first_name' => fn () => $table->string('first_name')->nullable()->after('name'),
                    'last_name' => fn () => $table->string('last_name')->nullable()->after('first_name'),
                    'phone' => fn () => $table->string('phone', 50)->nullable()->after('email'),
                    'hear_about_us' => fn () => $table->string('hear_about_us')->nullable()->after('phone'),
                    'best_contact_method' => fn () => $table->string('best_contact_method')->nullable()->after('hear_about_us'),
                    'newsletter_subscribe' => fn () => $table->boolean('newsletter_subscribe')->default(false)->after('best_contact_method'),
                ] as $col => $add) {
                    if (! Schema::hasColumn('contact_queries', $col)) {
                        $add();
                    }
                }
            });
        }

        if (Schema::hasTable('support_threads')) {
            Schema::table('support_threads', function (Blueprint $table) {
                if (! Schema::hasColumn('support_threads', 'guest_name')) {
                    $table->string('guest_name')->nullable()->after('user_id');
                }
                if (! Schema::hasColumn('support_threads', 'guest_email')) {
                    $table->string('guest_email')->nullable()->after('guest_name');
                }
                if (! Schema::hasColumn('support_threads', 'guest_token')) {
                    $table->string('guest_token', 64)->nullable()->unique()->after('guest_email');
                }
                if (! Schema::hasColumn('support_threads', 'is_storefront_guest')) {
                    $table->boolean('is_storefront_guest')->default(false)->after('guest_token');
                }
            });

            if (Schema::hasColumn('support_threads', 'user_id')) {
                try {
                    DB::statement('ALTER TABLE support_threads MODIFY user_id BIGINT UNSIGNED NULL');
                } catch (\Throwable) {
                }
            }
        }

        if (Schema::hasTable('support_messages') && ! Schema::hasColumn('support_messages', 'guest_name')) {
            Schema::table('support_messages', function (Blueprint $table) {
                $table->string('guest_name')->nullable()->after('user_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('contact_queries')) {
            Schema::table('contact_queries', function (Blueprint $table) {
                foreach (['first_name', 'last_name', 'phone', 'hear_about_us', 'best_contact_method', 'newsletter_subscribe'] as $col) {
                    if (Schema::hasColumn('contact_queries', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('support_threads')) {
            Schema::table('support_threads', function (Blueprint $table) {
                foreach (['guest_name', 'guest_email', 'guest_token', 'is_storefront_guest'] as $col) {
                    if (Schema::hasColumn('support_threads', $col)) {
                        $table->dropColumn($col);
                    }
                }
            });
        }

        if (Schema::hasTable('support_messages') && Schema::hasColumn('support_messages', 'guest_name')) {
            Schema::table('support_messages', function (Blueprint $table) {
                $table->dropColumn('guest_name');
            });
        }
    }
};
