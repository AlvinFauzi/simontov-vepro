<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // create roles and assign existing permissions

        $roleUser = Role::create(['name' => 'user']);

        $roleAdmin = Role::create(['name' => 'admin']);

        $roleSuperAdmin = Role::create(['name' => 'superAdmin']);

        $superadmin = User::updateOrCreate([
            'name' => 'Super Admin',
            'email' => 'atqiya@atqiyacode.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
        $superadmin->assignRole($roleSuperAdmin);

        $admin = User::updateOrCreate([
            'name' => 'Admin',
            'email' => 'admin@mss-app.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
        $admin->assignRole($roleAdmin);

        $user = User::updateOrCreate([
            'name' => 'user',
            'email' => 'user@mss-app.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
        ]);
        $user->assignRole($roleUser);
    }
}
