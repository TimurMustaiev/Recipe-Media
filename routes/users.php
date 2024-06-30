<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeCollectionController;
use Illuminate\Support\Facades\Auth;

Route::get('logout', [UserController::class, 'logout'])->name('users.logout');

Route::prefix('users/{user_id}')->middleware('auth')->group(function() {
    Route::prefix('profile')->group(function() {
        Route::get('/', [UserController::class, 'show_profile'])->name('users.show_profile');
        Route::get('edit', [UserController::class, 'edit_profile'])->name('users.edit_profile');
        Route::patch('/', [UserController::class, 'update_profile'])->name('users.update_profile');
    });

    Route::get('recipes', [RecipeController::class, 'get_user_recipes'])->name('recipes.show_user');

    Route::prefix('recipe-collections')->group(function() {
        Route::get('/', [RecipeCollectionController::class, 'get_user_recipe_collections'])->name('users.show_recipe_collections');
        Route::get('{recipe_collection_id}/recipes', [RecipeCollectionController::class, 'get_recipe_collection'])->name('recipe_collections.show_recipes');
    });
});