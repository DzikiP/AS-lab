<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'admin')->first();
        $workerRole = Role::where('name', 'worker')->first();
        $clientRole = Role::where('name', 'client')->first();

        User::create([
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'username' => 'worker1',
            'password' => Hash::make('worker123'),
            'role_id' => $workerRole->id,
        ]);

        User::create([
            'username' => 'client1',
            'password' => Hash::make('client123'),
            'role_id' => $clientRole->id,
        ]);
    }
}
