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
        Schema::create('recipe_ratings', function (Blueprint $table) {
            $table->id('recipe_rating_id');
            $table->foreignId('recipe_id')->constrained('recipes', 'recipe_id')->nullable(false);
            $table->foreignId('user_id')->constrained('users', 'user_id')->nullable(false);
            $table->integer('value')->nullable(false);
        });
        DB::statement('ALTER TABLE recipe_ratings ADD CONSTRAINT value_range CHECK (value >= 1 AND value <= 5)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement('ALTER TABLE recipe_ratings DROP CONSTRAINT recipe_ratings_recipe_id_foreign');
        Schema::dropIfExists('recipe_ratings');
    }
};
