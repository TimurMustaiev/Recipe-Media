<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeInCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recipes_in_collection')->insert([
            'recipe_collection_id'=>1,
            'recipe_id'=>1,
        ]);

        DB::table('recipes_in_collection')->insert([
            'recipe_collection_id'=>1,
            'recipe_id'=>2,
        ]);
    }
}
