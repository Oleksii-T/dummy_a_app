<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run()
    {
        Order::updateOrCreate(
            ['number' => 'qwerty1'],
            [
                'user_id' => User::pluck('id')->random(),
                'number' => 'qwerty1',
                'amount' => '101',
                'description' => 'Dummy payment 1',
                'status' => Order::STATUSES[array_rand(Order::STATUSES)]
            ]
        );

        Order::updateOrCreate(
            ['number' => 'qwerty2'],
            [
                'user_id' => User::pluck('id')->random(),
                'number' => 'qwerty2',
                'amount' => '102',
                'description' => 'Dummy payment 2',
                'status' => Order::STATUSES[array_rand(Order::STATUSES)]
            ]
        );
    }
}
