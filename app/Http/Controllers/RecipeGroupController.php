<?php

namespace App\Http\Controllers;

use App\Models\RecipeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeGroupController extends Controller
{
    public function get_user_recipe_groups($user_id) {
        $recipe_groups = RecipeGroup::where('user_id', $user_id)->get();
        
        if (Auth::user()->user_id != $user_id) {
            $recipe_groups = $recipe_groups->where('access_modificator', 'публічна');
        }

        return view('recipe-groups')->with('user_id', $user_id)
                                    ->with('recipe_groups', $recipe_groups);
    }

    public function create($user_id) {
        return view('recipe-group/create');
    }

    public function store(Request $request, $user_id) {
        $name = $request->get('name');
        $user_id = Auth::user()->user_id;
        $img = $request->file('img');
        $description = $request->get('description');
        $access_modificator = $request->get('access_modificator');

        $img_name = time().'.'.$img->extension();
        $img->move(public_path('images/recipe_group_picture'), $img_name);
        $img_path = "images/recipe_group_picture/{$img_name}";

        $recipe_group = new RecipeGroup();
        $recipe_group->name = $name;
        $recipe_group->user_id = $user_id;
        $recipe_group->img_path = $img_path;
        $recipe_group->description = $description;
        $recipe_group->access_modificator = $access_modificator;
        $recipe_group->save();

        return redirect(route('users.show_recipe_groups', Auth::user()->user_id));
    }

    public function edit($user_id, $recipe_group_id) {
        $recipe_group = RecipeGroup::find($recipe_group_id);

        return view('recipe-group/edit')->with('recipe_group', $recipe_group);
    }

    public function update(Request $request, $user_id, $recipe_group_id) {
        $recipe_group = RecipeGroup::find($recipe_group_id);
        if ($request->hasFile('img')) {
            $img = $request->file('img');
            $img_name = time().'.'.$img->extension();
            $img->move(public_path('images/recipe_group_picture'), $img_name);
            $img_path = "images/recipe_group_picture/{$img_name}";

            $recipe_group->img_path = $img_path;
        }

        $name = $request->get('name');
        $user_id = Auth::user()->user_id;
        $description = $request->get('description');
        $access_modificator = $request->get('access_modificator');

        $recipe_group->name = $name;
        $recipe_group->user_id = $user_id;
        $recipe_group->description = $description;
        $recipe_group->access_modificator = $access_modificator;
        $recipe_group->save();

        return redirect(route('users.show_recipe_groups', Auth::user()->user_id));
    }

    public function destroy($user_id, $recipe_group_id) {
        $recipe_group = RecipeGroup::find($recipe_group_id);
        $recipe_group->delete();

        return redirect(route('users.show_recipe_groups', Auth::user()->user_id));
    }
}
