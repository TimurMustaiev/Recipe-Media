<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            UserRoleSeeder::class,
            UserSeeder::class,
            CuisineSeeder::class,
            RecipeSeeder::class,
            RecipeIngredientSeeder::class,
            RecipeStepSeeder::class,
            RecipeCommentSeeder::class,
            RecipeRatingSeeder::class,
            RecipeCollectionSeeder::class,
            RecipeInCollectionSeeder::class
        ]);
    }
}
