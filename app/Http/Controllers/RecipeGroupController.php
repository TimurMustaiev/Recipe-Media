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
}
