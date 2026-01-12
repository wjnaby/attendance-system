<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Admin User
        User::firstOrCreate(
            ['email' => 'admin@example.com'], // check by email
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'employee_id' => 'EMP001',
            ]
        );

        // Regular User
        User::firstOrCreate(
            ['email' => 'user@example.com'], // check by email
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'role_id' => 2,
                'employee_id' => 'EMP002',
            ]
        );
    }
}
