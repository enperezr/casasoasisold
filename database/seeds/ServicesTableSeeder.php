<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert(['id'=>1, 'name'=>'Aire Acondicionado', 'slugged'=>str_slug('Aire Acondicionado')]);
        DB::table('services')->insert(['id'=>2, 'name'=>'Gastronomía', 'slugged'=>str_slug('Gastronomía')]);
        DB::table('services')->insert(['id'=>3, 'name'=>'Baño privado', 'slugged'=>str_slug('Baño privado')]);
        DB::table('services')->insert(['id'=>4, 'name'=>'Minibar', 'slugged'=>str_slug('Minibar')]);
        DB::table('services')->insert(['id'=>5, 'name'=>'Cocina', 'slugged'=>str_slug('Cocina')]);
        DB::table('services')->insert(['id'=>6, 'name'=>'Transporte', 'slugged'=>str_slug('Transporte')]);
        DB::table('services')->insert(['id'=>7, 'name'=>'Guía', 'slugged'=>str_slug('Guía')]);
        DB::table('services')->insert(['id'=>8, 'name'=>'TV', 'slugged'=>'tv']);
        DB::table('services')->insert(['id'=>9, 'name'=>'Internet', 'slugged'=>'internet']);
        DB::table('services')->insert(['id'=>10, 'name'=>'Despertador', 'slugged'=>'despertador']);
        DB::table('services')->insert(['id'=>11, 'name'=>'Entrada/Aposento Independiente', 'slugged'=>'independiente']);
        DB::table('services')->insert(['id'=>12, 'name'=>'Lavandería', 'slugged'=>'lavanderia']);
        DB::table('services')->insert(['id'=>13, 'name'=>'Parqueo', 'slugged'=>'parqueo']);
        DB::table('services')->insert(['id'=>14, 'name'=>'Caja Fuerte', 'slugged'=>'caja-fuerte']);
        DB::table('services')->insert(['id'=>15, 'name'=>'Teléfono', 'slugged'=>'telefono']);
    }
}
