<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * @deprecated Use UsGeoSeeder for migrate:fresh (fast). Use `php artisan geo:import-world` for full world.sql.
 */
class ImportSQLSeeder extends Seeder
{
    public function run(): void
    {
        $this->command?->warn('ImportSQLSeeder is slow (21MB world.sql).');
        $this->command?->line('  Fast dev:  php artisan db:seed --class=UsGeoSeeder');
        $this->command?->line('  Full world: php artisan geo:import-world --force');

        if (! $this->command?->confirm('Run full world.sql import now?', false)) {
            $this->command?->info('Skipped. Running UsGeoSeeder instead.');
            $this->call(UsGeoSeeder::class);

            return;
        }

        $exit = $this->command?->call('geo:import-world', ['--force' => true]);

        if ($exit !== 0) {
            $this->command?->error('geo:import-world failed.');
        }
    }
}
