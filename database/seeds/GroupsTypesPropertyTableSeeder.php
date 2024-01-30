<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsTypesPropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups_type_property')->insert([
            'id'=>1,
            'name'=>'Apartamento',
            'slugged'=>str_slug('Apartamento')
        ]);
        DB::table('groups_type_property')->insert([
            'id'=>2,
            'name'=>'Casa',
            'slugged'=>str_slug('Casa')
        ]);
        DB::table('groups_type_property')->insert([
            'id'=>3,
            'name'=>'Local',
            'slugged'=>str_slug('Local')
        ]);
        DB::table('groups_type_property')->insert([
            'id'=>4,
            'name'=>'Terreno',
            'slugged'=>str_slug('Terreno')
        ]);
        DB::table('groups_type_property')->insert([
            'id'=>5,
            'name'=>'Garaje',
            'slugged'=>str_slug('Garaje')
        ]);
        DB::table('groups_type_property')->insert([
            'id'=>6,
            'name'=>'Oficina',
            'slugged'=>str_slug('Oficina')
        ]);
        DB::table('groups_type_property')->insert([
            'id'=>7,
            'name'=>'Propiedad',
            'slugged'=>str_slug('Propiedad')
        ]);
    }
}
