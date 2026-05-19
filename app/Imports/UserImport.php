<?php
namespace App\Imports;

use App\Models\Country;
use Spatie\Permission\Models\Role;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\OnFailure;
use Stancl\Tenancy\Facades\Tenancy;

class UserImport implements ToModel, WithHeadingRow
{

    public function model(array $row)
    {
        // Get the current tenant (for multi-tenancy)
        // $tenant = Tenancy::tenant();
        // Log::info("Tenant". $tenant);
        // Find or create the role
        $role = Role::where('name', $row['role'])->first();

        if (!$role) {
            $role = Role::create([
                'name'       => $row['role'],
                'guard_name' => 'web',
            ]);
        }

        Log::info("role". $role);
        // Find country and state by name
        $country = Country::where('name', $row['country'])->first();
        $state = State::where('name', $row['state'])->first();

        Log::info("Country". $country);
        // Check if user already exists
        $user = User::where('email', $row['email'])->first();

        Log::info("User". $user);
        if (!$user) {

            Log::info("User not found". $user);
            // Create a new user
            $user = new User([
                'tenant_id'    => tenancy()->tenant->id, // Assign tenant ID dynamically
                'username'     => $row['username'],
                'name'         => $row['name'],
                'email'        => $row['email'],
                'address'      => $row['address'],
                'country_id'   => $country ? $country->id : null,
                'state_id'     => $state ? $state->id : null,
                'city_name'    => $row['city'],
                'county_name'  => $row['county'],
                'zip_code'     => $row['zip_code'],
                'password'     => Hash::make('password'), // Default password
            ]);

            $user->save();
        }

        // Assign the role to the user if not already assigned
        if (!$user->hasRole($role->name)) {
            $user->assignRole($role);
            Log::info("Role  Assigned". $user);
        }

    }
}






