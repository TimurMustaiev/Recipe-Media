<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RecipeComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeCommentController extends Controller
{
    public function destroy($recipe_id, $recipe_comment_id) {
        $recipe_comment = RecipeComment::find($recipe_comment_id);
        $recipe_comment->delete();

        return redirect(route('recipes.show', $recipe_id));
    }

    public function store(Request $request, $recipe_id) {
        $recipe_comment_description = $request->get('recipe_comment');
        
        $recipe_comment = new RecipeComment();
        $recipe_comment->recipe_id = $recipe_id;
        $recipe_comment->user_id = Auth::user()->user_id;
        $recipe_comment->description = $recipe_comment_description;
        $recipe_comment->created_at = now();
        $recipe_comment->save();

        return redirect(route('recipes.show', $recipe_id));
    }
}
