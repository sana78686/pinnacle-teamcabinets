<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'point_factor')) {
                $table->decimal('point_factor', 8, 4)->nullable()->default(0);
            }
            if (! Schema::hasColumn('users', 'door_point_factor')) {
                $table->json('door_point_factor')->nullable();
            }
            if (! Schema::hasColumn('users', 'catalog_visibility')) {
                $table->json('catalog_visibility')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $drops = [];
            foreach (['point_factor', 'door_point_factor', 'catalog_visibility'] as $col) {
                if (Schema::hasColumn('users', $col)) {
                    $drops[] = $col;
                }
            }
            if ($drops !== []) {
                $table->dropColumn($drops);
            }
        });
    }
};
