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
        Schema::create('recipe_ingredients', function (Blueprint $table) {
            $table->id('recipe_ingredient_id');
            $table->foreignId('recipe_id')->constrained('recipes', 'recipe_id')->onDelete('cascade')->nullable(false);
            $table->string('name', 50)->nullable(false);
            $table->integer('amount')->nullable(false);
            $table->enum('unit', ['г.', 'кг.', 'мл.', 'л.', 'ст.л.', 'ч.л.', 'шт.'])->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement('ALTER TABLE recipe_ingredients DROP CONSTRAINT recipe_ingredients_recipe_id_foreign');
        Schema::dropIfExists('recipe_ingredients');
    }
};
