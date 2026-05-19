<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create User
        $user = User::create([
            'name' => 'Team Cabinets',
            'email' => 'super-user@demo.com',
            'username' => 'Pinnacle Super User',
            'password' => Hash::make('password'),
            'is_super_user' => 1,
            'country_id' => 233,
            'state_id' => State::inRandomOrder()->first()->id,
            'address' => '915 Doyle Road Suite 303 -225',
            'city_name' => 'Deltona',
            'county_name' => 'Volusia County',
            'tenant_id' => Tenant::inRandomOrder()->first()->id,
        ]);
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@demo.com',
            'username' => 'Admin',
            'tenant_id' => 'tenant1',
            'country_id' => 233,
            'state_id' => State::inRandomOrder()->first()->id,
            'address' => '915 Doyle Road Suite 303 -225',
            'city_name' => 'Deltona',
            'county_name' => 'Volusia County',
            'password' => Hash::make('password')
        ]);
        $razorAdmin = User::create([
            'name' => 'Thomas',
            'email' => 'Thomas@demo.com',
            'username' => 'Admin',
            'tenant_id' => 'razorlighting.com',
            'country_id' => 233,
            'state_id' => State::inRandomOrder()->first()->id,
            'address' => '915 Doyle Road Suite 303 -225',
            'city_name' => 'Deltona',
            'county_name' => 'Volusia County',
            'password' => Hash::make('password')
        ]);
        $razorRepresentative = User::create([
            'name' => 'Raiyyan Representative',
            'email' => 'raiyan@demo.com',
            'username' => 'raiyyan_representative',
            'tenant_id' => 'razorlighting.com',
            'country_id' => 233,
            'state_id' => State::inRandomOrder()->first()->id,
            'address' => '915 Doyle Road Suite 303 -225',
            'city_name' => 'Deltona',
            'county_name' => 'Volusia County',
            'password' => Hash::make('password')
        ]);
        $representative = User::create([
            'name' => 'Raiyyan Representative',
            'email' => 'representative@demo.com',
            'username' => 'raiyyan_representative',
            'tenant_id' => 'tenant1',
            'country_id' => 233,
            'state_id' => State::inRandomOrder()->first()->id,
            'address' => '915 Doyle Road Suite 303 -225',
            'city_name' => 'Deltona',
            'county_name' => 'Volusia County',
            'password' => Hash::make('password')
        ]);
        $razorDealer = User::create([
            'name' => 'Tom',
            'email' => 'tom@demo.com',
            'username' => 'tom',
            'password' => Hash::make('password'),
            'country_id' => 233,
            'state_id' => State::inRandomOrder()->first()->id,
            'address' => '915 Doyle Road Suite 303 -225',
            'city_name' => 'Deltona',
            'county_name' => 'Volusia County',
            'tenant_id' => 'razorlighting.com',
        ]);
        $dealer = User::create([
            'name' => 'Sana Dealer',
            'email' => 'dealer@demo.com',
            'username' => 'sana_dealer',
            'password' => Hash::make('password'),
            'country_id' => 233,
            'state_id' => State::inRandomOrder()->first()->id,
            'address' => '915 Doyle Road Suite 303 -225',
            'city_name' => 'Deltona',
            'county_name' => 'Volusia County',
            'tenant_id' => Tenant::inRandomOrder()->first()->id,
        ]);
        // Create Role
      $role = Role::firstOrCreate(['name' => 'Admin']);
$role_representative = Role::firstOrCreate(['name' => 'Representative']);
Role::firstOrCreate(['name' => 'Distributor']);
Role::firstOrCreate(['name' => 'Customer']);
Role::firstOrCreate(['name' => 'Showroom']);
$role_dealer = Role::firstOrCreate(['name' => 'Dealer']);


        // Get All Permissions
        $permissions = Permission::pluck('id', 'id')->all();

        // Sync Permissions with Role
        $role->syncPermissions($permissions);

        // Assign Role to User
        $user->assignRole([$role->id]);
        $admin->assignRole([$role->id]);
        $representative->assignRole([$role_representative->id]);
        $dealer->assignRole([$role_dealer->id]);
        $razorAdmin->assignRole([$role->id]);
        $razorRepresentative->assignRole([$role_representative->id]);
        $razorDealer->assignRole([$role_dealer->id]);

        // Debug: Get permissions assigned to the user
        Log::info('User Permissions:', $user->getPermissionsViaRoles()->toArray());
    }
}





