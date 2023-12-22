<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatePropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('states_construction')->insert([
            'id'=>1,
            'name'=>'Óptimo o nuevo',
            'slugged'=>'optimo'
        ]);
        DB::table('states_construction')->insert([
            'id'=>2,
            'name'=>'Bueno',
            'slugged'=>'bueno'
        ]);
        DB::table('states_construction')->insert([
            'id'=>3,
            'name'=>'Necesita reparación ligera',
            'slugged'=>'light',
        ]);
        DB::table('states_construction')->insert([
            'id'=>4,
            'name'=>'Necesita reparación profunda',
            'slugged'=>'deep'
        ]);
    }
}
