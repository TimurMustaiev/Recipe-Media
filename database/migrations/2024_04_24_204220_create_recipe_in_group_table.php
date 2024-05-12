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
        Schema::create('recipes_in_group', function (Blueprint $table) {
            $table->id('recipe_in_group_id');
            $table->foreignId('recipe_group_id')->constrained('recipe_groups', 'recipe_group_id')->nullable(false);
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
        DB::statement('ALTER TABLE recipes_in_group DROP CONSTRAINT recipes_in_group_recipe_id_foreign');
        DB::statement('ALTER TABLE recipes_in_group DROP CONSTRAINT recipes_in_group_recipe_group_id_foreign');
        Schema::dropIfExists('recipes_in_group');
    }
};
