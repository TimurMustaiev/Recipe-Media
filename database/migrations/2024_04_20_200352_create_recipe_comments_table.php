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
        Schema::create('recipe_comments', function (Blueprint $table) {
            $table->id('recipe_comment_id');
            $table->foreignId('recipe_id')->constrained('recipes', 'recipe_id')->onDelete('cascade')->nullable(false);
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade')->nullable(false);
            $table->string('description', 500)->nullable(false);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // DB::statement('ALTER TABLE recipe_comments DROP CONSTRAINT recipe_comments_recipe_id_foreign');
        Schema::dropIfExists('recipe_comments');
    }
};
