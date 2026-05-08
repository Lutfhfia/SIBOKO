<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin Default
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@sibokon.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
