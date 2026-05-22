<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Fast geo seed for local dev / migrate:fresh — US only (id 233 matches world.sql + app code).
 * Full world data: php artisan geo:import-world
 */
class UsGeoSeeder extends Seeder
{
    public function run(): void
    {
        if (DB::table('countries')->where('id', 233)->exists()) {
            $this->command?->info('US geo data already present — skipped.');

            return;
        }

        $now = now();

        DB::table('countries')->insert([
            'id' => 233,
            'shortname' => 'US',
            'name' => 'United States',
            'phonecode' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $states = [
            'Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California', 'Colorado', 'Connecticut',
            'Delaware', 'District of Columbia', 'Florida', 'Georgia', 'Hawaii', 'Idaho', 'Illinois',
            'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana', 'Maine', 'Maryland', 'Massachusetts',
            'Michigan', 'Minnesota', 'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada',
            'New Hampshire', 'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
            'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island', 'South Carolina', 'South Dakota',
            'Tennessee', 'Texas', 'Utah', 'Vermont', 'Virginia', 'Washington', 'West Virginia',
            'Wisconsin', 'Wyoming',
        ];

        $rows = [];
        foreach ($states as $index => $name) {
            $rows[] = [
                'id' => $index + 1,
                'name' => $name,
                'country_id' => 233,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('states')->insert($rows);

        $this->command?->info('Seeded United States (country 233) and '.count($states).' states.');
    }
}
