<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rols')->insert(['id'=>1, 'name'=>'user']);
        DB::table('rols')->insert(['id'=>2, 'name'=>'admin']);
    }
}
