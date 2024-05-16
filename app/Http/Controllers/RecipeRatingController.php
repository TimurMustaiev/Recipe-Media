<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RecipeRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeRatingController extends Controller
{
    public function store(Request $request, $recipe_id) {
        $recipe_rating_value = $request->get('recipe_rating');
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
