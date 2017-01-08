<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_follows', function (Blueprint $table) {
            $table->integer('follower_id')->unsigned()->index();
            $table->foreign('follower_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('followed_id')->unsigned()->index();
            $table->foreign('followed_id')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['follower_id', 'followed_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_user');
    }
}
