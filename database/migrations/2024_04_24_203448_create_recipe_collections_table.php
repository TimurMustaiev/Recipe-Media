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
        Schema::create('recipe_collections', function (Blueprint $table) {
            $table->id('recipe_collection_id');
            $table->string('name', 50)->nullable(false);
            $table->foreignId('user_id')->constrained('users', 'user_id')->nullable(false);
            $table->string('img_path')->nullable(false);
            $table->string('description', 250)->nullable(true);
            $table->enum('access_modificator', ['публічна', 'приватна'])->nullable(false);
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
        Schema::dropIfExists('recipe_collections');
    }
};
