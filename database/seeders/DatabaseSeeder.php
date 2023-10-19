<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\Category;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::create([
            'name' => 'Tridiktya Putra',
            'email' => 'tridiktya@mail.id',
            'password' => bcrypt('tridik12')
        ]);

        Category::create([
            'category_name' => "Product Design",
            'category_slug' => "product-design"
        ]);

        Category::create([
            'category_name' => "Web Design",
            'category_slug' => "web-design"
        ]);

        Category::create([
            'category_name' => "Graphic Design",
            'category_slug' => "graphic-design"
        ]);
    }
}
