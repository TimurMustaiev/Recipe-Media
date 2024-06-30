<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecipeCollectionController;

Route::prefix('recipe-collections')->middleware('auth')->group(function() {
    Route::get('create', [RecipeCollectionController::class, 'create'])->name('recipe_collections.create');
    Route::post('store', [RecipeCollectionController::class, 'store'])->name('recipe_collections.store');

    Route::prefix('{recipe_collection_id}')->group(function() {
        Route::get('edit', [RecipeCollectionController::class, 'edit'])->name('recipe_collections.edit');
        Route::patch('/', [RecipeCollectionController::class, 'update'])->name('recipe_collections.update');
        Route::delete('/', [RecipeCollectionController::class, 'destroy'])->name('recipe_collections.destroy');

        Route::prefix('recipes/{recipe_id}')->group(function() {
            Route::post('/', [RecipeCollectionController::class, 'store_recipe_in_collection'])->name('recipe_collections.store_recipe');
            Route::delete('/', [RecipeCollectionController::class, 'delete_recipe_from_collection'])->name('recipe_collections.delete_recipe');
        });
    });
});