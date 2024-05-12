<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeIngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recipe_ingredients')->insert([
            'recipe_id'=>1,
            'name'=>'яблуко',
            'amount'=>2,
            'unit'=>'шт.'
        ]);

        DB::table('recipe_ingredients')->insert([
            'recipe_id'=>1,
            'name'=>'цукор',
            'amount'=>3,
            'unit'=>'ч.л.'
        ]);
    }
}
