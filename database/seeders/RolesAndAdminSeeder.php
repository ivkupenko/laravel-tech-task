<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole  = Role::firstOrCreate(['name' => 'user']);

        User::updateOrCreate(
            ['email' => 'admin@email.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('pass'),
                'role_id' => $adminRole->id,
            ]
        );
    }
}
