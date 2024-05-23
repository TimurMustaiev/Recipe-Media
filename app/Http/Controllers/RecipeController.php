<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;
use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use App\Models\RecipeStep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RecipeController extends Controller
{
    public function get_recent_recipes() { //змінити назву
        $recent_recipes = Recipe::latest('updated_at')->take(3)->get();

        return view('main')->with('recent_recipes', $recent_recipes);
    }

    public function get_all_recipes() {
        $recipes = Recipe::latest('updated_at')->get();

        return view('recipes')->with('recipes', $recipes);
    }

    public function get_user_recipes($user_id) {
        $recipes = Recipe::where('user_id', $user_id)->latest('updated_at')->get();

        return view('recipes-user')->with('recipes', $recipes)
                                   ->with('user_id', $user_id);
    }

    public function get_recipe($recipe_id) {
        $recipe = Recipe::with(['recipe_ingredients', 'recipe_steps', 'recipe_comments'])->find($recipe_id);

        return view('recipe/overview')->with('recipe', $recipe);
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
        if(session()->has('step_1_data'))
            session()->forget('step_1_data');
        if(session()->has('step_1_data'))
            session()->forget('step_2_data');

        $recipe_name = $request->get('recipe_name');
        $recipe_img = $request->file('recipe_img');
        $cuisine_id = $request->get('cuisine');
        $recipe_meal_type = $request->get('recipe_meal_type');
        $recipe_description = $request->get('recipe_description');
        $user_id = Auth::user()->user_id;

        //процес створення шляху до зображення і його збереження (подумати що робити із імг якщо не заповняться всі форми)
        $recipe_img_name = time().'.'.$recipe_img->extension();
        $recipe_img->move(public_path('images/recipe_picture'), $recipe_img_name);
        $recipe_img_path = "images/recipe_picture/{$recipe_img_name}";

        session()->put('step_1_data', array('name' => $recipe_name, 'img_path' => $recipe_img_path,
                    'meal_type' => $recipe_meal_type, 'cuisine_id' => $cuisine_id,
                    'description' => $recipe_description));

        return redirect(route('recipes.create_step_two'));
    }

    public function create_step_two() {
        return view('recipe/create_step_two');
    }

    public function store_step_two(Request $request) {
        $meal_type = $request->get('meal_type');
        $recipe_ingredients = $request->get('ingredients_array');

        session()->put('step_2_data', array('meal_type' => $meal_type, 'recipe_ingredients' => $recipe_ingredients));

        return redirect(route('recipes.create_step_three'));
    }

    public function create_step_three() {
        return view('recipe/create_step_three');
    }

    public function store_step_three(Request $request) {
        $recipe_steps = json_decode($request->get('steps_array'), true);
        $step_1_data = session()->get('step_1_data');
        $step_2_data = session()->get('step_2_data');

        $recipe = new Recipe();
        $recipe->name = $step_1_data['name'];
        $recipe->user_id = Auth::user()->user_id;
        $recipe->cuisine_id = $step_1_data['cuisine_id'];
        $recipe->meal_type = $step_2_data['meal_type'];
        $recipe->description = $step_1_data['description'];
        $recipe->img_path = $step_1_data['img_path'];
        $recipe->save();

        foreach(json_decode($step_2_data['recipe_ingredients'], true) as $recipe_ingredient_data) {
            $recipe_ingredient = new RecipeIngredient();
            $recipe_ingredient->recipe_id = $recipe->recipe_id;
            $recipe_ingredient->name = $recipe_ingredient_data['name'];
            $recipe_ingredient->amount = $recipe_ingredient_data['amount'];
            $recipe_ingredient->unit = $recipe_ingredient_data['unit'];
        
            $recipe_ingredient->save();
        }

        foreach($recipe_steps as $recipe_step_data) {
            $recipe_step = new RecipeStep();
            $recipe_step->recipe_id = $recipe->recipe_id;
            $recipe_step->ordinal_number = $recipe_step_data['ordinalNumber'];
            $recipe_step->description = $recipe_step_data['description'];

            $recipe_step->save();
        }

        return redirect(route('recipes.show', $recipe->recipe_id));
    }

    public function destroy($recipe_id) {
        $recipe = Recipe::find($recipe_id);
        if(File::exists($recipe->img_path))
            File::delete($recipe->img_path);
        $recipe->delete();

        return redirect(route('recipes.show_user', Auth::user()->user_id));
    }
}
