<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username');
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->boolean('is_admin')->default(false);
            $table->integer('active_game')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

         Schema::create('game_scores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('player_id');
            $table->integer('game_id');
            $table->integer('points')->nullable();
            $table->timestamps();
        });
        
         Schema::create('question_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('parent_id')->nullable();
            $table->timestamps();
        });


         Schema::create('game_questions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id');
            $table->integer('question_id');
        });

         Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('session_name');
            $table->dateTime('start_time')->nullable();
            $table->integer('length')->nullable();
            $table->string('hash_token');
            $table->timestamps();
        });

         Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('question_id');
            $table->string('text');
            $table->boolean('is_right');
            $table->timestamps();
        });

         Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->integer('group_id');
            $table->timestamps();
        });

         Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token')->index();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::drop('users');
        Schema::drop('game_scores');
        Schema::drop('question_groups');
        Schema::drop('game_questions');
        Schema::drop('games');
        Schema::drop('answers');
        Schema::drop('questions');
        Schema::drop('password_resets');

    }
}
