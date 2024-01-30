<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function(Blueprint $table){
            $table->increments('id');
            $table->integer('properties_action_id')->unsigned();
            $table->integer('property_id')->unsigned();
            $table->integer('user_id')->nullable();
            $table->string('email');
            $table->string('name');
            $table->string('country')->nullable();
            $table->text('text');
            $table->boolean('published')->default(1);
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
        Schema::drop('reviews');
    }
}
