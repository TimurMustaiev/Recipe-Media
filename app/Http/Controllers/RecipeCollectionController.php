<?php

namespace App\Http\Controllers;

use App\Models\RecipeCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class RecipeCollectionController extends Controller
{
    public function get_user_recipe_collections($user_id) {
        $recipe_collections = RecipeCollection::where('user_id', $user_id)->latest('updated_at')->get();
        
        if (Auth::user()->user_id != $user_id) {
            $recipe_collections = $recipe_collections->where('access_modificator', 'публічна');
        }

        return view('recipe-collections')->with('user_id', $user_id)
                                    ->with('recipe_collections', $recipe_collections);
    }

    public function get_recipe_collection($user_id, $recipe_collection_id) {
        $recipe_collection = RecipeCollection::with('recipes')->find($recipe_collection_id);

        return view('recipe-collection/overview')->with('recipe_collection', $recipe_collection)
                                                 ->with('user_id', $user_id);
    }

    public function create($user_id) {
        return view('recipe-collection/create');
    }

    public function store(Request $request, $user_id) {
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

    public function edit($user_id, $recipe_collection_id) {
        $recipe_collection = RecipeCollection::find($recipe_collection_id);

        return view('recipe-collection/edit')->with('recipe_collection', $recipe_collection);
    }

    public function update(Request $request, $user_id, $recipe_collection_id) {
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

    public function destroy($user_id, $recipe_collection_id) {
        $recipe_collection = RecipeCollection::find($recipe_collection_id);
        if(File::exists($recipe_collection->img_path)) //при роботі з public
            File::delete($recipe_collection->img_path);
        $recipe_collection->delete();

        return redirect(route('users.show_recipe_collections', Auth::user()->user_id));
    }

    public function add_recipe() {

    }

    public function store_recipe() {
        
    }
}
