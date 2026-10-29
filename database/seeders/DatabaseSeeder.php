<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        foreach ([
            ['name' => 'Men', 'slug' => 'men', 'description' => 'Everyday essentials and considered layers, made for wherever the day takes you.'],
            ['name' => 'Women', 'slug' => 'women', 'description' => 'Easy silhouettes, thoughtful details, and pieces you will reach for again.'],
            ['name' => 'Kids', 'slug' => 'kids', 'description' => 'Comfortable favorites for little people with big plans.'],
        ] as $category) {
            Category::query()->firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
