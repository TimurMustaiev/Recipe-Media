<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeInGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recipes_in_group')->insert([
            'recipe_group_id'=>1,
            'recipe_id'=>1,
        ]);

        DB::table('recipes_in_group')->insert([
            'recipe_group_id'=>1,
            'recipe_id'=>2,
        ]);
    }
}
