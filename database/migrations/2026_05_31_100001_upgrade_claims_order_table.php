<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('claims_order')) {
            return;
        }

        Schema::table('claims_order', function (Blueprint $table) {
            if (! Schema::hasColumn('claims_order', 'admin_viewed_at')) {
                $table->timestamp('admin_viewed_at')->nullable();
            }
            if (! Schema::hasColumn('claims_order', 'deleted_at')) {
                $table->softDeletes();
            }
            if (! Schema::hasColumn('claims_order', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        // Non-destructive upgrade only.
    }
};
