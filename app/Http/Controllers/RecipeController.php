<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeComment;
use App\Models\RecipeGroup;
use App\Models\RecipeIngredient;
use App\Models\RecipeInGroup;
use App\Models\RecipeRating;
use App\Models\RecipeStep;
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
        $recipe = Recipe::find($recipe_id);

        $recipe_ingredients = RecipeIngredient::where('recipe_id', $recipe_id)->get();

        $recipe_steps = RecipeStep::where('recipe_id', $recipe_id)->get();

        //коментарі
        //подивитись про автоматичне добирання і чи можна його прибрати бо зайві ресурси
        $recipe_comments = RecipeComment::where('recipe_id', $recipe_id)->get();

        return view('recipe/overview')->with('recipe', $recipe)
                                      ->with('recipe_ingredients', $recipe_ingredients)
                                      ->with('recipe_steps', $recipe_steps)
                                      ->with('recipe_comments', $recipe_comments);
    }

    public function get_recipes_from_group($recipe_group_id) {
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
        $recipe_img->move(public_path('images/profile_picture'), $recipe_img_name);
        $recipe_img_path = 'images/profile_picture/{$recipe_img_name}';

        session()->put('step_1_data', array('recipe_name' => $recipe_name, 'recipe_img_path' => $recipe_img_path,
                    'recipe_meal_type' => $recipe_meal_type, 'cuisine' => $cuisine,
                    'recipe_description' => $recipe_description, 'user_id' => $user_id));

        return redirect(route('recipes.create_step_two'));
    }

    public function create_step_two() {
        dd('dsfsdf');
    }

    //recipe overview post
    public function store_rating_or_comment(Request $request, $recipe_id) {
        $recipe_rating_value = $request->get('recipe_rating');
        $recipe_comment = $request->get('recipe_comment');
        
        if ($recipe_rating_value != null) {
            $existing_recipe_rating = RecipeRating::where('user_id', Auth::user()->user_id)
                                                  ->where('recipe_id', $recipe_id)
                                                  ->first();
            
            $has_previous_rating = false;

            if ($existing_recipe_rating) {
                $existing_recipe_rating->value = $recipe_rating_value;
                $existing_recipe_rating->save();

                $has_previous_rating = true;
            }
            else {
                $recipe_rating = new RecipeRating();
                $recipe_rating->user_id = Auth::user()->user_id;
                $recipe_rating->recipe_id = $recipe_id;
                $recipe_rating->value = $recipe_rating_value;
                $recipe_rating->save();
            }

            return redirect(route('recipes.show', $recipe_id))->with('set_rating', true)
                                                              ->with('has_previous_rating', $has_previous_rating);
        }
    }
}
