<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'status')) {
            return;
        }

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `users` MODIFY `status` VARCHAR(32) NOT NULL DEFAULT 'un-approved'");
        }

        $legacyMap = [
            'active' => 'approved',
            'deactive' => 'block',
            'inactive' => 'block',
            'unapproved' => 'un-approved',
            'un_approved' => 'un-approved',
            'pending' => 'un-approved',
            'unapproval' => 'un-approved',
            'un-approval' => 'un-approved',
        ];

        foreach ($legacyMap as $from => $to) {
            DB::table('users')->where('status', $from)->update(['status' => $to]);
        }

        DB::table('users')->whereNull('status')->orWhere('status', '')->update(['status' => 'un-approved']);
    }

    public function down(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'status')) {
            return;
        }

        if (Schema::getConnection()->getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE `users` MODIFY `status` ENUM('approved','un-approved','block') NOT NULL DEFAULT 'un-approved'");
        }
    }
};
