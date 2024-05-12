<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RecipeStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        
        DB::table('recipe_steps')->insert([
            'recipe_id'=>1,
            'ordinal_number'=>1,
            'description'=>$faker->realText()
        ]);
        DB::table('recipe_steps')->insert([
            'recipe_id'=>1,
            'ordinal_number'=>2,
            'description'=>$faker->realText()
        ]);
        DB::table('recipe_steps')->insert([
            'recipe_id'=>1,
            'ordinal_number'=>3,
            'description'=>$faker->realText()
        ]);
    }
}
