<?php

namespace App\Http\Controllers;

use App\Models\Cuisine;
use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    public function get_recipes_for_main() {
        $recent_recipes = Recipe::with('cuisine', 'user')->latest('updated_at')->take(3)->get();

        $best_recipes = Recipe::with('cuisine')->withCount('recipe_ratings')->with(['recipe_ratings' => function ($query) {
            $query->selectRaw('AVG(value) as avg_recipe_rating, recipe_id')->groupBy('recipe_id');
        }])->get()->sortByDesc(function ($recipe) {
            if ($recipe->recipe_ratings_count == 0 || is_null($recipe->recipe_ratings->first())) {
                return 0;
            }
            return $recipe->recipe_ratings_count / $recipe->recipe_ratings->first()->avg_recipe_rating;
        })->take(3)->reverse();

        return view('main')->with('recent_recipes', $recent_recipes)
                           ->with('best_recipes', $best_recipes);
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

        if($recipe_name == null || $recipe_name == '') {
            
        }

        $matching_recipes = Recipe::where('name', 'ILIKE', '%' . $recipe_name . '%')->get();

        return view('recipes')->with('recipes', $matching_recipes);
    }

    public function create_step_one() {
        $cuisines = Cuisine::all();

        return view('recipe/create-step-one')->with('cuisines', $cuisines);
    }

    public function store_step_one(Request $request) {
        $rules = ['recipe_name' => 'required',
                  'recipe_img' => 'required|image',
                  'cuisine' => 'required',
                  'recipe_meal_type' => 'required'];
        $validator = Validator::make($request->all(), $rules,
                                     ['recipe_name.required' => 'Назва Рецепту не може бути пустою',
                                      'recipe_img.required' => 'Зображення головного фото Рецепту не обрано',
                                      'recipe_img.image' => 'Обраний файл не є зображенням',
                                      'cuisine.required' => 'Кухню Рецепту не обрано',
                                      'recipe_meal_type.required' => 'Тип страви не обрано']);
        if ($validator->fails()) {
            return redirect(route('recipes.create_step_one'))->withErrors($validator)
                                                             ->withInput();
        }

        if(session()->has('step_1_data'))
            session()->forget('step_1_data');
        if(session()->has('step_1_data'))
            session()->forget('step_2_data');

        $recipe_name = $request->get('recipe_name');
        $recipe_img = $request->file('recipe_img');
        $cuisine_id = $request->get('cuisine');
        $recipe_meal_type = $request->get('recipe_meal_type');
        $recipe_description = $request->get('recipe_description');

        //процес створення шляху до зображення і його збереження (подумати що робити із імг якщо не заповняться всі форми)
        $recipe_img_name = time().'.'.$recipe_img->extension();
        $recipe_img_path = "images/recipe_picture/{$recipe_img_name}";
        $recipe_img->move(public_path('images/recipe_picture'), $recipe_img_name);

        session()->put('step_1_data', array('name' => $recipe_name, 'img_path' => $recipe_img_path,
                    'meal_type' => $recipe_meal_type, 'cuisine_id' => $cuisine_id,
                    'description' => $recipe_description));

        return redirect(route('recipes.create_step_two'));
    }

    public function create_step_two() {
        return view('recipe/create-step-two');
    }

    public function store_step_two(Request $request) {
        $recipe_ingredients = json_decode($request->get('ingredients_array'), true);

        $rules = ['ingredients_array' => ['required',
                                          function ($attribute, $value, $fail) {
                                              $decodedValue = json_decode($value);
                                              if (empty($decodedValue)) {
                                                  $fail('Не введено жодного Інгрідієнту');
                                              }
                                          }]];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('recipes.create_step_two'))->withErrors($validator)
                                                             ->withInput();
        }

        session()->put('step_2_data', array('recipe_ingredients' => $recipe_ingredients));

        return redirect(route('recipes.create_step_three'));
    }

    public function create_step_three() {
        return view('recipe/create-step-three');
    }

    public function store_step_three(Request $request) {
        $recipe_steps = json_decode($request->get('steps_array'), true);
        $step_1_data = session()->get('step_1_data');
        $step_2_data = session()->get('step_2_data');

        $rules = ['steps_array' => ['required',
                                          function ($attribute, $value, $fail) {
                                              $decodedValue = json_decode($value);
                                              if (empty($decodedValue)) {
                                                  $fail('Не введено жодного Кроку');
                                              }
                                          }]];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect(route('recipes.create_step_three'))->withErrors($validator)
                                                               ->withInput();
        }

        $recipe = new Recipe();
        $recipe->name = $step_1_data['name'];
        $recipe->user_id = Auth::user()->user_id;
        $recipe->cuisine_id = $step_1_data['cuisine_id'];
        $recipe->meal_type = $step_1_data['meal_type'];
        $recipe->description = $step_1_data['description'];
        $recipe->img_path = $step_1_data['img_path'];
        $recipe->save();

        foreach($step_2_data['recipe_ingredients'] as $recipe_ingredient_data) {
            $recipe->recipe_ingredients()->create(['name' => $recipe_ingredient_data['name'],
                                                   'amount' => $recipe_ingredient_data['amount'],
                                                   'unit' => $recipe_ingredient_data['unit']]);
        }

        foreach($recipe_steps as $recipe_step_data) {
            $recipe->recipe_steps()->create(['ordinal_number' => $recipe_step_data['ordinalNumber'],
                                             'description' => $recipe_step_data['description']]);
        }

        return redirect(route('recipes.show', $recipe->recipe_id));
    }

    public function edit_general_data($recipe_id) {
        $recipe = Recipe::find($recipe_id);
        $cuisines = Cuisine::all();

        return view('recipe/edit-general-data')->with('recipe', $recipe)
                                               ->with('cuisines', $cuisines);
    }

    public function update_general_data(Request $request, $recipe_id) {
        $rules = ['recipe_name' => 'required',
                  'recipe_img' => 'required|image',
                  'cuisine' => 'required',
                  'recipe_meal_type' => 'required'];
        $validator = Validator::make($request->all(), $rules,
                                     ['recipe_name.required' => 'Назва Рецепту не може бути пустою',
                                      'recipe_img.required' => 'Зображення головного фото Рецепту не обрано',
                                      'recipe_img.image' => 'Обраний файл не є зображенням',
                                      'cuisine.required' => 'Кухню Рецепту не обрано',
                                      'recipe_meal_type.required' => 'Тип страви не обрано']);
        if ($validator->fails()) {
            return redirect(route('recipes.edit_general_data', $recipe_id))->withErrors($validator)
                                                               ->withInput();
        }

        $recipe_name = $request->get('recipe_name');
        $recipe_img = $request->file('recipe_img');
        $cuisine_id = $request->get('cuisine');
        $recipe_meal_type = $request->get('recipe_meal_type');
        $recipe_description = $request->get('recipe_description');
        
        $recipe_img_name = time().'.'.$recipe_img->extension();
        $recipe_img_path = "images/recipe_picture/{$recipe_img_name}";

        $recipe = Recipe::find($recipe_id);
        $recipe->name = $recipe_name;
        $recipe->user_id = Auth::user()->user_id;
        $recipe->cuisine_id = $cuisine_id;
        $recipe->meal_type = $recipe_meal_type;
        $recipe->description = $recipe_description;
        $recipe->img_path = $recipe_img_path;
        $recipe->save();
        $recipe_img->move(public_path('images/recipe_picture'), $recipe_img_name);

        return redirect(route('recipes.show', ['recipe_id' => $recipe_id, 'edit_mode' => true]));
    }

    public function destroy($recipe_id) {
        $recipe = Recipe::find($recipe_id);
        if(File::exists($recipe->img_path))
            File::delete($recipe->img_path);
        $recipe->delete();

        return redirect(route('recipes.show_user', Auth::user()->user_id));
    }

    public function edit($recipe_id) {
        return redirect(route('recipes.show', ['recipe_id' => $recipe_id, 'edit_mode' => true]));
    }

    public function add_ingredient(Request $request, $recipe_id) {
        $recipe = Recipe::find($recipe_id);
 
        if($request->get('recipe_ingredient') != null && $request->get('amount') != null && $request->get('unit') != null) {
            $recipe->recipe_ingredients()->create(['name' => $request->get('recipe_ingredient'),
                                               'amount' => $request->get('amount'),
                                               'unit' => $request->get('unit')]);
        }

        return redirect(route('recipes.show', ['recipe_id' => $recipe_id, 'edit_mode' => true]));
    }

    public function update_ingredient(Request $request, $recipe_id, $recipe_ingredient_id) {
        $recipe = Recipe::with('recipe_ingredients')->find($recipe_id);
        $name = $request->get('recipe_ingredient');
        $amount = $request->get('amount');
        $unit = $request->get('unit');

        $recipe_ingredient = $recipe->recipe_ingredients->find($recipe_ingredient_id);
        if (isset($name)) {
            $recipe_ingredient->name = $request->get('recipe_ingredient');
        }
        if (isset($amount)) {
            $recipe_ingredient->amount = $request->get('amount');
        }
        if (isset($unit)) {
            $recipe_ingredient->unit = $request->get('unit');
        }
        $recipe_ingredient->save();

        return redirect(route('recipes.show', ['recipe_id' => $recipe_id, 'edit_mode' => true]));
    }

    public function delete_ingredient($recipe_id, $recipe_ingredient_id) {
        $recipe = Recipe::with('recipe_ingredients')->find($recipe_id);

        $recipe_ingredient = $recipe->recipe_ingredients->find($recipe_ingredient_id);
        $recipe_ingredient->delete();

        return redirect(route('recipes.show', ['recipe_id' => $recipe_id, 'edit_mode' => true]));
    }

    public function add_step(Request $request, $recipe_id) {
        $recipe = Recipe::find($recipe_id);
        $ordinal_number = $request->get('ordinal_number');
        $description = $request->get('description');

        if ($recipe->recipe_steps()->where('ordinal_number', $ordinal_number)->exists()) {
            foreach ($recipe->recipe_steps as $recipe_step) {
                if ($recipe_step->ordinal_number >= $ordinal_number) {
                    $recipe_step->ordinal_number += 1;
                    $recipe_step->save();
                }
            }
        }

        if(isset($description) && isset($ordinal_number)) {
            $recipe->recipe_steps()->create(['ordinal_number' => $ordinal_number,
                                             'description' => $description]);
        }

        return redirect(route('recipes.show', ['recipe_id' => $recipe_id, 'edit_mode' => true]));                                
    }

    public function update_step(Request $request, $recipe_id, $recipe_step_id) {
        $ordinal_number = $request->get('ordinal_number');
        $description = $request->get('description');
        
        $recipe = Recipe::find($recipe_id);
        $recipe_step = $recipe->recipe_steps->find($recipe_step_id);
        if (isset($ordinal_number)) {
            $recipe_step->ordinal_number = $ordinal_number;
        }
        if (isset($description)) {
            $recipe_step->description = $description;
        }
        $recipe_step->save();

        return redirect(route('recipes.show', ['recipe_id' => $recipe_id, 'edit_mode' => true]));
    }

    public function delete_step($recipe_id, $recipe_step_id) {
        $recipe = Recipe::find($recipe_id);
        $selected_recipe_step = $recipe->recipe_steps->find($recipe_step_id);
        $selected_recipe_step->delete();

        foreach ($recipe->recipe_steps as $recipe_step) {
            if ($recipe_step->ordinal_number > $selected_recipe_step->ordinal_number) {
                $recipe_step->ordinal_number -= 1;
                $recipe_step->save();
            }
        }

        return redirect(route('recipes.show', ['recipe_id' => $recipe_id, 'edit_mode' => true]));
    }
}
