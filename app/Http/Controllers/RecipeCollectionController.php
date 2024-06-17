<?php

namespace App\Http\Controllers;

use App\Models\RecipeCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class RecipeCollectionController extends Controller
{
    public function get_user_recipe_collections($user_id) {
        $recipe_collections = RecipeCollection::where('user_id', $user_id)->latest('updated_at')->get();
        
        if (Auth::user()->user_id != $user_id) {
            $recipe_collections = $recipe_collections->where('access_modificator', 'публічна');
        }

        if(request()->has('recipe-to-add-in-collection')) {
            return view('recipe-collections')->with('user_id', $user_id)
                                             ->with('recipe_collections', $recipe_collections)
                                             ->with('recipe_to_add_in_collection', request()->query('recipe-to-add-in-collection'));
        }
        if(request()->has('recipe-added-success')) {
            return view('recipe-collections')->with('user_id', $user_id)
                                             ->with('recipe_collections', $recipe_collections)
                                             ->with('recipe_added_success', true);
        }

        return view('recipe-collections')->with('user_id', $user_id)
                                         ->with('recipe_collections', $recipe_collections);
    }

    public function get_recipe_collection($user_id, $recipe_collection_id) {
        $recipe_collection = RecipeCollection::with('recipes')->find($recipe_collection_id);

        return view('recipe-collection/overview')->with('recipe_collection', $recipe_collection)
                                                 ->with('user_id', $user_id);
    }

    public function create() {
        return view('recipe-collection/create');
    }

    public function store(Request $request) {
        $rules = ['name' => 'required', 'access_modificator' => 'required', 'img' => 'required|image'];
        $validator = Validator::make($request->all(), $rules, ['name.required' => 'Назва Збірки не може бути пустою',
                                                               'access_modificator' => 'Тип видимості Збірки не обрано',
                                                               'img.required' => 'Головне зображення Збірки не обрано',
                                                               'img.image' => 'Обраний файл не є зображенням']);
        if ($validator->fails()) {
            return redirect(route('recipe_collections.create'))->withErrors($validator)
                                                               ->withInput();
        }

        $name = $request->get('name');
        $user_id = Auth::user()->user_id;
        $img = $request->file('img');
        $description = $request->get('description');
        $access_modificator = $request->get('access_modificator');

        $img_name = time().'.'.$img->extension();
        $img->move(public_path('images/recipe_collection_picture'), $img_name);
        $img_path = "images/recipe_collection_picture/{$img_name}";

        $recipe_collection = new RecipeCollection();
        $recipe_collection->name = $name;
        $recipe_collection->user_id = $user_id;
        $recipe_collection->img_path = $img_path;
        $recipe_collection->description = $description;
        $recipe_collection->access_modificator = $access_modificator;
        $recipe_collection->save();

        return redirect(route('users.show_recipe_collections', Auth::user()->user_id));
    }

    public function edit($recipe_collection_id) {
        $recipe_collection = RecipeCollection::find($recipe_collection_id);

        return view('recipe-collection/edit')->with('recipe_collection', $recipe_collection);
    }

    public function update(Request $request, $recipe_collection_id) {
        $rules = ['name' => 'required', 'access_modificator' => 'required', 'img' => 'image'];
        $validator = Validator::make($request->all(), $rules, ['name.required' => 'Назва Збірки не може бути пустою',
                                                               'access_modificator' => 'Тип видимості Збірки не обрано',
                                                               'img.image' => 'Обраний файл не є зображенням']);
        if ($validator->fails()) {
            return redirect(route('recipe_collections.edit', $recipe_collection_id))->withErrors($validator)
                                                                                    ->withInput();
        }
        
        $recipe_collection = RecipeCollection::find($recipe_collection_id);
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $img_name = time().'.'.$img->extension();
            $img->move(public_path('images/recipe_collection_picture'), $img_name);
            $img_path = "images/recipe_collection_picture/{$img_name}";

            $recipe_collection->img_path = $img_path;
        }

        $name = $request->get('name');
        $user_id = Auth::user()->user_id;
        $description = $request->get('description');
        $access_modificator = $request->get('access_modificator');

        $recipe_collection->name = $name;
        $recipe_collection->user_id = $user_id;
        $recipe_collection->description = $description;
        $recipe_collection->access_modificator = $access_modificator;
        $recipe_collection->save();

        return redirect(route('users.show_recipe_collections', Auth::user()->user_id));
    }

    public function destroy($recipe_collection_id) {
        $recipe_collection = RecipeCollection::find($recipe_collection_id);
        if(File::exists($recipe_collection->img_path))
            File::delete($recipe_collection->img_path);
        $recipe_collection->delete();

        return redirect(route('users.show_recipe_collections', Auth::user()->user_id));
    }

    public function store_recipe_in_collection($recipe_collection_id, $recipe_id) {
        $recipe_collection = RecipeCollection::find($recipe_collection_id);
        if ($recipe_collection->recipes->find($recipe_id)) {
            $add_to_collection_error = 'Даний рецепт вже був доданий до обраної збірки.';
            return redirect(route('recipes.show', $recipe_id))->with('add_to_collection_error', $add_to_collection_error);
        }
        $recipe_collection->recipes()->attach($recipe_id);

        return redirect(route('recipe_collections.show_recipes', [Auth::user()->user_id, $recipe_collection_id]));
    }

    public function delete_recipe_from_collection($recipe_collection_id, $recipe_id) {
        $recipe_collection = RecipeCollection::find($recipe_collection_id);
        $recipe_collection->recipes()->detach($recipe_id);

        return redirect(route('recipe_collections.show_recipes', [Auth::user()->user_id, $recipe_collection_id]));
    }
}
