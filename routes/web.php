<?php

use App\Http\Controllers\RecipeCommentController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeCollectionController;
use App\Http\Controllers\RecipeRatingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [RecipeController::class, 'get_recent_recipes'])->name('main_page');

Route::get('log-in', [UserController::class, 'log_in'])->name('users.log_in');
Route::post('log-in', [UserController::class, 'log_in'])->name('users.log_in');
Route::get('log-out', [UserController::class, 'log_out'])->name('users.log_out');
Route::get('register', [UserController::class, 'create'])->name('users.create');

Route::get('users/{user_id}/profile', [UserController::class, 'show_profile'])->middleware('auth')->name('users.show_profile');
Route::get('users/{user_id}/recipes', [RecipeController::class, 'get_user_recipes'])->name('recipes.show_user');
Route::get('users/{user_id}/recipe-collections', [RecipeCollectionController::class, 'get_user_recipe_collections'])->middleware('auth')->name('users.show_recipe_collections');
Route::get('users/{user_id}/recipe-collections/create', [RecipeCollectionController::class, 'create'])->middleware('auth')->name('recipe_collections.create');
Route::post('users/{user_id}/recipe-collections/store', [RecipeCollectionController::class, 'store'])->middleware('auth')->name('recipe_collections.store');
Route::get('users/{user_id}/recipe-collections/{recipe_collection_id}/edit', [RecipeCollectionController::class, 'edit'])->middleware('auth')->name('recipe_collections.edit');
Route::patch('users/{user_id}/recipe-collections/{recipe_collection_id}', [RecipeCollectionController::class, 'update'])->middleware('auth')->name('recipe_collections.update');
Route::get('users/{user_id}/recipe-collections/{recipe_collection_id}', [RecipeCollectionController::class, 'get_recipes_from_collection'])->name('recipe_collections.show_recipes');
Route::delete('users/{user_id}/recipe-collections/{recipe_collection_id}', [RecipeCollectionController::class, 'destroy'])->middleware('auth')->name('recipe_collections.destroy');

Route::get('recipes', [RecipeController::class, 'get_all_recipes'])->name('recipes.show_all');
Route::post('recipes', [RecipeController::class, 'search_recipes'])->name('recipes.search');
Route::get('recipes/{recipe_id}', [RecipeController::class, 'get_recipe'])->name('recipes.show');
Route::get('recipes/create/1', [RecipeController::class, 'create_step_one'])->middleware('auth')->name('recipes.create_step_one');
Route::post('recipes/store/1', [RecipeController::class, 'store_step_one'])->middleware('auth')->name('recipes.store_step_one');
Route::get('recipes/create/2', [RecipeController::class, 'create_step_two'])->middleware('auth')->name('recipes.create_step_two');
Route::post('recipes/store/2', [RecipeController::class, 'store_step_two'])->middleware('auth')->name('recipes.store_step_two');
Route::get('recipes/create/3', [RecipeController::class, 'create_step_three'])->middleware('auth')->name('recipes.create_step_three');

Route::delete('recipes/{recipe_id}/recipe_comments/{recipe_comment_id}', [RecipeCommentController::class, 'destroy'])->middleware('auth')->name('recipe_comments.destroy');
Route::post('recipes/{recipe_id}/recipe_comments/store', [RecipeCommentController::class, 'store'])->middleware('auth')->name('recipe_comments.store');

Route::post('recipes/{recipe_id}/recipe_ratings/store', [RecipeRatingController::class, 'store'])->middleware('auth')->name('recipe_ratings.store');