<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = BlogCategory::all();
        for ($i=1; $i <= 10;$i++){
            $faker = \Faker\Factory::create();
            $title = $faker->sentence(2);
            $blog = Blog::create([
                'title' => $title,
                'slug' => Str::slug($title, '-'),
                'content' => $faker->paragraph(6),
            ]);
            $blog->categories()->attach($categories->random());
        }
    }
}
