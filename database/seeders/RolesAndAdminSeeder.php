<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Users\Role;
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
                'password' => Hash::make('password'),
                'gender_id' => 0,
                'age' => 50,
                'role_id' => $adminRole->id,
            ]
        );

        User::updateOrCreate(
            ['email' => 'test@email.com'],
            [
            'name' => 'Test User',
            'password' => Hash::make('password'),
            'gender_id' => 0,
            'age' => 25,
            'role_id' => $userRole->id,
            ]
        );
    }
}
