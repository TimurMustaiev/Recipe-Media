<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeGroupController;
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

Route::get('log-in/', [UserController::class, 'log_in'])->name('users.log_in');
Route::post('log-in/', [UserController::class, 'log_in'])->name('users.log_in');
Route::get('log-out/', [UserController::class, 'log_out'])->name('users.log_out');
Route::get('register/', [UserController::class, 'create'])->name('users.create');

Route::get('users/{user_id}/profile/', [UserController::class, 'show_profile'])->middleware('auth')->name('users.show_profile');
Route::get('users/{user_id}/recipes/', [RecipeController::class, 'get_user_recipes'])->name('recipes.show_user');
Route::get('users/{user_id}/recipe-groups/', [RecipeGroupController::class, 'get_user_recipe_groups'])->middleware('auth')->name('users.show_recipe_groups');
Route::get('users/{user_id}/recipe-groups/{recipe_group_id}', [RecipeController::class, 'get_recipes_from_group'])->name('recipe_groups.show_recipes');

Route::get('recipes/', [RecipeController::class, 'get_all_recipes'])->name('recipes.show_all');
Route::post('recipes/', [RecipeController::class, 'search_recipes'])->name('recipes.search');
Route::get('recipes/{recipe_id}', [RecipeController::class, 'get_recipe'])->name('recipes.show');
Route::post('recipes/{recipe_id}', [RecipeController::class, 'store_rating_or_comment'])->middleware('auth')->name('recipes.show_post');
Route::get('recipes/create/1', [RecipeController::class, 'create_step_one'])->middleware('auth')->name('recipes.create_step_one');
Route::post('recipes/store/1', [RecipeController::class, 'store_step_one'])->middleware('auth')->name('recipes.store_step_one');
Route::get('recipes/create/2', [RecipeController::class, 'create_step_two'])->middleware('auth')->name('recipes.create_step_two');