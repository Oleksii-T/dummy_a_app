<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use Illuminate\Database\Seeder;

class BlogCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogCategory::updateOrCreate(
            ['name' => 'Dummy category 1'],
            [
                'name' => 'Dummy category 1',
                'slug' => 'dummy-category-1'
            ]
        );

        BlogCategory::updateOrCreate(
            ['name' => 'Dummy category 2'],
            [
                'name' => 'Dummy category 2',
                'slug' => 'dummy-category-2'
            ]
        );
    }
}
