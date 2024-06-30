<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\RecipeCommentController;
use App\Http\Controllers\RecipeRatingController;

Route::prefix('recipes')->group(function() {
    Route::get('/', [RecipeController::class, 'get_all_recipes'])->name('recipes.show_all');
    Route::get('search', [RecipeController::class, 'search_recipes'])->name('recipes.search');

    Route::prefix('create')->group(function() {
        Route::get('1', [RecipeController::class, 'create_step_one'])->middleware('auth')->name('recipes.create_step_one');
        Route::get('2', [RecipeController::class, 'create_step_two'])->middleware('auth')->name('recipes.create_step_two');
        Route::get('3', [RecipeController::class, 'create_step_three'])->middleware('auth')->name('recipes.create_step_three');
    });

    Route::prefix('store')->group(function() {
        Route::post('1', [RecipeController::class, 'store_step_one'])->middleware('auth')->name('recipes.store_step_one');
        Route::post('2', [RecipeController::class, 'store_step_two'])->middleware('auth')->name('recipes.store_step_two');
        Route::post('3', [RecipeController::class, 'store_step_three'])->middleware('auth')->name('recipes.store_step_three');
    });

    Route::prefix('{recipe_id}')->group(function() {
        Route::get('/', [RecipeController::class, 'get_recipe'])->name('recipes.show');

        Route::middleware('auth')->group(function() {
            Route::prefix('edit')->group(function() {
                Route::get('/', [RecipeController::class, 'edit'])->name('recipes.edit');
                Route::get('general-data', [RecipeController::class, 'edit_general_data'])->name('recipes.edit_general_data');
            });
            Route::patch('general-data', [RecipeController::class, 'update_general_data'])->name('recipes.update_general_data');

            Route::prefix('ingredients')->group(function() {
                Route::post('/', [RecipeController::class, 'add_ingredient'])->name('recipes.add_ingredient');

                Route::prefix('{recipe_ingredient_id}')->group(function() {
                    Route::patch('/', [RecipeController::class, 'update_ingredient'])->name('recipes.update_ingredient');
                    Route::delete('/', [RecipeController::class, 'delete_ingredient'])->name('recipes.delete_ingredient');
                });
            });

            Route::prefix('steps')->group(function() {
                Route::post('/', [RecipeController::class, 'add_step'])->name('recipes.add_step');

                Route::prefix('{recipe_step_id}')->group(function() {
                    Route::patch('/', [RecipeController::class, 'update_step'])->name('recipes.update_step');
                    Route::delete('/', [RecipeController::class, 'delete_step'])->name('recipes.delete_step');
                });
            });
        });

        Route::delete('/', [RecipeController::class, 'destroy'])->middleware('auth')->name('recipes.destroy');

        Route::prefix('recipe_comments')->middleware('auth')->group(function() {
            Route::delete('{recipe_comment_id}', [RecipeCommentController::class, 'destroy'])->name('recipe_comments.destroy');
            Route::post('store', [RecipeCommentController::class, 'store'])->name('recipe_comments.store');
        });

        Route::post('recipes/{recipe_id}/recipe_ratings/store', [RecipeRatingController::class, 'store'])->middleware('auth')->name('recipe_ratings.store');
    });
});