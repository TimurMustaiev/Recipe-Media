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
        Schema::create('recipes', function (Blueprint $table) {
            $table->id('recipe_id');
            $table->string('name', 150)->nullable(false);
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('set null');
            $table->foreignId('cuisine_id')->constrained('cuisines', 'cuisine_id')->onDelete('set null')->nullable(false);
            $table->enum('meal_type', ['головна страва', 'закуска', 'десерт', 'напій'])->nullable(false);
            $table->string('description', 500)->nullable(true);
            $table->string('img_path')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE recipes DROP CONSTRAINT recipes_cuisine_id_foreign');
        DB::statement('ALTER TABLE recipes DROP CONSTRAINT recipes_user_id_foreign');
        Schema::dropIfExists('recipes');
    }
};
