<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->date('date');
            $table->integer('surface')->default(0);
            $table->integer('rooms');
            $table->integer('baths')->nullable();
            $table->text('address');
            $table->integer('floors')->default(1);
            $table->integer('highness')->default(1);
            $table->integer('parcela')->default(0);
            $table->integer('property_type_id')->unsigned();
            $table->integer('construction_type_id')->unsigned();
            $table->integer('property_state_id')->unsigned();
            $table->integer('kitchen_type_id')->unsigned();
            $table->integer('province_id')->unsigned();
            $table->integer('municipio_id')->unsigned();
            $table->integer('locality_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->boolean('active')->default(true);
            $table->boolean('highlighted')->default(false);
            $table->string('latitud')->nullable();
            $table->string('longitud')->nullable();
            $table->boolean('has_images')->default(false);
            $table->string('has_virtual');
            $table->integer('rate_now')->default(0);
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
        Schema::drop('properties');
    }
}
