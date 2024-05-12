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
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id('user_role_id');
            $table->string('name', 30)->nullable(false);
        });

        Schema::table('users', function($table) {
            $table->foreignId('user_role_id')->constrained('user_roles', 'user_role_id')->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE users DROP CONSTRAINT users_user_role_id_foreign');
        Schema::dropIfExists('user_roles');
    }
};
