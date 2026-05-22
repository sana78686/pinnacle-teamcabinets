<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TenantUserSchemaService
{
    /**
     * Ensure users.status accepts tenant registration values (un-approved, approved, block).
     * Legacy DBs may still have ENUM('active','deactive') from an older migration.
     */
    public function ensureStatusColumn(): void
    {
        if (! Schema::hasTable('users') || ! Schema::hasColumn('users', 'status')) {
            return;
        }

        if (Schema::getConnection()->getDriverName() !== 'mysql') {
            return;
        }

        $column = DB::selectOne("SHOW COLUMNS FROM `users` WHERE Field = 'status'");
        if (! $column || ! isset($column->Type)) {
            return;
        }

        $type = strtolower((string) $column->Type);
        if (str_contains($type, 'varchar(32)')) {
            return;
        }

        DB::statement("ALTER TABLE `users` MODIFY `status` VARCHAR(32) NOT NULL DEFAULT 'un-approved'");

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
}
