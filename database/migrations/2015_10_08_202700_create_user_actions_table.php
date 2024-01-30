<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('action_id')->unsigned();
            $table->integer('contact_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('frequency')->nullable();
            $table->integer('price')->nullable();
            $table->text('description')->nullable();
            $table->string('condition')->nullable();
            $table->integer('time')->default(7);
            $table->integer('user_time')->default(7);
            $table->boolean('concluded')->default(false);
            $table->boolean('published')->default(false);
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
        Schema::drop('user_actions');
    }
}
