<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesErrorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types_error')->insert(['id'=>1, 'name'=>'Anuncio repetido', 'slugged'=>'repetido']);
        DB::table('types_error')->insert(['id'=>2, 'name'=>'La dirección está mal', 'slugged'=>'direccion']);
        DB::table('types_error')->insert(['id'=>3, 'name'=>'Características del inmueble erroneas', 'slugged'=>'descripcion']);
        DB::table('types_error')->insert(['id'=>4, 'name'=>'Error en los datos de contacto', 'slugged'=>'contacto']);
        DB::table('types_error')->insert(['id'=>5, 'name'=>'El precio está mal', 'slugged'=>'precio']);
        DB::table('types_error')->insert(['id'=>6, 'name'=>'Ya está vendido o alquilado', 'slugged'=>'vendido-alquilado']);
    }
}
