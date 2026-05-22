<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;

class ImportWorldGeoCommand extends Command
{
    protected $signature = 'geo:import-world
                            {--force : Import even if countries table already has rows}
                            {--mysql : Prefer mysql CLI (much faster than PHP)}';

    protected $description = 'Import countries/states/cities from database/sql/world.sql (slow; optional)';

    public function handle(): int
    {
        $sqlFile = database_path('sql/world.sql');

        if (! File::exists($sqlFile)) {
            $this->error("SQL file not found: {$sqlFile}");

            return self::FAILURE;
        }

        if (! $this->option('force') && DB::table('countries')->exists()) {
            $this->warn('Countries table is not empty. Use --force to replace with world.sql import.');

            return self::SUCCESS;
        }

        $this->warn('Importing world.sql (~21MB, 150k+ lines). This can take several minutes.');
        $this->line('For daily dev use: php artisan db:seed --class=UsGeoSeeder (US only, seconds).');

        if ($this->option('mysql') || $this->mysqlCliAvailable()) {
            if ($this->importViaMysqlCli($sqlFile)) {
                $this->info('world.sql imported via mysql CLI.');

                return self::SUCCESS;
            }

            $this->warn('mysql CLI import failed; falling back to PHP chunked import.');
        }

        $this->importViaPhp($sqlFile);
        $this->info('world.sql imported via PHP.');

        return self::SUCCESS;
    }

    protected function mysqlCliAvailable(): bool
    {
        $process = Process::fromShellCommandline('mysql --version');
        $process->run();

        return $process->isSuccessful();
    }

    protected function importViaMysqlCli(string $sqlFile): bool
    {
        $connection = config('database.connections.'.config('database.default'));
        if (($connection['driver'] ?? '') !== 'mysql') {
            return false;
        }

        $host = $connection['host'] ?? '127.0.0.1';
        $port = $connection['port'] ?? '3306';
        $database = $connection['database'] ?? '';
        $username = $connection['username'] ?? 'root';
        $password = $connection['password'] ?? '';

        $env = array_filter(getenv()) + $_ENV + $_SERVER;
        if ($password !== '') {
            $env['MYSQL_PWD'] = $password;
        }

        $command = [
            'mysql',
            '-h'.$host,
            '-P'.(string) $port,
            '-u'.$username,
            $database,
        ];

        $process = new Process($command, null, $env);
        $process->setTimeout(3600);
        $process->setInput(File::get($sqlFile));
        $process->run();

        if (! $process->isSuccessful()) {
            $this->error($process->getErrorOutput());

            return false;
        }

        return true;
    }

    protected function importViaPhp(string $sqlFile): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $handle = fopen($sqlFile, 'r');
        $buffer = '';
        $statements = 0;

        while (($line = fgets($handle)) !== false) {
            $trimmed = trim($line);
            if ($trimmed === '' || str_starts_with($trimmed, '--')) {
                continue;
            }

            $buffer .= $line;

            if (! str_ends_with(rtrim($line), ';')) {
                continue;
            }

            try {
                DB::unprepared($buffer);
                $statements++;
                if ($statements % 50 === 0) {
                    $this->output->write('.');
                }
            } catch (\Throwable $e) {
                $this->newLine();
                $this->warn('Skipped statement: '.$e->getMessage());
            }

            $buffer = '';
        }

        fclose($handle);
        $this->newLine();

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
