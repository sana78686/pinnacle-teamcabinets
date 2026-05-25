<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('manage_document')) {
            return;
        }

        Schema::table('manage_document', function (Blueprint $table) {
            if (! Schema::hasColumn('manage_document', 'status')) {
                $table->string('status', 20)->default('active')->after('document_name');
            }
            if (! Schema::hasColumn('manage_document', 'created_at')) {
                $table->timestamps();
            }
            if (! Schema::hasColumn('manage_document', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('manage_document')) {
            return;
        }

        Schema::table('manage_document', function (Blueprint $table) {
            if (Schema::hasColumn('manage_document', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
            if (Schema::hasColumn('manage_document', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('manage_document', 'created_at')) {
                $table->dropTimestamps();
            }
        });
    }
};
