<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rates', function(Blueprint $table){
            $table->increments('id');
            $table->integer('properties_action_id')->unsigned();
            $table->integer('property_id')->unsigned();
            $table->integer('values_1')->default(0);
            $table->integer('values_2')->default(0);
            $table->integer('values_3')->default(0);
            $table->integer('values_4')->default(0);
            $table->integer('values_5')->default(0);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rates');
    }
}
