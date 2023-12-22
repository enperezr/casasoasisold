<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function(Blueprint $table){
            $table->increments('id');
            $table->integer('property_id')->unsigned();
            $table->date('arrival_date');
            $table->string('name', 60);
            $table->string('email', 200);
            $table->integer('days');
            $table->integer('people');
            $table->text('comment')->nullable();
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
        //
    }
}
