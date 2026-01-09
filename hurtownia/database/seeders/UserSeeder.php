<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'admin',
            'password' => Hash::make('haslo123'),
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'worker1',
            'password' => Hash::make('haslo123'),
            'role' => 'worker',
        ]);

        User::create([
            'username' => 'client1',
            'password' => Hash::make('haslo123'),
            'role' => 'client',
        ]);
    }
}
