<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypePropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('types_property')->insert(['id'=>1, 'group_id'=>2, 'name'=>'Casa', 'slugged'=>str_slug('Casa')]);
        DB::table('types_property')->insert(['id'=>2, 'group_id'=>2, 'name'=>'Casa Independiente', 'slugged'=>str_slug('Casa Independiente')]);
        DB::table('types_property')->insert(['id'=>3, 'group_id'=>2, 'name'=>'Colonial', 'slugged'=>str_slug('Colonial')]);
        DB::table('types_property')->insert(['id'=>4, 'group_id'=>2, 'name'=>'Chalet', 'slugged'=>str_slug('Chalet')]);
        DB::table('types_property')->insert(['id'=>5, 'group_id'=>2, 'name'=>'Biplanta', 'slugged'=>str_slug('Biplanta')]);
        DB::table('types_property')->insert(['id'=>6, 'group_id'=>2, 'name'=>'Casa de Campo', 'slugged'=>str_slug('Casa de Campo')]);
        DB::table('types_property')->insert(['id'=>7, 'group_id'=>1, 'name'=>'Apartamento', 'slugged'=>str_slug('Apartamento')]);
        DB::table('types_property')->insert(['id'=>8, 'group_id'=>5, 'name'=>'Garaje', 'slugged'=>str_slug('Garaje')]);
        DB::table('types_property')->insert(['id'=>9, 'group_id'=>4, 'name'=>'Terreno', 'slugged'=>str_slug('Terreno')]);
        DB::table('types_property')->insert(['id'=>10, 'group_id'=>3, 'name'=>'Local', 'slugged'=>str_slug('Local')]);
        DB::table('types_property')->insert(['id'=>11, 'group_id'=>6, 'name'=>'Oficina', 'slugged'=>str_slug('Oficina')]);
        DB::table('types_property')->insert(['id'=>12, 'group_id'=>7, 'name'=>'Propiedad', 'slugged'=>str_slug('Propiedad')]);
    }
}
