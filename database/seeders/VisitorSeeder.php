<?php

namespace Database\Seeders;

use App\Models\Visitor;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class VisitorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 25; $i++) { 
            $faker = \Faker\Factory::create();
            Visitor::create([
                'ip' => $faker->ipv4(),
                'created_at' => Carbon::now()->subDays(rand(7,14))
            ]);
        }

        for ($i=0; $i < 38; $i++) { 
            $faker = \Faker\Factory::create();
            Visitor::create([
                'ip' => $faker->ipv4(),
                'created_at' => Carbon::now()->subDays(rand(0,7))
            ]);
        }
    }
}
