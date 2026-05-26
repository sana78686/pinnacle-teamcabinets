<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('stock_check_requests') || Schema::hasColumn('stock_check_requests', 'quote_name')) {
            return;
        }

        Schema::table('stock_check_requests', function (Blueprint $table) {
            $table->string('quote_name')->nullable()->after('job_name');
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('stock_check_requests') || ! Schema::hasColumn('stock_check_requests', 'quote_name')) {
            return;
        }

        Schema::table('stock_check_requests', function (Blueprint $table) {
            $table->dropColumn('quote_name');
        });
    }
};
