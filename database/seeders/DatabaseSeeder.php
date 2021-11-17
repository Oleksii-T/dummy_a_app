<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PageSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(FAQSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(BlogCategorySeeder::class);
        // $this->call(BlogSeeder::class); // no attachemnts provided
        $this->call(VisitorSeeder::class);
    }
}
