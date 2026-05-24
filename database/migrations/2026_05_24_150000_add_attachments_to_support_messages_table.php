<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('support_messages')) {
            return;
        }

        Schema::table('support_messages', function (Blueprint $table) {
            if (! Schema::hasColumn('support_messages', 'attachment_path')) {
                $table->string('attachment_path', 500)->nullable()->after('message');
            }
            if (! Schema::hasColumn('support_messages', 'attachment_name')) {
                $table->string('attachment_name', 255)->nullable()->after('attachment_path');
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('support_messages')) {
            return;
        }

        Schema::table('support_messages', function (Blueprint $table) {
            if (Schema::hasColumn('support_messages', 'attachment_name')) {
                $table->dropColumn('attachment_name');
            }
            if (Schema::hasColumn('support_messages', 'attachment_path')) {
                $table->dropColumn('attachment_path');
            }
        });
    }
};
