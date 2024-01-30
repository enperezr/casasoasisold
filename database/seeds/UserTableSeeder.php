<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Martin',
            'email'=>'martin@gmail.com',
            'mail_identity'=>'martin',
            'password'=>bcrypt('martin'),
            'rol_id'=>2,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('users')->insert([
            'name'=>'Alejandro',
            'email'=>'acromeu2010@gmail.com',
            'mail_identity'=>'claud',
            'password'=>bcrypt('claudinho'),
            'rol_id'=>1,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }
}
