<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::insert([
            ['name' => 'nowy'],
            ['name' => 'w trakcie realizacji'],
            ['name' => 'zrealizowany'],
        ]);
    }
}
