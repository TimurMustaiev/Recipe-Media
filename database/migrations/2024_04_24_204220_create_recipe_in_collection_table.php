<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes_in_collection', function (Blueprint $table) {
            $table->id('recipe_in_collection_id');
            $table->foreignId('recipe_collection_id')->constrained('recipe_collections', 'recipe_collection_id')->onDelete('cascade')->nullable(false);
            $table->foreignId('recipe_id')->constrained('recipes', 'recipe_id')->onDelete('cascade')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE recipes_in_collection DROP CONSTRAINT recipes_in_collection_recipe_id_foreign');
        DB::statement('ALTER TABLE recipes_in_collection DROP CONSTRAINT recipes_in_collection_recipe_collection_id_foreign');
        Schema::dropIfExists('recipes_in_collection');
    }
};
