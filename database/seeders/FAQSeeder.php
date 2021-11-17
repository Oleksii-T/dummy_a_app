<?php

namespace Database\Seeders;

use App\Models\FAQ;
use Illuminate\Database\Seeder;

class FAQSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=1; $i <= 10;$i++){
            $faker = \Faker\Factory::create();
            FAQ::create([
                'question' => $faker->sentence(4),
                'answer' => $faker->paragraph(6),
            ]);
        }
    }
}
