<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('gametag');
            $table->integer('level');
            $table->string('rank_url');
            $table->integer('admin')->default(0);
            $table->string('picture')->default('https://thekrehlife.files.wordpress.com/2015/12/image1.jpeg?w=620');
            $table->string('hero1');
            $table->string('hero2');
            $table->string('hero3');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('p1')->unsigned();
            $table->integer('p2')->unsigned();
            $table->integer('p3')->unsigned();
            $table->integer('p4')->unsigned();
            $table->integer('p5')->unsigned();
            $table->integer('p6')->unsigned();
        });

        Schema::table('games', function (Blueprint $table) {
            $table->foreign('p1')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('p2')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('p3')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('p4')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('p5')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('p6')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
        Schema::dropIfExists('users');
    }
}
