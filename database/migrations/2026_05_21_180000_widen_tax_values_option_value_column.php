<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('tax_values') || ! Schema::hasColumn('tax_values', 'option_value')) {
            return;
        }

        DB::statement('ALTER TABLE `tax_values` MODIFY `option_value` TEXT NULL');
    }

    public function down(): void
    {
        if (! Schema::hasTable('tax_values') || ! Schema::hasColumn('tax_values', 'option_value')) {
            return;
        }

        DB::statement('ALTER TABLE `tax_values` MODIFY `option_value` VARCHAR(191) NULL');
    }
};
