<?php

use App\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Currency::create([
            'id'=>1,
            'name'=>'CUP',
            'slugged'=>'cup'
        ]);

        Currency::create([
            'id'=>2,
            'name'=>'USD',
            'slugged'=>'usd'
        ]);              
    }
}
