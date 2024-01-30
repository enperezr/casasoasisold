<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeConstructionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types_construction')->insert([
            'id'=>1,
            'name'=>'Mampostería (Placa)',
            'slugged'=>'placa'
        ]);
        DB::table('types_construction')->insert([
            'id'=>2,
            'name'=>'Mampostería (Viga y Losa)',
            'slugged'=>'viga',
        ]);
        DB::table('types_construction')->insert([
            'id'=>3,
            'name'=>'Mampostería (Techo y Teja)',
            'slugged'=>'teja',
        ]);
        DB::table('types_construction')->insert([
            'id'=>4,
            'name'=>'Mampostería (Techo Ligero)',
            'slugged'=>'techo',
        ]);
        DB::table('types_construction')->insert([
            'id'=>5,
            'name'=>'Madera',
            'slugged'=>'madera',
        ]);
        DB::table('types_construction')->insert([
            'id'=>6,
            'name'=>'Mixto',
            'slugged'=>'mixto'
        ]);
        DB::table('types_construction')->insert([
            'id'=>7,
            'name'=>'Otro',
            'slugged'=>'otro'
        ]);
    }
}
