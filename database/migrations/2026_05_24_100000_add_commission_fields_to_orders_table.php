<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'mfg_comm')) {
                $table->decimal('mfg_comm', 10, 4)->default(0);
            }
            if (! Schema::hasColumn('orders', 'rep_comm')) {
                $table->decimal('rep_comm', 10, 4)->default(0);
            }
            if (! Schema::hasColumn('orders', 'aff_comm')) {
                $table->decimal('aff_comm', 10, 4)->default(0);
            }
            if (! Schema::hasColumn('orders', 'sub_aff_commission')) {
                $table->decimal('sub_aff_commission', 10, 4)->default(0);
            }
            if (! Schema::hasColumn('orders', 'rep_id')) {
                $table->unsignedBigInteger('rep_id')->nullable();
            }
            if (! Schema::hasColumn('orders', 'parent_id')) {
                $table->unsignedBigInteger('parent_id')->nullable();
            }
            if (! Schema::hasColumn('orders', 'state')) {
                $table->unsignedTinyInteger('state')->default(1);
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            foreach (['mfg_comm', 'rep_comm', 'aff_comm', 'sub_aff_commission', 'rep_id', 'parent_id', 'state'] as $col) {
                if (Schema::hasColumn('orders', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
