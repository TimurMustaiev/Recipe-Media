<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Ramsey\Uuid\Type\Integer;

class RecipeRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        DB::table('recipe_ratings')->insert([
            'recipe_id'=>1,
            'user_id'=>2,
            'value'=>$faker->numberBetween(1, 5)
        ]);
    }
}
