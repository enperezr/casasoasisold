<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommoditiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('commodities')->insert(['id'=>1, 'group_id'=>7, 'name'=>'Garaje', 'slugged'=>'garaje']);
        DB::table('commodities')->insert(['id'=>2, 'group_id'=>7,  'name'=>'Balcón', 'slugged'=>'balcon']);
        DB::table('commodities')->insert(['id'=>3, 'group_id'=>7,  'name'=>'Patio', 'slugged'=>'patio']);
        DB::table('commodities')->insert(['id'=>4, 'group_id'=>7,  'name'=>'Pasillo lateral', 'slugged'=>'pasillo']);
        DB::table('commodities')->insert(['id'=>5, 'group_id'=>7,  'name'=>'Amueblado', 'slugged'=>'amueblado']);
        DB::table('commodities')->insert(['id'=>6, 'group_id'=>7,  'name'=>'Alarma', 'slugged'=>'alarma']);
        DB::table('commodities')->insert(['id'=>7, 'group_id'=>7,  'name'=>'Elevador', 'slugged'=>'elevador']);
        DB::table('commodities')->insert(['id'=>8, 'group_id'=>7,  'name'=>'Terraza', 'slugged'=>'terraza']);
        DB::table('commodities')->insert(['id'=>9, 'group_id'=>7,  'name'=>'Patio de Tierra', 'slugged'=>'tierra']);
        DB::table('commodities')->insert(['id'=>10, 'group_id'=>7,  'name'=>'Piscina', 'slugged'=>'piscina']);
        DB::table('commodities')->insert(['id'=>11, 'group_id'=>7,  'name'=>'Agua las 24 Horas', 'slugged'=>'agua']);
        DB::table('commodities')->insert(['id'=>12, 'group_id'=>7,  'name'=>'Vigilancia y Seguridad', 'slugged'=>'seguridad']);
        DB::table('commodities')->insert(['id'=>13, 'group_id'=>7,  'name'=>'Teléfono', 'slugged'=>'telefono']);
        DB::table('commodities')->insert(['id'=>14, 'group_id'=>7,  'name'=>'Barbacoa', 'slugged'=>'barbacoa']);
        DB::table('commodities')->insert(['id'=>15, 'group_id'=>7,  'name'=>'Hall', 'slugged'=>'hall']);
        DB::table('commodities')->insert(['id'=>16, 'group_id'=>7,  'name'=>'Electrodomésticos', 'slugged'=>'electrodomesticos']);
        DB::table('commodities')->insert(['id'=>17, 'group_id'=>7,  'name'=>'Agua Caliente', 'slugged'=>'agua-caliente']);
        DB::table('commodities')->insert(['id'=>18, 'group_id'=>7,  'name'=>'Zona Playa', 'slugged'=>'playa']);
        DB::table('commodities')->insert(['id'=>19, 'group_id'=>7,  'name'=>'Jardín', 'slugged'=>'jardin']);
        DB::table('commodities')->insert(['id'=>20, 'group_id'=>7,  'name'=>'Puerta Calle', 'slugged'=>'puerta']);
        DB::table('commodities')->insert(['id'=>21, 'group_id'=>7,  'name'=>'Azotea Libre', 'slugged'=>'azotea']);
        DB::table('commodities')->insert(['id'=>22, 'group_id'=>7,  'name'=>'Puntal Alto', 'slugged'=>'puntal']);
        DB::table('commodities')->insert(['id'=>23, 'group_id'=>7,  'name'=>'Aire Acondicionado', 'slugged'=>'aire']);
        DB::table('commodities')->insert(['id'=>24, 'group_id'=>7,  'name'=>'Tanque Instalado', 'slugged'=>'tanque']);
        DB::table('commodities')->insert(['id'=>25, 'group_id'=>7,  'name'=>'Primera Línea de Playa', 'slugged'=>'linea-playa']);
        DB::table('commodities')->insert(['id'=>26, 'group_id'=>7,  'name'=>'Gas de la calle', 'slugged'=>'gas-calle']);
        DB::table('commodities')->insert(['id'=>27, 'group_id'=>7,  'name'=>'Cisterna Independiente', 'slugged'=>'cisterna']);
        DB::table('commodities')->insert(['id'=>28, 'group_id'=>7,  'name'=>'Portal', 'slugged'=>'portal']);
        DB::table('commodities')->insert(['id'=>29, 'group_id'=>7,  'name'=>'Electricidad 220v', 'slugged'=>'220v']);
        DB::table('commodities')->insert(['id'=>30, 'group_id'=>7,  'name'=>'Comedor Independiente', 'slugged'=>'comedor']);
        DB::table('commodities')->insert(['id'=>31, 'group_id'=>7,  'name'=>'Enrejada', 'slugged'=>'enrejada']);
    }
}
