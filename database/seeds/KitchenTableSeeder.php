<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KitchenTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types_kitchen')->insert(['id'=>1, 'name'=>'Cocina', 'slugged'=>str_slug('Cocina')]);
        DB::table('types_kitchen')->insert(['id'=>2, 'name'=>'Cocina-comedor', 'slugged'=>str_slug('Cocina-comedor')]);
        DB::table('types_kitchen')->insert(['id'=>3, 'name'=>'Sin Cocina', 'slugged'=>str_slug('Sin Cocina')]);
    }
}
