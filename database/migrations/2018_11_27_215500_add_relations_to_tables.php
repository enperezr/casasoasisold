<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRelationsToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('rol_id')->references('id')->on('rols')->onDelete('set null');
        });
        /* this relation pendant to discussion
         * Schema::table('messages', function (Blueprint $table) {
            $table->foreign('to')->references('id')->on('users');
        });*/
        Schema::table('municipios', function(Blueprint $table){
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });
        Schema::table('localities', function(Blueprint $table){
            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');
        });
        Schema::table('properties', function(Blueprint $table){
            $table->foreign('municipio_id')->references('id')->on('municipios');
            $table->foreign('property_type_id')->references('id')->on('types_property');
            $table->foreign('construction_type_id')->references('id')->on('types_construction');
            $table->foreign('property_state_id')->references('id')->on('states_construction');
            $table->foreign('kitchen_type_id')->references('id')->on('types_kitchen');
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('locality_id')->references('id')->on('localities')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('commodities', function(Blueprint $table){
            $table->foreign('group_id')->references('id')->on('groups_type_property');
        });

        Schema::table('properties_commodities', function(Blueprint $table){
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('commodity_id')->references('id')->on('commodities')->onDelete('cascade');
        });
        Schema::table('properties_actions', function(Blueprint $table){
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('user_action_id')->references('id')->on('user_actions')->onDelete('cascade');
        });
        Schema::table('types_property', function(Blueprint $table){
            $table->foreign('group_id')->references('id')->on('groups_type_property');
        });
        Schema::table('actions_services', function(Blueprint $table){
            $table->foreign('user_action_id')->references('id')->on('user_actions')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('set null');
        });
        Schema::table('reviews', function(Blueprint $table){
            $table->foreign('properties_action_id')->references('id')->on('properties_actions')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties');
        });
        Schema::table('rates', function(Blueprint $table){
            $table->foreign('properties_action_id')->references('id')->on('properties_actions')->onDelete('cascade');
            $table->foreign('property_id')->references('id')->on('properties');
        });
        Schema::table('reservations', function(Blueprint $table){
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('no action');
        });
        Schema::table('contacts', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('user_actions', function(Blueprint $table){
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('set null');
            $table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('rol_id');
        });
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign('to');
        });
        Schema::table('municipios', function(Blueprint $table){
            $table->dropForeign('province_id');
            $table->dropForeign('author');
        });
        Schema::table('localities', function(Blueprint $table){
            $table->dropForeign('municipio_id');
        });
        Schema::table('properties', function(Blueprint $table){
            $table->dropForeign('municipio_id');
            $table->dropForeign('property_type_id');
            $table->dropForeign('construction_type_id');
            $table->dropForeign('property_state_id');
            $table->dropForeign('kitchen_type_id');
            $table->dropForeign('action_id');
            $table->dropForeign('province_id');
            $table->dropForeign('locality_id');
        });

        Schema::table('commodities', function(Blueprint $table){
            $table->dropForeign('group_id');
        });

        Schema::table('properties_commodities', function(Blueprint $table){
            $table->dropForeign('property_id');
            $table->dropForeign('commodity_id');
        });
        Schema::table('properties_actions', function(Blueprint $table){
            $table->dropForeign('property_id');
            $table->dropForeign('action_id');
            $table->dropForeign('contact_id');
            $table->dropForeign('protected_by');
        });
        Schema::table('actions_services', function(Blueprint $table){
            $table->dropForeign('properties_action_id');
            $table->dropForeign('service_id');
            $table->dropForeign('action_id');
            $table->dropForeign('property_id');
        });
        Schema::table('reviews', function(Blueprint $table){
            $table->dropForeign('properties_action_id');
            $table->dropForeign('property_id');
        });
        Schema::table('reservations', function(Blueprint $table){
            $table->dropForeign('property->id');
        });
    }
}
