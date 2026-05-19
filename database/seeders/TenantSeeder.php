<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $t1 = Tenant::create([
            'id' => 'tenant1',
            'name' => 'Tenant 1',
        ]);
        $t1->domains()->create(['domain' => 'tenant1.pinnacle.apimstec.com']);

        $t2 = Tenant::create([
            'id' => 'tenant2',
            'name' => 'Tenant 2',
        ]);
        $t2->domains()->create(['domain' => 'tenant2.pinnacle.apimstec.com']);

        $t3 = Tenant::create([
            'id' => 'tenant3',
            'name' => 'Tenant 3',
        ]);
        $t3->domains()->create(['domain' => 'tenant3.pinnacle.apimstec.com']);;

        $t3 = Tenant::create([
            'id' => 'razorlighting.com',
            'name' => 'razorlighting',
        ]);
        $t3->domains()->create(['domain' => 'razorlighting.com']);
    }
}
