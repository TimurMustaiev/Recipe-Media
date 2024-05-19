<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecipeCollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recipe_collections')->insert([
            'name'=>'Гострі рецепти',
            'user_id'=>1,
            'img_path'=>'images/recipe_picture/recipe_1.jpg',
            'description'=>'Вирішив у цьому році вперше скуштувати гострі страви - і ось найкращі з них!',
            'access_modificator'=>'публічна'
        ]);

        DB::table('recipe_collections')->insert([
            'name'=>'Солодкі рецепти',
            'user_id'=>1,
            'img_path'=>'images/recipe_picture/recipe_1.jpg',
            'access_modificator'=>'приватна'
        ]);
    }
}
