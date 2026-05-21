<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

/**
 * Apply migrations that only exist under database/migrations/tenant.
 *
 * This project uses one shared MySQL database (separate_by_tenant = false).
 * php artisan migrate:fresh only runs database/migrations/, not the tenant/ subfolder.
 * php artisan tenants:migrate replays the whole tenant/ folder (starts at users) and can
 * conflict with tables already created by central migrations.
 *
 * Use this command after migrate or migrate:fresh to run pending tenant-folder migrations only.
 */
class MigrateTenantSchemaCommand extends Command
{
    protected $signature = 'migrate:tenant-schema {--force : Force the operation to run when in production}';

    protected $description = 'Run pending migrations from database/migrations/tenant on the main database';

    public function handle(): int
    {
        $this->info('Running pending migrations from database/migrations/tenant …');
        $this->line('(Only migrations not yet recorded in the migrations table will execute.)');

        $exit = Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--realpath' => true,
            '--force' => $this->option('force'),
        ]);

        $this->output->write(Artisan::output());

        if ($exit !== 0) {
            $this->error('Some tenant migrations failed. If you see "table already exists", run: php artisan migrate');
            $this->line('New tables (2026_05_*) are also in database/migrations/ — use php artisan migrate for those.');

            return self::FAILURE;
        }

        $this->info('Done.');

        return self::SUCCESS;
    }
}
