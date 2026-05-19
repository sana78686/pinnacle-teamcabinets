<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Pinnacle super-admin (central panel). No tenant required.
     */
    public function run(): void
    {
        $stateId = State::query()->where('country_id', 233)->value('id')
            ?? State::query()->value('id');

        $user = User::query()->updateOrCreate(
            ['email' => 'super-user@demo.com'],
            [
                'name' => 'Pinnacle Super User',
                'username' => 'pinnacle_super_user',
                'password' => Hash::make('password'),
                'is_super_user' => 1,
                'tenant_id' => null,
                'country_id' => 233,
                'state_id' => $stateId,
                'address' => '915 Doyle Road Suite 303 -225',
                'city_name' => 'Deltona',
                'county_name' => 'Volusia County',
                'status' => 'active',
                'is_verified_by_admin' => true,
            ]
        );

        $role = Role::firstOrCreate(['name' => 'Admin']);
        $permissions = Permission::pluck('id', 'id')->all();
        if ($permissions !== []) {
            $role->syncPermissions($permissions);
        }

        if (! $user->hasRole($role->name)) {
            $user->assignRole($role);
        }
    }
}
