<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('contacts')->insert([
            'id'=>1,
            'inmobiliaria'=>0,
            'names'=>'Pepe y Juan',
            'hours'=>'10-18',
            'phone'=>'53145578',
            'mail'=>'acromeu2010@gmail.com',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('contacts')->insert([
            'id'=>2,
            'inmobiliaria'=>1,
            'names'=>'Inmobiliaria Habana Keys',
            'hours'=>'10-18',
            'phone'=>'12345678',
            'mail'=>'habanakeys@gmail.com',
            'days'=>'1-6',
            'address'=>'Cerquitica del vedado',
            'logo'=>'habanakeys.png',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }
}
