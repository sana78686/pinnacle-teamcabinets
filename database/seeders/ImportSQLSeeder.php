<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportSQLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Path to the SQL file
         $sqlFile = database_path('sql/world.sql');

         // Check if file exists
         if (!File::exists($sqlFile)) {
             $this->command->error("SQL file not found: $sqlFile");
             return;
         }

         // Read and execute SQL file
         $sql = File::get($sqlFile);
         DB::unprepared($sql);

         $this->command->info('SQL file imported successfully!');
    }
}
