<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeInGroup;
use App\Models\RecipeRating;
use App\Models\RecipeComment;
use Illuminate\Support\Facades\Auth;

//рейтинги порахувати

class RecipeController extends Controller
{
    public function get_recent_recipes() { //змінити назву
        $recent_recipes = Recipe::orderBy('creation_datetime', 'desc')->take(3)->get();

        return view('main')->with('recent_recipes', $recent_recipes);
    }

    public function get_all_recipes() {
        $recipes = Recipe::orderBy('creation_datetime', 'desc')->get();

        return view('recipes')->with('recipes', $recipes);
    }

    public function get_user_recipes($user_id) {
        $recipes = Recipe::where('user_id', $user_id)->orderBy('creation_datetime', 'desc')->get();

        return view('recipes')->with('recipes', $recipes);
    }

    public function get_recipe($recipe_id) {
        $recipe = Recipe::with(['recipe_ingredients', 'recipe_steps', 'recipe_comments'])->find($recipe_id);

        return view('recipe/overview')->with('recipe', $recipe);
    }

    public function get_recipes_from_group($user_id, $recipe_group_id) {
        $recipes = Recipe::whereIn('recipe_id', RecipeInGroup::where('recipe_group_id', $recipe_group_id)->get('recipe_id'))->get();

        return view('recipes')->with('recipes', $recipes);
    }

    public function search_recipes(Request $request) {
        $recipe_name = $request->get('recipe_name');

        $matching_recipes = Recipe::where('name', 'ILIKE', '%' . $recipe_name . '%')->get(); //лише для pgsql

        return view('recipes')->with('recipes', $matching_recipes);
    }

    //CRUD
    public function create_step_one() {
        $cuisines = Cuisine::all();

        return view('recipe/create_step_one')->with('cuisines', $cuisines);
    }

    public function store_step_one(Request $request) {
        $recipe_name = $request->get('recipe_name');
        $recipe_img = $request->file('recipe_img');
        $cuisine = $request->get('recipe_cuisine');
        $recipe_meal_type = $request->get('recipe_meal_type');
        $recipe_description = $request->get('recipe_description');
        $user_id = Auth::user()->user_id;

        //процес створення шляху до зображення і його збереження (подумати що робити із імг якщо не заповняться всі форми)
        $recipe_img_name = time().'.'.$recipe_img->extension();
        $recipe_img->move(public_path('images/recipe_picture'), $recipe_img_name);
        $recipe_img_path = 'images/profile_picture/{$recipe_img_name}';

        session()->put('step_1_data', array('recipe_name' => $recipe_name, 'recipe_img_path' => $recipe_img_path,
                    'recipe_meal_type' => $recipe_meal_type, 'cuisine' => $cuisine,
                    'recipe_description' => $recipe_description, 'user_id' => $user_id));

        return redirect(route('recipes.create_step_two'));
    }

    public function create_step_two() {
        return view('recipe/create_step_two');
    }
}
