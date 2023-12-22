<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvinceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provinces')->insert(['id'=>1, 'name'=>'La Habana', 'slugged'=>str_slug('La Habana')]);
        DB::table('provinces')->insert(['id'=>2, 'name'=>'Camagüey', 'slugged'=>str_slug('Camagüey')]);
        DB::table('provinces')->insert(['id'=>3, 'name'=>'Ciego de Ávila', 'slugged'=>str_slug('Ciego de Ávila')]);
        DB::table('provinces')->insert(['id'=>4, 'name'=>'Cienfuegos', 'slugged'=>str_slug('Cienfuegos')]);
        DB::table('provinces')->insert(['id'=>5, 'name'=>'Granma', 'slugged'=>str_slug('Granma')]);
        DB::table('provinces')->insert(['id'=>6, 'name'=>'Guantánamo', 'slugged'=>str_slug('Guantánamo')]);
        DB::table('provinces')->insert(['id'=>7, 'name'=>'Holguín', 'slugged'=>str_slug('Holguín')]);
        DB::table('provinces')->insert(['id'=>8, 'name'=>'Isla de la Juventud', 'slugged'=>str_slug('Isla de la Juventud')]);
        DB::table('provinces')->insert(['id'=>9, 'name'=>'Artemisa', 'slugged'=>str_slug('Artemisa')]);
        DB::table('provinces')->insert(['id'=>10, 'name'=>'Las Tunas', 'slugged'=>str_slug('Las Tunas')]);
        DB::table('provinces')->insert(['id'=>11, 'name'=>'Matanzas', 'slugged'=>str_slug('Matanzas')]);
        DB::table('provinces')->insert(['id'=>12, 'name'=>'Mayabeque', 'slugged'=>str_slug('Mayabeque')]);
        DB::table('provinces')->insert(['id'=>13, 'name'=>'Pinar del Río', 'slugged'=>str_slug('Pinar del Río')]);
        DB::table('provinces')->insert(['id'=>14, 'name'=>'Sancti Spiritus', 'slugged'=>str_slug('Sancti Spiritus')]);
        DB::table('provinces')->insert(['id'=>15, 'name'=>'Santiago de Cuba', 'slugged'=>str_slug('Santiago de Cuba')]);
        DB::table('provinces')->insert(['id'=>16, 'name'=>'Villa Clara', 'slugged'=>str_slug('Villa Clara')]);
    }
}
