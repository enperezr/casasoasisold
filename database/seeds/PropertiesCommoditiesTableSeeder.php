<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertiesCommoditiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('properties_commodities')->insert(['id'=>1, 'property_id'=>1, 'commodity_id'=>1, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>2, 'property_id'=>2, 'commodity_id'=>8, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>3, 'property_id'=>3, 'commodity_id'=>1, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>4, 'property_id'=>3, 'commodity_id'=>2, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>5, 'property_id'=>3, 'commodity_id'=>3, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>6, 'property_id'=>2, 'commodity_id'=>2, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>7, 'property_id'=>1, 'commodity_id'=>2, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>8, 'property_id'=>1, 'commodity_id'=>3, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>9, 'property_id'=>2, 'commodity_id'=>3, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>10, 'property_id'=>4, 'commodity_id'=>1, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>11, 'property_id'=>4, 'commodity_id'=>2, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>12, 'property_id'=>3, 'commodity_id'=>2, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>13, 'property_id'=>12, 'commodity_id'=>1, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>14, 'property_id'=>3, 'commodity_id'=>2, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>15, 'property_id'=>5, 'commodity_id'=>1, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>16, 'property_id'=>5, 'commodity_id'=>2, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>17, 'property_id'=>5, 'commodity_id'=>3, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>18, 'property_id'=>6, 'commodity_id'=>1, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>19, 'property_id'=>6, 'commodity_id'=>2, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>20, 'property_id'=>2, 'commodity_id'=>4, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>21, 'property_id'=>7, 'commodity_id'=>1, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);
        DB::table('properties_commodities')->insert(['id'=>22, 'property_id'=>7, 'commodity_id'=>2, 'created_at'=>\Carbon\Carbon::now(),'updated_at'=>\Carbon\Carbon::now()]);

    }
}
