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
        Schema::create('recipe_steps', function (Blueprint $table) {
            $table->id('recipe_step_id');
            $table->foreignId('recipe_id')->constrained('recipes', 'recipe_id')->onDelete('cascade')->nullable(false);
            $table->integer('ordinal_number')->nullable(false);
            $table->string('description')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement('ALTER TABLE recipe_steps DROP CONSTRAINT recipe_steps_recipe_id_foreign');
        Schema::dropIfExists('recipe_steps');
    }
};
