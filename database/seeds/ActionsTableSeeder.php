<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('actions')->insert(['id'=>1, 'name'=>'Comprar', 'slugged'=>str_slug('Comprar')]);
        DB::table('actions')->insert(['id'=>2, 'name'=>'Permutar', 'slugged'=>str_slug('Permutar')]);
        DB::table('actions')->insert(['id'=>3, 'name'=>'Rentar', 'slugged'=>str_slug('Rentar')]);
        DB::table('actions')->insert(['id'=>4, 'name'=>'Búsqueda', 'slugged'=>str_slug('Búsqueda')]);
    }
}
