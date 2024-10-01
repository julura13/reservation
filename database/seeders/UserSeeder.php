<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Juan Rautenbach',
            'email' => 'juan@julura.co.za',
            'password' => Hash::make('1zeoa11!'),
        ]);

        // User 2: Test Admin
        User::create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('4dm1n123!!'),
        ]);
    }
}
